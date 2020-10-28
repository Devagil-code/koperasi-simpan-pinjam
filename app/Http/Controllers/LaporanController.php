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
use Auth;
use App\Periode;

class LaporanController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cashBank(Request $request)
    {
        $tgl_awal = Tanggal::convert_tanggal($request->start_date);
        $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
        $periode_aktif = Periode::where('status', 1)->first();
        $year_periode = date('Y', strtotime($periode_aktif->open_date));
        $year_start = date('Y', strtotime($tgl_awal));
        $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
        if (!empty($request->jenis_pembayaran)) {
            if ($year_start != $year_periode) {
                return view('laporan.cash-bank');
            } else {
                $saldo_kredit = DB::table('transaksi_harians')
                    ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                    ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                    ->where('transaksi_harians.jenis_pembayaran', $request->jenis_pembayaran)
                    ->where('transaksi_harians.jenis_transaksi', 2)
                    ->sum('transaksi_harian_biayas.nominal');
                $saldo_debit = DB::table('transaksi_harians')
                    ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                    ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                    ->where('transaksi_harians.jenis_pembayaran', $request->jenis_pembayaran)
                    ->where('transaksi_harians.jenis_transaksi', 1)
                    ->sum('transaksi_harian_biayas.nominal');
                $transaksi_harian = TransaksiHarian::with(['sumKreditAll', 'sumDebitAll'])
                    ->select(['id', 'tgl', 'keterangan'])
                    ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                    ->where('jenis_pembayaran', $request->jenis_pembayaran)
                    ->orderBy('tgl', 'ASC')
                    ->get();
                if ($request->search == 'Cari') {
                    return view('laporan.cash-bank')->with(compact('transaksi_harian', 'saldo_kredit', 'saldo_debit'));
                } else {
                    if ($request->jenis_pembayaran == 1)
                        $jenis_pembayaran = 'Kas';
                    if ($request->jenis_pembayaran == 2)
                        $jenis_pembayaran = 'Bank';
                    return Excel::download(new LaporanKasBank($transaksi_harian, $saldo_kredit, $saldo_debit), Tanggal::tanggal_id($tgl_awal) . ' sampai ' . Tanggal::tanggal_id($tgl_akhir) . '-' . $jenis_pembayaran . '.xlsx');
                }
            }
        } else {
            return view('laporan.cash-bank');
        }
    }

    public function simpanan(Request $request)
    {
        $tgl_awal = Tanggal::convert_tanggal($request->start_date);
        $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
        $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
        $periode_aktif = Periode::where('status', 1)->first();
        $year_periode = date('Y', strtotime($periode_aktif->open_date));
        $year_start = date('Y', strtotime($tgl_awal));
        $user = Auth::user();
        if ($year_start != $year_periode) {
            return view('laporan.simpanan');
        } else {
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
                        return view('laporan.simpanan')->with(compact('transaksi_harian', 'anggota', 'sum_pokok', 'sum_wajib', 'sum_sukarela', 'sum_kredit_simpanan'));
                    } else {
                        return view('laporan.simpanan')->with(compact('anggota'));
                    }
                } else {
                    return view('laporan.simpanan')->with(compact('anggota'));
                }
            }else {
                if (!empty($request->anggota_id)) {
                    $transaksi_harian = TransaksiHarian::with(
                        'transaksi_harian_biaya',
                        'transaksi_harian_anggota',
                        'sumPokok',
                        'sumWajib',
                        'sumSukarela',
                        'sumKredit'
                    )
                        ->whereHas('transaksi_harian_anggota', function ($q) use ($request) {
                            $q->where('anggota_id', $request->anggota_id);
                        })
                        ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                        ->where('divisi_id', '1')
                        ->orderBy('tgl', 'ASC')
                        ->get();
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
                            return view('laporan.simpanan')->with(compact('transaksi_harian', 'anggota', 'sum_pokok', 'sum_wajib', 'sum_sukarela', 'sum_kredit_simpanan'));
                        } else {
                            return redirect()->route('laporan.simpanan');
                        }
                    } else {
                        return Excel::download(new LaporanSimpanan($transaksi_harian, $sum_pokok, $sum_wajib, $sum_sukarela, $sum_kredit_simpanan, $anggota->nik), Tanggal::tanggal_id($tgl_awal) . ' sampai ' . Tanggal::tanggal_id($tgl_akhir) . '-' . $anggota->nama . '-simpanan.xlsx');
                    }
                } else {
                    return view('laporan.simpanan');
                }
            }
        }
    }

    public function pinjaman(Request $request)
    {
        $tgl_awal = Tanggal::convert_tanggal($request->start_date);
        $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
        $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
        $periode_aktif = Periode::where('status', 1)->first();

        $year_periode = date('Y', strtotime($periode_aktif->open_date));
        $year_start = date('Y', strtotime($tgl_awal));
        $user = Auth::user();
        if ($year_start != $year_periode) {
            return view('laporan.pinjaman');
        } else {
            if ($user->roles->pluck('name')->contains('member')) {
                $anggota = Anggota::find($user->user_anggota->anggota_id);
                if ($anggota->status == '1') {
                    $anggota->status = 'Aktif';
                } else {
                    $anggota->status = 'None Aktif';
                }
                if ($request->search == 'Cari') {
                    $sum_cicilan = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $anggota->id)
                        ->where('transaksi_harian_biayas.biaya_id', '6')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
                    $sum_bunga = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $anggota->id)
                        ->where('transaksi_harian_biayas.biaya_id', '7')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
                    $sum_kredit_pinjaman = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $anggota->id)
                        ->where('transaksi_harian_biayas.biaya_id', '8')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
                    $transaksi_harian = TransaksiHarian::with('transaksi_harian_biaya', 'transaksi_harian_anggota', 'sumCicilan', 'sumBunga', 'sumKreditPinjaman')
                        ->whereHas('transaksi_harian_anggota', function ($q) use ($user) {
                            $q->where('anggota_id', $user->user_anggota->anggota_id);
                        })
                        ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                        ->where('divisi_id', '2')
                        ->orderBy('tgl', 'ASC')
                        ->get();
                    if (!empty($transaksi_harian)) {
                        return view('laporan.pinjaman')->with(compact('transaksi_harian', 'anggota', 'sum_cicilan', 'sum_bunga', 'sum_kredit_pinjaman'));
                    } else {
                        return view('laporan.pinjaman')->with(compact('anggota'));
                    }
                } else {
                    return view('laporan.pinjaman')->with(compact('anggota'));
                }
            }else {
                if (!empty($request->anggota_id)) {
                    $sum_cicilan = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $request->anggota_id)
                        ->where('transaksi_harian_biayas.biaya_id', '6')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
                    $sum_bunga = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $request->anggota_id)
                        ->where('transaksi_harian_biayas.biaya_id', '7')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
                    $sum_kredit_pinjaman = DB::table('transaksi_harians')
                        ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                        ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                        ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                        ->where('transaksi_harian_anggotas.anggota_id', $request->anggota_id)
                        ->where('transaksi_harian_biayas.biaya_id', '8')
                        ->where('divisi_id', '2')
                        ->sum('transaksi_harian_biayas.nominal');
                    $transaksi_harian = TransaksiHarian::with('transaksi_harian_biaya', 'transaksi_harian_anggota', 'sumCicilan', 'sumBunga', 'sumKreditPinjaman')
                        ->whereHas('transaksi_harian_anggota', function ($q) use ($request) {
                            $q->where('anggota_id', $request->anggota_id);
                        })
                        ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                        ->where('divisi_id', '2')
                        ->orderBy('tgl', 'ASC')
                        ->get();

                    $anggota = Anggota::find($request->anggota_id);
                    if ($anggota->status == '1') {
                        $anggota->status = 'Aktif';
                    } else {
                        $anggota->status = 'None Aktif';
                    }
                    if ($request->search == 'Cari') {
                        return view('laporan.pinjaman')->with(compact('transaksi_harian', 'anggota', 'sum_cicilan', 'sum_bunga', 'sum_kredit_pinjaman'));
                    } else {
                        return Excel::download(new LaporanPinjaman($transaksi_harian, $sum_cicilan, $sum_bunga, $sum_kredit_pinjaman, $anggota->nik), Tanggal::tanggal_id($tgl_awal) . ' sampai ' . Tanggal::tanggal_id($tgl_akhir) . '-' . $anggota->nama . '-pinjaman.xlsx');
                    }
                } else {
                    return view('laporan.pinjaman');
                }
            }
        }
    }

    public function perDivisi(Request $request)
    {
        $tgl_awal = Tanggal::convert_tanggal($request->start_date);
        $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
        $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
        $periode_aktif = Periode::where('status', 1)->first();
        $year_periode = date('Y', strtotime($periode_aktif->open_date));
        $year_start = date('Y', strtotime($tgl_awal));
        if ($year_start != $year_periode) {
            return view('laporan.per-divisi');
        } else {
            if (!empty($request->divisi_id)) {
                $divisi = Divisi::find($request->divisi_id);
                $transaksi_harian = TransaksiHarian::with(['sumKreditAll', 'sumDebitAll'])
                    ->select(['id', 'tgl', 'keterangan'])
                    ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                    ->where('divisi_id', $request->divisi_id)
                    ->orderBy('tgl', 'ASC')
                    ->get();
                $saldo_kredit = DB::table('transaksi_harians')
                    ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                    ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                    ->where('transaksi_harians.jenis_transaksi', 2)
                    ->where('divisi_id', $request->divisi_id)
                    ->sum('transaksi_harian_biayas.nominal');
                $saldo_debit = DB::table('transaksi_harians')
                    ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                    ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                    ->where('transaksi_harians.jenis_transaksi', 1)
                    ->where('divisi_id', $request->divisi_id)
                    ->sum('transaksi_harian_biayas.nominal');
                if ($request->search == 'Cari') {
                    return view('laporan.per-divisi')->with(compact('transaksi_harian', 'saldo_kredit', 'saldo_debit'));
                } else {
                    return Excel::download(new LaporanPerDivisi($transaksi_harian, $saldo_kredit, $saldo_debit), Tanggal::tanggal_id($tgl_awal) . ' sampai ' . Tanggal::tanggal_id($tgl_akhir) . '-' . $divisi->name . '.xlsx');
                }
            } else {
                return view('laporan.per-divisi');
            }
        }
    }

    public function reportSimpanan(Request $request)
    {
        return response()->json($transaksi_harian);
    }

    public function cariSimpanan(Request $request)
    {
        if($request->ajax())
        {
            $validator = \Validator::make(
                $request->all(), [
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return response()->json([
                    'error' => $messages->first()
                ]);
            }
            $tgl_awal = Tanggal::convert_tanggal($request->start_date);
            $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
            $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
            $periode_aktif = Periode::where('status', 1)->first();
            $year_periode = date('Y', strtotime($periode_aktif->open_date));
            $year_start = date('Y', strtotime($tgl_awal));
            $user = Auth::user();
            if($request->anggota_id)
            {
                $anggota = Anggota::find($request->anggota_id);
                $transaksi_harian = TransaksiHarian::with(
                    'transaksi_harian_biaya',
                    'transaksi_harian_anggota',
                    'sumPokok',
                    'sumWajib',
                    'sumSukarela',
                    'sumKredit'
                )
                    ->whereHas('transaksi_harian_anggota', function ($q) use ($anggota) {
                        $q->where('anggota_id', $anggota->id);
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
                return view('laporan.result-simpanan')->with(compact('transaksi_harian', 'anggota', 'sum_pokok', 'sum_wajib', 'sum_sukarela', 'sum_kredit_simpanan'));
            }else {
                $anggota = Anggota::find($user->user_anggota->anggota_id);
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
                return view('laporan.result-simpanan')->with(compact('transaksi_harian', 'anggota', 'sum_pokok', 'sum_wajib', 'sum_sukarela', 'sum_kredit_simpanan'));
            }
        }
    }

    public function simpananExcel(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        $tgl_awal = Tanggal::convert_tanggal($request->start_date);
        $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
        $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
        $periode_aktif = Periode::where('status', 1)->first();
        $year_periode = date('Y', strtotime($periode_aktif->open_date));
        $year_start = date('Y', strtotime($tgl_awal));
        $user = Auth::user();

        if($request->anggota_id)
        {
            $transaksi_harian = TransaksiHarian::with(
                'transaksi_harian_biaya',
                'transaksi_harian_anggota',
                'sumPokok',
                'sumWajib',
                'sumSukarela',
                'sumKredit'
            )
                ->whereHas('transaksi_harian_anggota', function ($q) use ($request) {
                    $q->where('anggota_id', $request->anggota_id);
                })
                ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                ->where('divisi_id', '1')
                ->orderBy('tgl', 'ASC')
                ->get();
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
            return Excel::download(new LaporanSimpanan($transaksi_harian, $sum_pokok, $sum_wajib, $sum_sukarela, $sum_kredit_simpanan, $anggota->nik), Tanggal::tanggal_id($tgl_awal) . ' sampai ' . Tanggal::tanggal_id($tgl_akhir) . '-' . $anggota->nama . '-simpanan.xlsx');

        }else {
            $anggota = Anggota::find($user->user_anggota->anggota_id);
            $transaksi_harian = TransaksiHarian::with(
                'transaksi_harian_biaya',
                'transaksi_harian_anggota',
                'sumPokok',
                'sumWajib',
                'sumSukarela',
                'sumKredit'
            )
                ->whereHas('transaksi_harian_anggota', function ($q) use ($anggota) {
                    $q->where('anggota_id', $anggota->id);
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
            return Excel::download(new LaporanSimpanan($transaksi_harian, $sum_pokok, $sum_wajib, $sum_sukarela, $sum_kredit_simpanan, $anggota->nik), Tanggal::tanggal_id($tgl_awal) . ' sampai ' . Tanggal::tanggal_id($tgl_akhir) . '-' . $anggota->nama . '-simpanan.xlsx');
        }
    }

    public function cariPinjaman(Request $request)
    {
        if($request->ajax())
        {
            $validator = \Validator::make(
                $request->all(), [
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return response()->json([
                    'error' => $messages->first()
                ]);
            }
            $tgl_awal = Tanggal::convert_tanggal($request->start_date);
            $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
            $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
            $periode_aktif = Periode::where('status', 1)->first();

            $year_periode = date('Y', strtotime($periode_aktif->open_date));
            $year_start = date('Y', strtotime($tgl_awal));
            $user = Auth::user();
            if($request->anggota_id)
            {
                $anggota_id = $request->anggota_id;
                $anggota = Anggota::find($anggota_id);
            }else {
                $anggota = Anggota::find($user->user_anggota->anggota_id);
                $anggota_id = $anggota->id;
            }
            $sum_cicilan = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                ->where('transaksi_harian_anggotas.anggota_id', $anggota_id)
                ->where('transaksi_harian_biayas.biaya_id', '6')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');
            $sum_bunga = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                ->where('transaksi_harian_anggotas.anggota_id', $anggota_id)
                ->where('transaksi_harian_biayas.biaya_id', '7')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');
            $sum_kredit_pinjaman = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                ->where('transaksi_harian_anggotas.anggota_id', $anggota_id)
                ->where('transaksi_harian_biayas.biaya_id', '8')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');
            $transaksi_harian = TransaksiHarian::with('transaksi_harian_biaya', 'transaksi_harian_anggota', 'sumCicilan', 'sumBunga', 'sumKreditPinjaman')
                ->whereHas('transaksi_harian_anggota', function ($q) use ($anggota_id) {
                    $q->where('anggota_id', $anggota_id);
                })
                ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                ->where('divisi_id', '2')
                ->orderBy('tgl', 'ASC')
                ->get();
            return view('laporan.result-pinjaman')->with(compact('transaksi_harian', 'anggota', 'sum_cicilan', 'sum_bunga', 'sum_kredit_pinjaman'));
        }
    }

    public function pinjamanExcel(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        $tgl_awal = Tanggal::convert_tanggal($request->start_date);
        $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
        $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
        $periode_aktif = Periode::where('status', 1)->first();

        $year_periode = date('Y', strtotime($periode_aktif->open_date));
        $year_start = date('Y', strtotime($tgl_awal));
        $user = Auth::user();
        if($request->anggota_id)
        {
            $anggota_id = $request->anggota_id;
            $anggota = Anggota::find($anggota_id);
        }else {
            $anggota = Anggota::find($user->user_anggota->anggota_id);
            $anggota_id = $anggota->id;
        }
        $sum_cicilan = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                ->where('transaksi_harian_anggotas.anggota_id', $anggota_id)
                ->where('transaksi_harian_biayas.biaya_id', '6')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');
            $sum_bunga = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                ->where('transaksi_harian_anggotas.anggota_id', $anggota_id)
                ->where('transaksi_harian_biayas.biaya_id', '7')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');
            $sum_kredit_pinjaman = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$periode_aktif->open_date, $date_before])
                ->where('transaksi_harian_anggotas.anggota_id', $anggota_id)
                ->where('transaksi_harian_biayas.biaya_id', '8')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');
            $transaksi_harian = TransaksiHarian::with('transaksi_harian_biaya', 'transaksi_harian_anggota', 'sumCicilan', 'sumBunga', 'sumKreditPinjaman')
                ->whereHas('transaksi_harian_anggota', function ($q) use ($anggota_id) {
                    $q->where('anggota_id', $anggota_id);
                })
                ->whereBetween('tgl', [$tgl_awal, $tgl_akhir])
                ->where('divisi_id', '2')
                ->orderBy('tgl', 'ASC')
                ->get();
            return Excel::download(new LaporanPinjaman($transaksi_harian, $sum_cicilan, $sum_bunga, $sum_kredit_pinjaman, $anggota->nik), Tanggal::tanggal_id($tgl_awal) . ' sampai ' . Tanggal::tanggal_id($tgl_akhir) . '-' . $anggota->nama . '-pinjaman.xlsx');
    }
}
