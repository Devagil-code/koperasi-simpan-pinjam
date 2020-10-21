<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\TransaksiHarian;
use Tanggal;
use App\Periode;
use App\TransaksiHarianAnggota;
use App\TransaksiHarianBiaya;
use Money;
use App\Imports\SimpananKredit;
use Maatwebsite\Excel\Facades\Excel;
use File;
use Session;
use Illuminate\Support\Facades\DB;
use App\Anggota;

class SimpananKreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if (\Auth::user()->can('manage-kredit-simpanan')) {
            # code...
            if ($request->ajax()) {
                $transaksiHarian = TransaksiHarian::with([
                    'divisi', 'nama_anggota' => function ($sql) {
                        $sql->with('anggota');
                    }, 'sumKredit'
                ])
                    ->where('divisi_id', '1')
                    ->where('jenis_transaksi', '2');
                return DataTables::of($transaksiHarian)
                    ->editColumn('tgl', function ($transaksiHarian) {
                        return Tanggal::tanggal_id($transaksiHarian->tgl);
                    })
                    ->editColumn('jenis_pembayaran', function ($transaksiHarian) {
                        if ($transaksiHarian->jenis_pembayaran == '1') {
                            return '<span class="badge badge-success badge-pill">Cash</span>';
                        } else {
                            return '<span class="badge badge-danger badge-pill">Bank</span>';
                        }
                    })
                    ->editColumn('jenis_transaksi', function ($transaksiHarian) {
                        return '<span class="badge badge-info badge-pill">Kredit</span>';
                    })
                    ->addColumn('action', function ($transaksiHarian) {
                        return view('datatable._action-transaction', [
                            'model' => $transaksiHarian,
                            'form_url' => route('simpanan-kredit.destroy', $transaksiHarian->id),
                            'edit_url' => route('simpanan-kredit.edit', $transaksiHarian->id),
                            'can_edit' => 'edit-kredit-simpanan',
                            'can_delete' => 'delete-kredit-simpanan',
                            'confirm_message' => 'Apakah anda yakin mau menghapus Transaksi'
                        ]);
                    })
                    ->editColumn('sumKredit', function ($transaksiHarian) {
                        return Money::stringToRupiah($transaksiHarian->sumKredit->sum('nominal'));
                    })
                    ->editColumn('is_close', function ($transaksiHarian) {
                        if ($transaksiHarian->is_close == '0') {
                            return '<p class="text-primary">Aktif</p>';
                        } else {
                            return '<p class="text-danger">None Aktif</p>';
                        }
                    })
                    ->rawColumns(['jenis_pembayaran', 'jenis_transaksi', 'action', 'is_close'])
                    ->make(true);
            }
            return view('simpanan-kredit.index');
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (\Auth::user()->can('create-kredit-simpanan')) {
            # code...
            return view('simpanan-kredit.create');
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (\Auth::user()->can('create-kredit-simpanan')) {
            # code...
            $this->validate($request, [
                'tgl' => 'required',
                'divisi_id' => 'required',
                'jenis_transaksi' => 'required'
            ]);

            //Save Transaction Kopkar
            $periode = Periode::where('status', '1')->first();
            $transaksiHarian = new TransaksiHarian();
            $transaksiHarian->tgl = Tanggal::convert_tanggal($request->tgl);
            $transaksiHarian->divisi_id = $request->divisi_id;
            $transaksiHarian->jenis_pembayaran = $request->jenis_pembayaran;
            $transaksiHarian->jenis_transaksi = $request->jenis_transaksi;
            $transaksiHarian->keterangan = $request->keterangan;
            $transaksiHarian->periode_id = $periode->id;
            $transaksiHarian->save();

            //Save Transation Member Kopkar
            $transaksi_harian_anggota = new TransaksiHarianAnggota();
            $transaksi_harian_anggota->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_harian_anggota->anggota_id = $request->anggota_id;
            $transaksi_harian_anggota->save();
            $biaya = $request->biaya;

            $transaksi_biaya = new TransaksiHarianBiaya();
            $transaksi_biaya->biaya_id = '4';
            $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_biaya->nominal = Money::rupiahToString($request->nominal);
            $transaksi_biaya->save();

            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil Merubah Data Transaksi !!!"
            ]);
            activity()->log('Menambahkan Data Pengambilan Simpanan');
            return redirect()->route('simpanan-kredit.index');
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if (\Auth::user()->can('edit-kredit-simpanan')) {
            # code...
            $transaksiHarian = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harian_biayas.transaksi_harian_id', '=', 'transaksi_harians.id')
                ->join('transaksi_harian_anggotas', 'transaksi_harian_anggotas.transaksi_harian_id', '=', 'transaksi_harians.id')
                ->where('transaksi_harians.id', $id)
                ->first();
            $transaksiHarian->nominal = Money::stringToRupiah($transaksiHarian->nominal);
            $transaksiHarian->tgl = date('d-m-Y', strtotime($transaksiHarian->tgl));
            return view('simpanan-kredit.edit')->with(compact('transaksiHarian'));
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //
        if (\Auth::user()->can('edit-kredit-simpanan')) {
            # code...
            $this->validate($request, [
                'tgl' => 'required',
                'divisi_id' => 'required',
                'jenis_transaksi' => 'required'
            ]);
            //Save Transaction Kopkar
            $transaksiHarian = TransaksiHarian::find($id);
            $transaksiHarian->tgl = Tanggal::convert_tanggal($request->tgl);
            $transaksiHarian->divisi_id = $request->divisi_id;
            $transaksiHarian->jenis_pembayaran = $request->jenis_pembayaran;
            $transaksiHarian->jenis_transaksi = $request->jenis_transaksi;
            $transaksiHarian->keterangan = $request->keterangan;
            $transaksiHarian->update();

            //Save Transation Member Kopkar
            $transaksi_harian_anggota = TransaksiHarianAnggota::where('transaksi_harian_id', $id)->first();
            $transaksi_harian_anggota->anggota_id = $request->anggota_id;
            $transaksi_harian_anggota->save();
            $biaya = $request->biaya;

            $transaksi_biaya = TransaksiHarianBiaya::where('transaksi_harian_id', $id)->first();
            $transaksi_biaya->biaya_id = '4';
            $transaksi_biaya->nominal = Money::rupiahToString($request->nominal);
            $transaksi_biaya->save();

            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil Merubah Data Transaksi !!!"
            ]);
            activity()->log('Merubah Data Pengambilan Simpanan');
            return redirect()->route('simpanan-kredit.index');
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        TransaksiHarianAnggota::where('transaksi_harian_id', $id)->delete();
        TransaksiHarianBiaya::where('transaksi_harian_id', $id)->delete();
        TransaksiHarian::find($id)->delete();

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil Menghapus Transaksi !!!"
        ]);

        return redirect()->route('simpanan-kredit.index');
    }

    public function upload()
    {
        if (\Auth::user()->can('upload-kredit-simpanan')) {
            # code...
            return view('simpanan-kredit.upload');
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function doUpload(Request $request)
    {
        $this->validate($request, [
			'file' => 'required'
		]);
        $periode = Periode::where('status', '1')->first();
        // menangkap file excel
        try {
            Excel::import(new SimpananKredit($periode), request()->file('file'));
            activity()->log('Upload Data Simpanan Kredit');
            return redirect()->route('simpanan-kredit.index')->with('success', __('Data Simpanan Kredit Telah Sukses Di Tambahkan'));
        }catch (\Maatwebsite\Excel\Validators\ValidationException $e){
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                foreach($failure->errors() as $key)
                {
                    return redirect()->route('simpanan-kredit.index')->with('error', $key);
                }
                $failure->values(); // The values of the row that has failed.
            }
        }
    }

    public function closeBook()
    {
        $periode = Periode::where('status', '1')->first();
        $want_close = Periode::where('status', 2)->first();
        $anggota = Anggota::select()->where('status', 1)->get();
        foreach ($anggota as $row) {
            $transaksiHarian = new TransaksiHarian();
            $transaksiHarian->tgl = Tanggal::convert_tanggal($periode->open_date);
            $transaksiHarian->divisi_id = '1';
            $transaksiHarian->jenis_pembayaran = '1';
            $transaksiHarian->jenis_transaksi = '2';
            $transaksiHarian->keterangan = 'Saldo Awal Periode ' . $periode->name;
            $transaksiHarian->periode_id = $periode->id;
            $transaksiHarian->save();
            //SUMP SIMPANAN KREDIT
            $sum_kredit = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$want_close->open_date, $want_close->close_date])
                ->where('transaksi_harian_anggotas.anggota_id', $row->id)
                ->where('transaksi_harian_biayas.biaya_id', '4')
                ->where('divisi_id', '1')
                ->sum('transaksi_harian_biayas.nominal');
            //Store Simpanan Kredit
            $transaksi_biaya = new TransaksiHarianBiaya();
            $transaksi_biaya->biaya_id = '4';
            $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_biaya->nominal = $sum_kredit;
            $transaksi_biaya->save();

            //Save Transation Member Kopkar
            $transaksi_harian_anggota = new TransaksiHarianAnggota();
            $transaksi_harian_anggota->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_harian_anggota->anggota_id = $row->id;
            $transaksi_harian_anggota->save();

            //Update Simpanan All
            $transaksi_harian = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$want_close->open_date, $want_close->close_date])
                ->where('transaksi_harian_anggotas.anggota_id', $row->id)
                ->where('divisi_id', '1')
                ->where('transaksi_harian_biayas.biaya_id', '4')
                ->select('transaksi_harians.id as id')
                ->get();

            foreach ($transaksi_harian as $item) {
                $transaksi_harian = TransaksiHarian::find($item->id);
                $transaksi_harian->is_close = '1';
                $transaksi_harian->update();
            }
        }
        activity()->log('Mengupload Data Pengambilan Simpanan');
        return redirect()->route('simpanan-kredit.index');
    }
}
