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

class TransaksiSimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->ajax())
        {
            $transaksiHarian = TransaksiHarian::with('divisi')
                ->where('divisi_id', '1');
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

        return view('transaksi-simpanan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('transaksi-simpanan.create');
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

        //Diferent Input
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
        return redirect()->route('transaksi-simpanan.index');
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
    }
}
