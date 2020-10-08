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
use App\Exports\ExportSimpananAll;
use App\Exports\ExportPinjamanAll;
use App\Exports\LaporanSimpananAll;
use App\Exports\LaporanPinjamanAll;
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
        if (\Auth::user()->can('manage-laporan-simpanan-all')) {
            $anggota = Anggota::where('status', 1)->get();
            return view('laporan.simpanan-all', compact('anggota'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function validationSimpanan(Request $request)
    {
        if ($request->ajax()) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'start_date' => 'required',
                    'end_date' => 'required',
                    "anggota"    => "required|array|min:1",
                    "anggota.*"  => "required",
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return response()->json([
                    'error' => $messages->first()
                ]);
            }
        }
    }

    public function exportSimpanan(Request $request)
    {
        if ($request->ajax()) {
            $tgl_awal = Tanggal::convert_tanggal($request->start_date);
            $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
            $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
            $periode_aktif = Periode::where('status', 1)->first();
            $anggota = $request->anggota;
            $anggotas = Anggota::whereIn('id', $anggota)->get();

            return Excel::download(new ExportSimpananAll($anggotas, $tgl_awal, $tgl_akhir, $date_before, $periode_aktif), Tanggal::tanggal_id($tgl_awal) . ' sampai ' . Tanggal::tanggal_id($tgl_akhir) . '-simpanan.xlsx');
        }
    }

    public function pinjamanAll(Request $request)
    {
        if (\Auth::user()->can('manage-laporan-pinjaman-all')) {
            $anggota = Anggota::where('status', 1)->get();
            return view('laporan.pinjaman-all', compact('anggota'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function validationPinjaman(Request $request)
    {
        if ($request->ajax()) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'start_date' => 'required',
                    'end_date' => 'required',
                    "anggota"    => "required|array|min:1",
                    "anggota.*"  => "required",
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return response()->json([
                    'error' => $messages->first()
                ]);
            }
        }
    }

    public function exportPinjaman(Request $request)
    {
        if ($request->ajax()) {
            $tgl_awal = Tanggal::convert_tanggal($request->start_date);
            $tgl_akhir = Tanggal::convert_tanggal($request->end_date);
            $date_before = date('Y-m-d', strtotime($tgl_awal . ' -1 day'));
            $periode_aktif = Periode::where('status', 1)->first();
            $anggota = $request->anggota;
            $anggotas = Anggota::whereIn('id', $anggota)->get();

            return Excel::download(new ExportPinjamanAll($anggotas, $tgl_awal, $tgl_akhir, $date_before, $periode_aktif), Tanggal::tanggal_id($tgl_awal) . ' sampai ' . Tanggal::tanggal_id($tgl_akhir) . '-Pinjaman.xlsx');
        }
    }
}
