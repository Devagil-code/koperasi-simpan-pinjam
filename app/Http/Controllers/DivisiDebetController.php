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
use Session;
use Illuminate\Support\Facades\DB;
use App\Divisi;
use App\Biaya;

class DivisiDebetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (\Auth::user()->can('manage-debet-divisi')) {
            if ($request->ajax()) {
                $transaksiHarian = TransaksiHarian::with(['divisi', 'sumDebitAll'])
                    ->whereNotIn('divisi_id', ['1', '2'])
                    ->where('jenis_transaksi', '1');
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
                        return '<span class="badge badge-info badge-pill">Debet</span>';
                    })
                    ->addColumn('action', function ($transaksiHarian) {
                        return view('datatable._action-transaction', [
                            'model' => $transaksiHarian,
                            'form_url' => route('divisi-debet.destroy', $transaksiHarian->id),
                            'edit_url' => route('divisi-debet.edit', $transaksiHarian->id),
                            'can_edit' => 'edit-debet-divisi',
                            'can_delete' => 'delete-debet-divisi',
                            'confirm_message' => 'Apakah anda yakin mau Transaksi'
                        ]);
                    })
                    ->editColumn('sumDebitAll', function ($transaksiHarian) {
                        return Money::stringToRupiah($transaksiHarian->sumDebitAll->sum('nominal'));
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
            return view('divisi-debet.index');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (\Auth::user()->can('create-debet-divisi')) {
            return view('divisi-debet.create');
        } else {
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
        if (\Auth::user()->can('create-debet-divisi')) {
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
            $transaksi_biaya = new TransaksiHarianBiaya();
            $transaksi_biaya->biaya_id = $request->biaya_id;
            $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_biaya->nominal = Money::rupiahToString($request->nominal);
            $transaksi_biaya->save();

            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil Manambah Data Transaksi !!!"
            ]);
            activity()->log('Menambahkan Data Divisi Debet');
            return redirect()->route('divisi-debet.index');
        } else {
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
        if (\Auth::user()->can('edit-debet-divisi')) {
            $transaksiHarian = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harian_biayas.transaksi_harian_id', '=', 'transaksi_harians.id')
                ->where('transaksi_harians.id', $id)
                ->first();
            $transaksiHarian->nominal = Money::stringToRupiah($transaksiHarian->nominal);
            $transaksiHarian->tgl = date('d-m-Y', strtotime($transaksiHarian->tgl));
            return view('divisi-debet.edit')->with(compact('transaksiHarian'));
        } else {
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
        if (\Auth::user()->can('edit-debet-divisi')) {
            $this->validate($request, [
                'tgl' => 'required',
                'divisi_id' => 'required',
                'jenis_transaksi' => 'required'
            ]);

            //Save Transaction Kopkar
            //dd(Tanggal::convert_tanggal($request->tgl));
            $transaksiHarian = TransaksiHarian::find($id);
            $transaksiHarian->tgl = Tanggal::convert_tanggal($request->tgl);
            $transaksiHarian->divisi_id = $request->divisi_id;
            $transaksiHarian->jenis_pembayaran = $request->jenis_pembayaran;
            $transaksiHarian->jenis_transaksi = $request->jenis_transaksi;
            $transaksiHarian->keterangan = $request->keterangan;
            $transaksiHarian->update();

            //Update Transaksi Biaya
            $transaksi_biaya = TransaksiHarianBiaya::where('transaksi_harian_id', $id)->first();
            $transaksi_biaya->biaya_id = $request->biaya_id;
            $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_biaya->nominal = Money::rupiahToString($request->nominal);
            $transaksi_biaya->save();

            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil Merubah Data Transaksi !!!"
            ]);
            activity()->log('Merubah Data Divisi Debet');
            return redirect()->route('divisi-debet.index');
        } else {
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
        TransaksiHarianBiaya::where('transaksi_harian_id', $id)->delete();
        TransaksiHarian::find($id)->delete();
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil Menghapus Transaksi !!!"
        ]);
        activity()->log('Menghapus Data Divisi Debet');
        return redirect()->route('divisi-debet.index');
    }

    public function closeBook()
    {
        $periode = Periode::where('status', '1')->first();
        $want_close = Periode::where('status', 2)->first();
        $divisi = Divisi::select()->whereNotIn('id', [1, 2])->get();
        foreach ($divisi as $row) {
            $biaya = Biaya::select()->where('divisi_id', $row->id)->where('jenis_biaya', 1)->first();
            $transaksiHarian = new TransaksiHarian();
            $transaksiHarian->tgl = Tanggal::convert_tanggal($periode->open_date);
            $transaksiHarian->divisi_id = $row->id;
            $transaksiHarian->jenis_pembayaran = '1';
            $transaksiHarian->jenis_transaksi = '1';
            $transaksiHarian->keterangan = 'Saldo Awal Periode ' . $periode->name;
            $transaksiHarian->periode_id = $periode->id;
            $transaksiHarian->save();
            //SUMP SIMPANAN KREDIT
            $sum_debet_divisi = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$want_close->open_date, $want_close->close_date])
                ->where('transaksi_harian_biayas.biaya_id', $biaya->id)
                ->where('divisi_id', $row->id)
                ->sum('transaksi_harian_biayas.nominal');

            //Store Biaya Divisi Debet
            $transaksi_biaya = new TransaksiHarianBiaya();
            $transaksi_biaya->biaya_id = $biaya->id;
            $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_biaya->nominal = $sum_debet_divisi;
            $transaksi_biaya->save();

            //Update Simpanan All
            $transaksi_harian = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$want_close->open_date, $want_close->close_date])
                ->where('transaksi_harian_biayas.biaya_id', $biaya->id)
                ->where('divisi_id', $row->id)
                ->select('transaksi_harians.id as id')
                ->get();

            foreach ($transaksi_harian as $item) {
                $transaksi_harian = TransaksiHarian::find($item->id);
                $transaksi_harian->is_close = '1';
                $transaksi_harian->update();
            }
        }
        activity()->log('Tutup Buku Data Divisi Debet');
        return redirect()->route('divisi-debet.index');
    }
}
