<?php

namespace App\Http\Controllers;

use App\TransaksiHarian;
use Illuminate\Http\Request;
use DataTables;
use Tanggal;
use Illuminate\Support\Facades\Input;
use App\Anggota;
use App\TransaksiHarianAnggota;
use App\TransaksiHarianBiaya;
use App\Periode;
use Money;
use App\TransaksiPinjaman;

class TransaksiHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //
        if($request->ajax())
        {
            $transaksiHarian = TransaksiHarian::with('divisi');
            return DataTables::of($transaksiHarian)
                ->editColumn('tgl', function($transaksiHarian){
                    return Tanggal::tanggal_id($transaksiHarian->tgl);
                })
                ->editColumn('jenis_pembayaran', function($transaksiHarian){
                    if($transaksiHarian->jenis_pembayaran == '1')
                    {
                        return '<span class="badge badge-success badge-pill">Cash</span>';
                    }else {
                        return '<span class="badge badge-danger badge-pill">Bank</span>';
                    }
                })
                ->editColumn('jenis_transaksi', function($transaksiHarian){
                    if($transaksiHarian->jenis_transaksi == '1')
                    {
                        return '<span class="badge badge-primary badge-pill">Debet</span>';
                    }else {
                        return '<span class="badge badge-info badge-pill">Kredit</span>';
                    }
                })
                ->rawColumns(['jenis_pembayaran', 'jenis_transaksi'])
                ->make(true);
        }
        return view('transaksi-harian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('transaksi-harian.create');
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
        $this->validate($request, [
            'tgl' => 'required',
            'divisi_id' => 'required',
            'jenis_transaksi' => 'required'
        ]);
        $periode = Periode::where('status', '1')->first();
        $transaksiHarian = new TransaksiHarian();
        $transaksiHarian->tgl = Tanggal::convert_tanggal($request->tgl);
        $transaksiHarian->divisi_id = $request->divisi_id;
        $transaksiHarian->jenis_pembayaran = $request->jenis_pembayaran;
        $transaksiHarian->jenis_transaksi = $request->jenis_transaksi;
        $transaksiHarian->keterangan = $request->keterangan;
        $transaksiHarian->periode_id = $periode->id;
        $transaksiHarian->save();

        //Save Transaction Member
        if($request->divisi_id == '1' || $request->divisi_id == '2')
        {
            $transaksi_harian_anggota = new TransaksiHarianAnggota();
            $transaksi_harian_anggota->transaksi_harian_id = $transaksiHarian->id;
            $transaksi_harian_anggota->anggota_id = $request->anggota_id;
            $transaksi_harian_anggota->save();
        }

        if($request->divisi_id == '1')
        {
            if($request->jenis_transaksi == '2')
            {
                $transaksi_biaya = new TransaksiHarianBiaya();
                $transaksi_biaya->biaya_id = '4';
                $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
                $transaksi_biaya->nominal = Money::rupiahToString($request->nominal);
                $transaksi_biaya->save();
            }else {
                $biaya = $request->biaya;
                //dd($biaya);
                foreach($biaya as $row)
                {
                    $transaksi_biaya = new TransaksiHarianBiaya();
                    $transaksi_biaya->biaya_id = $row['biaya_id'];
                    $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
                    $transaksi_biaya->nominal = Money::rupiahToString($row['nominal']);
                    $transaksi_biaya->save();

                }
            }
        }else if($request->divisi_id == '2'){
            if($request->jenis_transaksi == '2')
            {
                $pinjaman = $request->pinjaman;
                foreach($pinjaman as $row)
                {
                    $transaksi_biaya = new TransaksiHarianBiaya();
                    $transaksi_biaya->biaya_id = '7';
                    $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
                    $transaksi_biaya->nominal = Money::rupiahToString($request->nominal);
                    $transaksi_biaya->save();
                }
                $transaksiPinjaman = new TransaksiPinjaman();
                $transaksiPinjaman->transaksi_harian_biaya_id = $transaksi_biaya->id;
                $transaksiPinjaman->lama_cicilan = $request->lama_kredit;
                $transaksiPinjaman->save();
            }else {
                $cicilan = $request->cicilan;
                //dd($biaya);
                foreach($cicilan as $row)
                {
                    $transaksi_biaya = new TransaksiHarianBiaya();
                    $transaksi_biaya->biaya_id = $row['biaya_id'];
                    $transaksi_biaya->transaksi_harian_id = $transaksiHarian->id;
                    $transaksi_biaya->nominal = Money::rupiahToString($row['nominal']);
                    $transaksi_biaya->save();

                }
            }
        }else {
            
        }
        return redirect()->route('transaksi-harian.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TransaksiHarian  $transaksiHarian
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiHarian $transaksiHarian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TransaksiHarian  $transaksiHarian
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiHarian $transaksiHarian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TransaksiHarian  $transaksiHarian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransaksiHarian $transaksiHarian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransaksiHarian  $transaksiHarian
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiHarian $transaksiHarian)
    {
        //
    }

    /** Cek Anggota Koperasi
     * @param \App\Anggota
     */
    public function cekAnggota(Request $request)
    {
        if($request->ajax())
        {
            $anggota_id = Input::get('anggota_id');
            $anggota = Anggota::find($anggota_id);
            if($anggota->status == '1')
            {
                $anggota->status = 'Aktif';
            }else {
                $anggota->status = 'None Aktif';
            }
            $anggota->tgl_daftar = Tanggal::tanggal_id($anggota->tgl_daftar);
            return response()->json($anggota);
        }
    }
}
