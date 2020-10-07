<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tanggal;
use App\TransaksiHarian;
use Illuminate\Support\Facades\DB;
use App\Anggota;
use App\Exports\LaporanKasBank;
use App\Exports\LaporanSimpanan;
use App\Exports\LaporanPinjaman;
use App\Exports\LaporanPerDivisi;
use Maatwebsite\Excel\Facades\Excel;
use App\Divisi;
use App\Exports\LaporanSimpananAll;
use Auth;
use App\Periode;

class LaporanAllController extends Controller
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

    public function simpananAll(Request $request)
    {
        // dd($request->all());

        $anggota = Anggota::get();
        $tgl_awal = Tanggal::convert_tanggal($request->start_date);
        $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
        $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
        $periode_aktif = Periode::where('status', 1)->first();
        $year_periode = date('Y', strtotime($periode_aktif->open_date));
        $year_start = date('Y', strtotime($tgl_awal));
        $user = Auth::user();
        if ($year_start != $year_periode) {
            return view('laporan.simpanan-all', compact('anggota'));
        } else {
            if ($user->roles->pluck('name')->contains('admin')) {
                if (!empty($request->anggota_id)) {
                    $transaksi_harian = TransaksiHarian::with(
                        [

                            'transaksi_harian_biaya',
                            'transaksi_harian_anggota' => function ($sql) {
                                $sql->with('anggota');
                            },
                            'sumPokok',
                            'sumWajib',
                            'sumSukarela',
                            'sumKredit'
                        ]
                    )
                        ->whereHas('transaksi_harian_anggota', function ($q) use ($request) {
                            $q->where('anggota_id', $request->anggota_id);
                        })
                        ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                        ->where('divisi_id', '1')
                        ->orderBy('tgl', 'ASC')
                        ->get();
                    dd($transaksi_harian);
                    $sum_pokok = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $request->anggota_id)
                        ->where('transaksi_harian_biayas.biaya_id', '1')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
                    $sum_wajib = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $request->anggota_id)
                        ->where('transaksi_harian_biayas.biaya_id', '2')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
                    $sum_sukarela = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $request->anggota_id)
                        ->where('transaksi_harian_biayas.biaya_id', '3')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
                    $sum_kredit_simpanan = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $request->anggota_id)
                        ->where('transaksi_harian_biayas.biaya_id', '4')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
                    $anggota = Anggota::find($request->anggota_id);
                    if ($anggota->status == '1') {
                        $anggota->status = 'Aktif';
                    } else {
                        $anggota->status = 'None Aktif';
                    }
                    if ($request->search == 'Cari') {
                        if (!empty($transaksi_harian)) {
                            return view('laporan.simpanan-all')->with(compact('transaksi_harian', 'anggota', 'sum_pokok', 'sum_wajib', 'sum_sukarela', 'sum_kredit_simpanan'));
                        } else {
                            return redirect()->route('laporan.simpanan-all');
                        }
                    } else {
                        return Excel::download(new LaporanSimpananAll($transaksi_harian, $sum_pokok, $sum_wajib, $sum_sukarela, $sum_kredit_simpanan), Tanggal::tanggal_id($tgl_awal) . ' sampai ' . Tanggal::tanggal_id($tgl_akhir) . '-' . $anggota->nama . '-simpanan.xlsx');
                    }
                } else {
                    return view('laporan.simpanan-all');
                }
            }
            if ($user->roles->pluck('name')->contains('member')) {

                $anggota = Anggota::find($user->user_anggota->anggota_id);

                if ($anggota->status == '1') {
                    $anggota->status = 'Aktif';
                } else {
                    $anggota->status = 'None Aktif';
                }
                if ($request->search == 'Cari') {
                    $transaksi_harian = TransaksiHarian::with(
                        'transaksi_harian_biaya',
                        'transaksi_harian_anggota',
                        'sumPokok',
                        'sumWajib',
                        'sumSukarela',
                        'sumKredit'
                    )
                        ->whereHas('transaksi_harian_anggota', function ($q) use ($user) {
                            $q->where('anggota_id', $user->user_anggota->anggota_id);
                        })
                        ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                        ->where('divisi_id', '1')
                        ->orderBy('tgl', 'ASC')
                        ->get();
                    $sum_pokok = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $anggota->id)
                        ->where('transaksi_harian_biayas.biaya_id', '1')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
                    $sum_wajib = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $anggota->id)
                        ->where('transaksi_harian_biayas.biaya_id', '2')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
                    $sum_sukarela = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $anggota->id)
                        ->where('transaksi_harian_biayas.biaya_id', '3')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
                    $sum_kredit_simpanan = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $anggota->id)
                        ->where('transaksi_harian_biayas.biaya_id', '4')
                        ->where('divisi_id', '1')
                        ->sum('transaksi_harian_biayas.nominal');
                    if (!empty($transaksi_harian)) {
                        return view('laporan.simpanan-all')->with(compact('transaksi_harian', 'anggota', 'sum_pokok', 'sum_wajib', 'sum_sukarela', 'sum_kredit_simpanan'));
                    } else {
                        return view('laporan.simpanan-all')->with(compact('anggota'));
                    }
                } else {
                    return view('laporan.simpanan-all')->with(compact('anggota'));
                }
            }
        }
    }

    public function pinjamanAll(Request $request)
    { {
            // dd($request->all());

            $anggota = Anggota::get();
            $tgl_awal = Tanggal::convert_tanggal($request->start_date);
            $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
            $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
            $periode_aktif = Periode::where('status', 1)->first();
            $year_periode = date('Y', strtotime($periode_aktif->open_date));
            $year_start = date('Y', strtotime($tgl_awal));
            $user = Auth::user();
            if ($year_start != $year_periode) {
                return view('laporan.pinjaman-all', compact('anggota'));
            } else {
                if ($user->roles->pluck('name')->contains('admin')) {
                    if (!empty($request->anggota_id)) {
                        $transaksi_harian = TransaksiHarian::with(
                            [

                                'transaksi_harian_biaya',
                                'transaksi_harian_anggota' => function ($sql) {
                                    $sql->with('anggota');
                                },
                                'sumPokok',
                                'sumWajib',
                                'sumSukarela',
                                'sumKredit'
                            ]
                        )
                            ->whereHas('transaksi_harian_anggota', function ($q) use ($request) {
                                $q->where('anggota_id', $request->anggota_id);
                            })
                            ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                            ->where('divisi_id', '1')
                            ->orderBy('tgl', 'ASC')
                            ->get();
                        dd($transaksi_harian);
                        $sum_pokok = DB::table('transaksi_harians')
                            ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                            ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                            ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                            ->where('transaksi_harian_anggotas.anggota_id', $request->anggota_id)
                            ->where('transaksi_harian_biayas.biaya_id', '1')
                            ->where('divisi_id', '1')
                            ->sum('transaksi_harian_biayas.nominal');
                        $sum_wajib = DB::table('transaksi_harians')
                            ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                            ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                            ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                            ->where('transaksi_harian_anggotas.anggota_id', $request->anggota_id)
                            ->where('transaksi_harian_biayas.biaya_id', '2')
                            ->where('divisi_id', '1')
                            ->sum('transaksi_harian_biayas.nominal');
                        $sum_sukarela = DB::table('transaksi_harians')
                            ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                            ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                            ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                            ->where('transaksi_harian_anggotas.anggota_id', $request->anggota_id)
                            ->where('transaksi_harian_biayas.biaya_id', '3')
                            ->where('divisi_id', '1')
                            ->sum('transaksi_harian_biayas.nominal');
                        $sum_kredit_simpanan = DB::table('transaksi_harians')
                            ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                            ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                            ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                            ->where('transaksi_harian_anggotas.anggota_id', $request->anggota_id)
                            ->where('transaksi_harian_biayas.biaya_id', '4')
                            ->where('divisi_id', '1')
                            ->sum('transaksi_harian_biayas.nominal');
                        $anggota = Anggota::find($request->anggota_id);
                        if ($anggota->status == '1') {
                            $anggota->status = 'Aktif';
                        } else {
                            $anggota->status = 'None Aktif';
                        }
                        if ($request->search == 'Cari') {
                            if (!empty($transaksi_harian)) {
                                return view('laporan.pinjaman-all')->with(compact('transaksi_harian', 'anggota', 'sum_pokok', 'sum_wajib', 'sum_sukarela', 'sum_kredit_simpanan'));
                            } else {
                                return redirect()->route('laporan.pinjaman-all');
                            }
                        } else {
                            return Excel::download(new LaporanSimpananAll($transaksi_harian, $sum_pokok, $sum_wajib, $sum_sukarela, $sum_kredit_simpanan), Tanggal::tanggal_id($tgl_awal) . ' sampai ' . Tanggal::tanggal_id($tgl_akhir) . '-' . $anggota->nama . '-simpanan.xlsx');
                        }
                    } else {
                        return view('laporan.pinjaman-all');
                    }
                }
                if ($user->roles->pluck('name')->contains('member')) {

                    $anggota = Anggota::find($user->user_anggota->anggota_id);

                    if ($anggota->status == '1') {
                        $anggota->status = 'Aktif';
                    } else {
                        $anggota->status = 'None Aktif';
                    }
                    if ($request->search == 'Cari') {
                        $transaksi_harian = TransaksiHarian::with(
                            'transaksi_harian_biaya',
                            'transaksi_harian_anggota',
                            'sumPokok',
                            'sumWajib',
                            'sumSukarela',
                            'sumKredit'
                        )
                            ->whereHas('transaksi_harian_anggota', function ($q) use ($user) {
                                $q->where('anggota_id', $user->user_anggota->anggota_id);
                            })
                            ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                            ->where('divisi_id', '1')
                            ->orderBy('tgl', 'ASC')
                            ->get();
                        $sum_pokok = DB::table('transaksi_harians')
                            ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                            ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                            ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                            ->where('transaksi_harian_anggotas.anggota_id', $anggota->id)
                            ->where('transaksi_harian_biayas.biaya_id', '1')
                            ->where('divisi_id', '1')
                            ->sum('transaksi_harian_biayas.nominal');
                        $sum_wajib = DB::table('transaksi_harians')
                            ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                            ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                            ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                            ->where('transaksi_harian_anggotas.anggota_id', $anggota->id)
                            ->where('transaksi_harian_biayas.biaya_id', '2')
                            ->where('divisi_id', '1')
                            ->sum('transaksi_harian_biayas.nominal');
                        $sum_sukarela = DB::table('transaksi_harians')
                            ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                            ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                            ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                            ->where('transaksi_harian_anggotas.anggota_id', $anggota->id)
                            ->where('transaksi_harian_biayas.biaya_id', '3')
                            ->where('divisi_id', '1')
                            ->sum('transaksi_harian_biayas.nominal');
                        $sum_kredit_simpanan = DB::table('transaksi_harians')
                            ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                            ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                            ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                            ->where('transaksi_harian_anggotas.anggota_id', $anggota->id)
                            ->where('transaksi_harian_biayas.biaya_id', '4')
                            ->where('divisi_id', '1')
                            ->sum('transaksi_harian_biayas.nominal');
                        if (!empty($transaksi_harian)) {
                            return view('laporan.simpanan-all')->with(compact('transaksi_harian', 'anggota', 'sum_pokok', 'sum_wajib', 'sum_sukarela', 'sum_kredit_simpanan'));
                        } else {
                            return view('laporan.simpanan-all')->with(compact('anggota'));
                        }
                    } else {
                        return view('laporan.simpanan-all')->with(compact('anggota'));
                    }
                }
            }
        }
    }
}
