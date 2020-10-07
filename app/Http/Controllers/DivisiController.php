<?php

namespace App\Http\Controllers;

use App\Divisi;
use Illuminate\Http\Request;
use DataTables;
use Session;

class DivisiController extends Controller
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
        if (\Auth::user()->can('manage-divisi')) {
            # code...
            if ($request->ajax()) {
                $divisi = Divisi::select();
                return  DataTables::of($divisi)
                    ->addColumn('action', function ($divisi) {
                        return view('datatable._nodelete', [
                            'model' => $divisi,
                            'form_url' => route('divisi.destroy', $divisi->id),
                            'edit_url' => route('divisi.edit', $divisi->id),
                            'can_edit' => 'edit-divisi',
                            'confirm_message' => 'Apakah anda yakin mau menghapus pendaftaran ' . $divisi->name . '?'
                        ]);
                    })
                    ->make(true);
            }
            return view('divisi.index');
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
        if (\Auth::user()->can('create-divisi')) {
            return view('divisi.create');
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
        //
        if (\Auth::user()->can('create-divisi')) {
            $this->validate($request, [
                'name' => 'required|unique:divisis'
            ]);

            Divisi::create($request->all());
            activity()->log('Menambahkan Data Divisi');
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Data Berhasil ditambah !!!"
            ]);
            return redirect()->route('divisi.index');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function show(Divisi $divisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function edit(Divisi $divisi)
    {
        //
        if (\Auth::user()->can('edit-divisi')) {
            # code...
            return view('divisi.edit')->with(compact('divisi'));
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Divisi $divisi)
    {
        //
        if (\Auth::user()->can('edit-divisi')) {
            $this->validate($request, [
                'name' => 'required|unique:divisis,name,' . $divisi->id
            ]);
            $divisi = Divisi::find($divisi->id);
            $divisi->name = $request->name;
            $divisi->update();
            activity()->log('Merubah Data Divisi');
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Data Berhasil diubah !!!"
            ]);
            return redirect()->route('divisi.index');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Divisi $divisi)
    {
        //
    }
}
