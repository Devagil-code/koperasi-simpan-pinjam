<?php

namespace App\Http\Controllers;

use App\Periode;
use Illuminate\Http\Request;
use DataTables;
use Tanggal;
use Session;
use App\TransaksiHarian;

class PeriodeController extends Controller
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
        if (\Auth::user()->can('manage-periode')) {
            # code...
            if ($request->ajax()) {
                $periode = Periode::select();
                return DataTables::of($periode)
                    ->editColumn('open_date', function ($periode) {
                        return Tanggal::tanggal_id($periode->open_date);
                    })
                    ->editColumn('close_date', function ($periode) {
                        return Tanggal::tanggal_id($periode->close_date);
                    })
                    ->editColumn('status', function ($periode) {
                        if ($periode->status == '1') {
                            return '<span class="badge badge-gradient badge-pill">Aktif</span>';
                        } elseif ($periode->status == '0') {
                            return '<span class="badge badge-danger badge-pill">Non Aktif</span>';
                        }
                    })
                    ->addColumn('action', function ($periode) {
                        return view('datatable._action-default', [
                            'model' => $periode,
                            'form_url' => route('periode.destroy', $periode->id),
                            'edit_url' => route('periode.edit', $periode->id),
                            'can_edit' => 'edit-periode',
                            'can_delete' => 'delete-periode',
                            'confirm_message' => 'Apakah anda yakin mau menghapus periode'
                        ]);
                    })
                    ->editColumn('is_close', function ($periode) {
                        if ($periode->status == '1') {
                            return 'Status Masih Aktif';
                        }
                        if ($periode->is_close  == '0') {
                            return view('datatable._closebook', [
                                'model' => $periode,
                                'form_url' => route('periode.close-book', $periode->id)
                            ]);
                        }
                        if ($periode->is_close == '3') {
                            return '<p class="text-danger">Sedang Tutup Buku</p>';
                        }
                        if ($periode->is_close == '1') {
                            return '<p class="text-success">Sudah Tutup Buku</p>';
                        }
                    })
                    ->rawColumns(['status', 'action', 'is_close'])
                    ->make(true);
            }
            return view('periode.index');
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
        if (\Auth::user()->can('create-periode')) {
            # code...
            return view('periode.create');
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
        if (\Auth::user()->can('create-periode')) {
            # code...
            $this->validate($request, [
                'name' => 'required|unique:periodes',
                'open_date' => 'required',
                'close_date' => 'required',
                'status' => 'required'
            ]);
            $periode = Periode::select()->where('status', 1)->first();
            if (!empty($periode->status) == $request->status) {
                Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Masih Ada Data Periode Yang Aktif, Pastikan Sudah Tidak ada Data Periode Yang Aktif !!!"
                ]);
                return redirect()->route('periode.index');
            } else {
                $periode = new Periode();
                $periode->name = $request->name;
                $periode->open_date = date('Y-m-d', strtotime($request->open_date));
                $periode->close_date = date('Y-m-d', strtotime($request->close_date));
                $periode->status = $request->status;
                $periode->save();
                Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Data Periode Telah Di Simpan !!!"
                ]);
                activity()->log('Menambahkan Data Periode');
                return redirect()->route('periode.index');
            }
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function show(Periode $periode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function edit(Periode $periode)
    {
        //
        if (\Auth::user()->can('edit-periode')) {
            # code...
            $periode->open_date = date('d-m-Y', strtotime($periode->open_date));
            $periode->close_date = date('d-m-Y', strtotime($periode->close_date));
            return view('periode.edit')->with(compact('periode'));
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Periode $periode)
    {
        //
        if (\Auth::user()->can('edit-periode')) {
            # code...
            $this->validate($request, [
                'name' => 'required',
                'open_date' => 'required',
                'close_date' => 'required',
                'status' => 'required'
            ]);
            if ($request->status == '1') {
                $exist_periode = Periode::select()
                    ->whereNotIn('id', [$periode->id])
                    ->where('status', 1)->first();
                if (is_null($exist_periode)) {
                    $periode = Periode::find($periode->id);
                    $periode->name = $request->name;
                    $periode->open_date = date('Y-m-d', strtotime($request->open_date));
                    $periode->close_date = date('Y-m-d', strtotime($request->close_date));
                    $periode->status = $request->status;
                    $periode->update();
                    Session::flash("flash_notification", [
                        "level" => "success",
                        "message" => "Data Periode Telah Di Simpan !!!"
                    ]);
                } else {
                    Session::flash("flash_notification", [
                        "level" => "success",
                        "message" => "Masih Ada Data Periode Yang Aktif, Pastikan Sudah Tidak ada Data Periode Yang Aktif !!!"
                    ]);
                }
                return redirect()->route('periode.index');
            } else {
                $periode = Periode::find($periode->id);
                $periode->name = $request->name;
                $periode->open_date = date('Y-m-d', strtotime($request->open_date));
                $periode->close_date = date('Y-m-d', strtotime($request->close_date));
                $periode->status = $request->status;
                $periode->update();
                Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Data Periode Telah Di Simpan !!!"
                ]);
                activity()->log('Merubah Data Periode');
                return redirect()->route('periode.index');
            }
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (\Auth::user()->can('delete-periode')) {
            # code...
            Periode::find($id)->delete();
            Session::flash("flash_notification",[
                "level" => "success",
                "message" => "Berhasil Menghapus Periode"
            ]);
            return redirect()->route('periode.index');
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied'));
        }

    }
}
