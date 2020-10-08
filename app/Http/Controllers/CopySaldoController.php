<?php

namespace App\Http\Controllers;

use App\CopySaldo;
use App\Periode;
use App\Divisi;
use Illuminate\Http\Request;
use Session;
use DataTables;

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
                'from_periode_id' => 'required',
                'to_periode_id' => 'required',
                'divisi_id' => 'required',
            ]);

            $copy_saldo = new CopySaldo();
            $copy_saldo->from_periode_id = $request->from_periode_id;
            $copy_saldo->to_periode_id = $request->to_periode_id;
            $copy_saldo->divisi_id = $request->divisi_id;
            $copy_saldo->status_saldo = 0;
            $copy_saldo->save();

            return redirect()->route('copy-saldo.index');
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
                'from_periode_id' => 'required',
                'to_periode_id' => 'required',
                'divisi_id' => 'required',
            ]);

            $copy_saldo = CopySaldo::find($copySaldo->id);
            $copy_saldo->from_periode_id = $request->from_periode_id;
            $copy_saldo->to_periode_id = $request->to_periode_id;
            $copy_saldo->divisi_id = $request->divisi_id;
            $copy_saldo->status_saldo = 0;
            $copy_saldo->update();

            return redirect()->route('copy-saldo.index');
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
        if($copy_saldo->divisi_id == 1)
        {
            echo "Divisi Simpanan";
        }else if($copy_saldo->divisi_id == 2)
        {
            echo "Divisi Pinjaman";
        }else {
            echo "Selain Divisi Pinjaman Dan Simpanan";
        }
    }
}
