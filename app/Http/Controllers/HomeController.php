<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggota;
use App\Divisi;
use Illuminate\Support\Facades\DB;
use Options;
use Auth;
use App\Periode;
use App\TransaksiHarian;
use App\ActivityLog;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $periode = Periode::select()->where('status', 1)->first();
        if($user->roles->pluck( 'name' )->contains( 'admin' ))
        {

            $transaksi_harian = TransaksiHarian::with(['sumKreditAll', 'sumDebitAll'])
                ->select(['id', 'tgl', 'keterangan', 'jenis_transaksi'])
                ->orderBy('tgl', 'DESC')
                ->limit(10)
                ->get();
            $sum_pokok = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '1')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
            $sum_wajib = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '2')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
            $sum_sukarela = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '3')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
            $kredit_simpanan = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '4')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
            $debet_pinjaman = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '6')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
            $bunga_pinjaman = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '7')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
            $kredit_pinjaman = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode->open_date, $periode->close_date])
                        ->where('transaksi_harian_biayas.biaya_id', '8')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
            $countAnggota = Anggota::select()->count();
            $countDivisi = Divisi::select()->count();
            $activity_log =  ActivityLog::with('user')->limit(10)->get();
            return view('dashboard.admin')->with(compact('countAnggota', 'countDivisi', 'periode', 'sum_pokok', 'sum_wajib', 'sum_sukarela', 'kredit_simpanan', 
                    'debet_pinjaman', 'bunga_pinjaman', 'kredit_pinjaman', 'transaksi_harian', 'activity_log'));
        }
        if($user->roles->pluck( 'name' )->contains( 'admin' ))
        {
            return view('dashboard.member');
        }
    }
}
