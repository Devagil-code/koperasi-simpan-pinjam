<?php

namespace App\Http\Controllers;

use App\Anggota;
use App\Biaya;
use App\CopySaldo;
use App\Periode;
use App\Divisi;
use Illuminate\Http\Request;
use Session;
use DataTables;
use App\TransaksiHarian;
use App\TransaksiHarianAnggota;
use App\TransaksiHarianBiaya;
use Tanggal;

class CopySaldoController extends Controller
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
        if (\Auth::user()->can('manage-copy-saldo')) {
            if ($request->ajax()) {
                $copy_saldo = CopySaldo::with('divisi', 'from_periode', 'to_periode')->select('copy_saldos.*');
                return DataTables::of($copy_saldo)
                    ->addColumn('action', function ($copy_saldo) {
                        return view('datatable.copysaldo', [
                            'edit_url' => route('copy-saldo.edit', $copy_saldo->id),
                            'copy_saldo' => route('copy-saldo.copy', $copy_saldo->id),
                            'can_edit' => 'edit-copy-saldo',
                            'model' => $copy_saldo
                        ]);
                    })
                    ->editColumn('status_saldo', function ($copy_saldo) {
                        if ($copy_saldo->status_saldo == 0) {
                            return '<span class="badge badge-gradient badge-pill">Belum dicopy</span>';
                        } elseif ($copy_saldo->status_saldo == 1) {
                            return '<span class="badge badge-danger badge-pill">Sudah dicopy</span>';
                        }
                    })
                    ->rawColumns(['status_saldo', 'action'])
                    ->make(true);
            }
            return view('copy-saldo.index');
        } else {
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
        if (\Auth::user()->can('create-copy-saldo')) {
            # code...
            return view('copy-saldo.create');
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
        if (\Auth::user()->can('create-copy-saldo')) {
            # code...
            $this->validate($request, [
                'from_periode_id' => 'required|lte:to_periode_id|different:to_periode_id',
                'to_periode_id' => 'required|gte:from_periode_id|different:from_periode_id',
                'divisi_id' => 'required',
            ]);

            $copySaldoExist = CopySaldo::where('from_periode_id', $request->from_periode_id)
                ->where('to_periode_id', $request->to_periode_id)
                ->where('divisi_id', $request->divisi_id)
                ->first();

            if ($copySaldoExist) {
                return redirect()->route('copy-saldo.index')->with('error', __('Copy Saldo Sudah Pernah Di Lakukan atau Data Sudah Ada !!'));
            } else {
                $copy_saldo = new CopySaldo();
                $copy_saldo->from_periode_id = $request->from_periode_id;
                $copy_saldo->to_periode_id = $request->to_periode_id;
                $copy_saldo->divisi_id = $request->divisi_id;
                $copy_saldo->status_saldo = 0;
                $copy_saldo->save();
                return redirect()->route('copy-saldo.index');
            }
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CopySaldo  $copySaldo
     * @return \Illuminate\Http\Response
     */
    public function show(CopySaldo $copySaldo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CopySaldo  $copySaldo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if (\Auth::user()->can('edit-copy-saldo')) {
            $copy_saldo = CopySaldo::find($id);
            return view('copy-saldo.edit')->with(compact('copy_saldo'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CopySaldo  $copySaldo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CopySaldo $copySaldo)
    {
        if (\Auth::user()->can('edit-copy-saldo')) {
            # code...
            $this->validate($request, [
                'from_periode_id' => 'required|lte:to_periode_id|different:to_periode_id',
                'to_periode_id' => 'required|gte:from_periode_id|different:from_periode_id',
                'divisi_id' => 'required',
            ]);

            $copySaldoExist = CopySaldo::where('from_periode_id', $request->from_periode_id)
                ->where('to_periode_id', $request->to_periode_id)
                ->where('divisi_id', $request->divisi_id)
                ->whereNotIn('id', [$copySaldo->id])
                ->first();
            if($copySaldoExist)
            {
                return redirect()->route('copy-saldo.index')->with('error', __('Copy Saldo Sudah Pernah Di Lakukan atau Data Sudah Ada !!'));
            }else {
                $copy_saldo = CopySaldo::find($copySaldo->id);
                $copy_saldo->from_periode_id = $request->from_periode_id;
                $copy_saldo->to_periode_id = $request->to_periode_id;
                $copy_saldo->divisi_id = $request->divisi_id;
                $copy_saldo->status_saldo = 0;
                $copy_saldo->update();

                return redirect()->route('copy-saldo.index')->with('success', __('Data Berhasil Di Update'));
            }
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CopySaldo  $copySaldo
     * @return \Illuminate\Http\Response
     */
    public function destroy(CopySaldo $copySaldo)
    {
        //
    }

    public function copySaldo($id)
    {
        $copy_saldo = CopySaldo::find($id);
        $periodeaktif = Periode::where('status', 1)->find($copy_saldo->from_periode_id);
        $periodetujuan = Periode::where('status', 0)->find($copy_saldo->to_periode_id);
        if ($periodeaktif) {
            return redirect()->back()->with('error', __('Status From Periode Masih Aktif.'));
        }
        if ($periodetujuan) {
            return redirect()->back()->with('error', __('Status Buku Tujuan Belum Aktif.'));
        }

        $from_periode = Periode::find($copy_saldo->from_periode_id);
        $to_periode = Periode::find($copy_saldo->to_periode_id);
        if ($copy_saldo->divisi_id == 1) {
            // simpanan
            $anggota = Anggota::get();
            foreach ($anggota as $row) {
                $simpanan_pokok_debet = TransaksiHarianBiaya::with('transaksi_harian')
                    ->whereHas('transaksi_harian', function ($sql) use ($from_periode, $copy_saldo, $row) {
                        $sql->with('transaksi_harian_anggota')->whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                            ->where('divisi_id', $copy_saldo->divisi_id)
                            ->where('jenis_transaksi', 1)
                            ->whereHas('transaksi_harian_anggota', function ($query) use ($row) {
                                $query->where('anggota_id', $row->id);
                            });
                    })
                    ->where('biaya_id', 1)
                    ->sum('nominal');
                $simpanan_wajib_debet = TransaksiHarianBiaya::with('transaksi_harian')
                    ->whereHas('transaksi_harian', function ($sql) use ($from_periode, $copy_saldo, $row) {
                        $sql->with('transaksi_harian_anggota')->whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                            ->where('divisi_id', $copy_saldo->divisi_id)
                            ->where('jenis_transaksi', 1)
                            ->whereHas('transaksi_harian_anggota', function ($query) use ($row) {
                                $query->where('anggota_id', $row->id);
                            });
                    })
                    ->where('biaya_id', 2)
                    ->sum('nominal');
                $simpanan_sukarela_debet = TransaksiHarianBiaya::with('transaksi_harian')
                    ->whereHas('transaksi_harian', function ($sql) use ($from_periode, $copy_saldo, $row) {
                        $sql->with('transaksi_harian_anggota')->whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                            ->where('divisi_id', $copy_saldo->divisi_id)
                            ->where('jenis_transaksi', 1)
                            ->whereHas('transaksi_harian_anggota', function ($query) use ($row) {
                                $query->where('anggota_id', $row->id);
                            });
                    })
                    ->where('biaya_id', 3)
                    ->sum('nominal');
                if ($simpanan_pokok_debet > 0 || $simpanan_wajib_debet > 0 || $simpanan_sukarela_debet > 0) {
                    $transaksi_simpanan_debet = new TransaksiHarian();
                    $transaksi_simpanan_debet->divisi_id = $copy_saldo->divisi_id;
                    $transaksi_simpanan_debet->tgl = $to_periode->open_date;
                    $transaksi_simpanan_debet->jenis_pembayaran = 1;
                    $transaksi_simpanan_debet->jenis_transaksi = 1;
                    $transaksi_simpanan_debet->periode_id = $to_periode->id;
                    $transaksi_simpanan_debet->keterangan = "Saldo Simpanan Pokok, Wajib Dan Sukarela " . $from_periode->name;
                    $transaksi_simpanan_debet->save();

                    $biaya_simpanan_debet_pokok = new TransaksiHarianBiaya();
                    $biaya_simpanan_debet_pokok->transaksi_harian_id = $transaksi_simpanan_debet->id;
                    $biaya_simpanan_debet_pokok->biaya_id = 1;
                    $biaya_simpanan_debet_pokok->nominal = $simpanan_pokok_debet;
                    $biaya_simpanan_debet_pokok->save();

                    $biaya_simpanan_debet_wajib = new TransaksiHarianBiaya();
                    $biaya_simpanan_debet_wajib->transaksi_harian_id = $transaksi_simpanan_debet->id;
                    $biaya_simpanan_debet_wajib->biaya_id = 2;
                    $biaya_simpanan_debet_wajib->nominal = $simpanan_wajib_debet;
                    $biaya_simpanan_debet_wajib->save();

                    $biaya_simpanan_debet_sukarela = new TransaksiHarianBiaya();
                    $biaya_simpanan_debet_sukarela->transaksi_harian_id = $transaksi_simpanan_debet->id;
                    $biaya_simpanan_debet_sukarela->biaya_id = 3;
                    $biaya_simpanan_debet_sukarela->nominal = $simpanan_sukarela_debet;
                    $biaya_simpanan_debet_sukarela->save();

                    $trx_anggota = new TransaksiHarianAnggota();
                    $trx_anggota->transaksi_harian_id = $transaksi_simpanan_debet->id;
                    $trx_anggota->anggota_id = $row->id;
                    $trx_anggota->save();
                }
                $simpanan_kredit = TransaksiHarianBiaya::with('transaksi_harian')
                    ->whereHas('transaksi_harian', function ($sql) use ($from_periode, $copy_saldo, $row) {
                        $sql->with('transaksi_harian_anggota')->whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                            ->where('divisi_id', $copy_saldo->divisi_id)
                            ->where('jenis_transaksi', 2)
                            ->whereHas('transaksi_harian_anggota', function ($query) use ($row) {
                                $query->where('anggota_id', $row->id);
                            });
                    })
                    ->where('biaya_id', 4)
                    ->sum('nominal');
                if ($simpanan_kredit > 0) {
                    $transaksi_simpanan_kredit = new TransaksiHarian();
                    $transaksi_simpanan_kredit->divisi_id = $copy_saldo->divisi_id;
                    $transaksi_simpanan_kredit->tgl = $to_periode->open_date;
                    $transaksi_simpanan_kredit->jenis_pembayaran = 1;
                    $transaksi_simpanan_kredit->jenis_transaksi = 2;
                    $transaksi_simpanan_kredit->periode_id = $to_periode->id;
                    $transaksi_simpanan_kredit->keterangan = "Saldo Pengambilan Simpanan " . $from_periode->name;
                    $transaksi_simpanan_kredit->save();

                    $biaya_simpanan_kredit = new TransaksiHarianBiaya();
                    $biaya_simpanan_kredit->transaksi_harian_id = $transaksi_simpanan_kredit->id;
                    $biaya_simpanan_kredit->biaya_id = 4;
                    $biaya_simpanan_kredit->nominal = $simpanan_kredit;
                    $biaya_simpanan_kredit->save();

                    $trx_anggota = new TransaksiHarianAnggota();
                    $trx_anggota->transaksi_harian_id = $transaksi_simpanan_kredit->id;
                    $trx_anggota->anggota_id = $row->id;
                    $trx_anggota->save();
                }
            }
            $transaksi_simpanan = TransaksiHarian::whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                ->where('divisi_id', $copy_saldo->divisi_id)
                ->get();
            foreach ($transaksi_simpanan as $trxsim) {
                $trx_up_simpanan = TransaksiHarian::find($trxsim->id);
                $trx_up_simpanan->is_close = 1;
                $trx_up_simpanan->update();
            }
        } else if ($copy_saldo->divisi_id == 2) {
            $anggota = Anggota::get();
            foreach ($anggota as $row) {
                $biaya_pinjaman_debet = TransaksiHarianBiaya::with('transaksi_harian')
                    ->whereHas('transaksi_harian', function ($sql) use ($from_periode, $copy_saldo, $row) {
                        $sql->with('transaksi_harian_anggota')->whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                            ->where('divisi_id', $copy_saldo->divisi_id)
                            ->where('jenis_transaksi', 1)
                            ->whereHas('transaksi_harian_anggota', function ($query) use ($row) {
                                $query->where('anggota_id', $row->id);
                            });
                    })
                    ->where('biaya_id', 6)
                    ->sum('nominal');

                $pinjaman_bunga_debet = TransaksiHarianBiaya::with('transaksi_harian')
                    ->whereHas('transaksi_harian', function ($sql) use ($from_periode, $copy_saldo, $row) {
                        $sql->with('transaksi_harian_anggota')->whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                            ->where('divisi_id', $copy_saldo->divisi_id)
                            ->where('jenis_transaksi', 1)
                            ->whereHas('transaksi_harian_anggota', function ($query) use ($row) {
                                $query->where('anggota_id', $row->id);
                            });
                    })
                    ->where('biaya_id', 7)
                    ->sum('nominal');
                $biaya_pinjaman_kredit = TransaksiHarianBiaya::with('transaksi_harian')
                    ->whereHas('transaksi_harian', function ($sql) use ($from_periode, $copy_saldo, $row) {
                        $sql->with('transaksi_harian_anggota')->whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                            ->where('divisi_id', $copy_saldo->divisi_id)
                            ->where('jenis_transaksi', 2)
                            ->whereHas('transaksi_harian_anggota', function ($query) use ($row) {
                                $query->where('anggota_id', $row->id);
                            });
                    })
                    ->where('biaya_id', 8)
                    ->sum('nominal');
                if ($biaya_pinjaman_debet > 0) {
                    $trx_pinjaman_debet = new TransaksiHarian();
                    $trx_pinjaman_debet->divisi_id = $copy_saldo->divisi_id;
                    $trx_pinjaman_debet->tgl = $to_periode->open_date;
                    $trx_pinjaman_debet->jenis_pembayaran = 1;
                    $trx_pinjaman_debet->jenis_transaksi = 1;
                    $trx_pinjaman_debet->periode_id = $to_periode->id;
                    $trx_pinjaman_debet->keterangan = "Saldo Cicilan dan Bunga " . $from_periode->name;
                    $trx_pinjaman_debet->save();

                    $biaya_pinjam_debet = new TransaksiHarianBiaya();
                    $biaya_pinjam_debet->transaksi_harian_id = $trx_pinjaman_debet->id;
                    $biaya_pinjam_debet->biaya_id = 6;
                    $biaya_pinjam_debet->nominal = $biaya_pinjaman_debet;
                    $biaya_pinjam_debet->save();

                    $biaya_bunga_debet = new TransaksiHarianBiaya();
                    $biaya_bunga_debet->transaksi_harian_id = $trx_pinjaman_debet->id;
                    $biaya_bunga_debet->biaya_id = 7;
                    $biaya_bunga_debet->nominal = $pinjaman_bunga_debet;
                    $biaya_bunga_debet->save();

                    $trx_anggota = new TransaksiHarianAnggota();
                    $trx_anggota->transaksi_harian_id = $trx_pinjaman_debet->id;
                    $trx_anggota->anggota_id = $row->id;
                    $trx_anggota->save();
                }

                if ($biaya_pinjaman_kredit > 0) {
                    $trx_pinjaman_kredit = new TransaksiHarian();
                    $trx_pinjaman_kredit->divisi_id = $copy_saldo->divisi_id;
                    $trx_pinjaman_kredit->tgl = $to_periode->open_date;
                    $trx_pinjaman_kredit->jenis_pembayaran = 1;
                    $trx_pinjaman_kredit->jenis_transaksi = 2;
                    $trx_pinjaman_kredit->periode_id = $to_periode->id;
                    $trx_pinjaman_kredit->keterangan = "Saldo Pinjaman " . $from_periode->name;
                    $trx_pinjaman_kredit->save();

                    $pinjaman_kredit = new TransaksiHarianBiaya();
                    $pinjaman_kredit->transaksi_harian_id = $trx_pinjaman_kredit->id;
                    $pinjaman_kredit->biaya_id = 8;
                    $pinjaman_kredit->nominal = $biaya_pinjaman_kredit;
                    $pinjaman_kredit->save();

                    $trx_anggota = new TransaksiHarianAnggota();
                    $trx_anggota->transaksi_harian_id = $trx_pinjaman_kredit->id;
                    $trx_anggota->anggota_id = $row->id;
                    $trx_anggota->save();
                }
            }
            $transaki_pinjaman = TransaksiHarian::whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                ->where('divisi_id', $copy_saldo->divisi_id)
                ->get();
            foreach ($transaki_pinjaman as $trxpim) {
                $trx_up_pinjaman = TransaksiHarian::find($trxpim->id);
                $trx_up_pinjaman->is_close = 1;
                $trx_up_pinjaman->update();
            }
        } else {
            $debet = TransaksiHarianBiaya::with('transaksi_harian')
                ->whereHas('transaksi_harian', function ($sql) use ($from_periode, $copy_saldo) {
                    $sql->whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                        ->where('divisi_id', $copy_saldo->divisi_id)
                        ->where('jenis_transaksi', 1);
                })
                ->sum('nominal');
            $kredit = TransaksiHarianBiaya::with('transaksi_harian')
                ->whereHas('transaksi_harian', function ($sql) use ($from_periode, $copy_saldo) {
                    $sql->whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                        ->where('divisi_id', $copy_saldo->divisi_id)
                        ->where('jenis_transaksi', 2);
                })
                ->sum('nominal');
            $divisi = Divisi::find($copy_saldo->divisi_id);
            $biaya_debet = Biaya::where('divisi_id', $copy_saldo->divisi_id)->where('jenis_biaya', 1)->first();
            $biaya_kredit = Biaya::where('divisi_id', $copy_saldo->divisi_id)->where('jenis_biaya', 2)->first();
            $transaksi_harian_debet = new TransaksiHarian();
            $transaksi_harian_debet->divisi_id = $copy_saldo->divisi_id;
            $transaksi_harian_debet->tgl = $to_periode->open_date;
            $transaksi_harian_debet->jenis_pembayaran = 1;
            $transaksi_harian_debet->jenis_transaksi = 1;
            $transaksi_harian_debet->periode_id = $to_periode->id;
            $transaksi_harian_debet->keterangan = "Saldo Debet Periode " . $from_periode->name . ' Divisi ' . $divisi->name;
            $transaksi_harian_debet->save();

            $transaksi_harian_debet_biaya = new TransaksiHarianBiaya();
            $transaksi_harian_debet_biaya->transaksi_harian_id = $transaksi_harian_debet->id;
            $transaksi_harian_debet_biaya->biaya_id = $biaya_debet->id;
            $transaksi_harian_debet_biaya->nominal = $debet;
            $transaksi_harian_debet_biaya->save();

            $transaksi_harian_kredit = new TransaksiHarian();
            $transaksi_harian_kredit->divisi_id = $copy_saldo->divisi_id;
            $transaksi_harian_kredit->tgl = $to_periode->open_date;
            $transaksi_harian_kredit->jenis_pembayaran = 1;
            $transaksi_harian_kredit->jenis_transaksi = 2;
            $transaksi_harian_kredit->keterangan = "Saldo Kredit Periode " . $from_periode->name . ' Divisi ' . $divisi->name;
            $transaksi_harian_kredit->periode_id = $to_periode->id;
            $transaksi_harian_kredit->save();

            $transaksi_harian_kredit_biaya = new TransaksiHarianBiaya();
            $transaksi_harian_kredit_biaya->transaksi_harian_id = $transaksi_harian_kredit->id;
            $transaksi_harian_kredit_biaya->biaya_id = $biaya_kredit->id;
            $transaksi_harian_kredit_biaya->nominal = $kredit;
            $transaksi_harian_kredit_biaya->save();

            $transaksi_divisi = TransaksiHarian::whereBetween('tgl', [$from_periode->open_date, $from_periode->close_date])
                ->where('divisi_id', $copy_saldo->divisi_id)
                ->get();
            foreach ($transaksi_divisi as $trxdiv) {
                $trx_up_divisi = TransaksiHarian::find($trxdiv->id);
                $trx_up_divisi->is_close = 1;
                $trx_up_divisi->update();
            }
        }

        $copy_saldo->status_saldo = 1;
        $copy_saldo->update();
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Saldo Berhasil Di Copy !!!"
        ]);

        return redirect()->route('copy-saldo.index');
    }
}
