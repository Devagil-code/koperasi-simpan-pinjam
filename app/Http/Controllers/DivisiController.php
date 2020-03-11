<?php

namespace App\Http\Controllers;

use App\Divisi;
use Illuminate\Http\Request;
use DataTables;

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
        if($request->ajax())
        {
            $divisi = Divisi::select();
            return  DataTables::of($divisi)
                        ->addColumn('action', function($divisi){
                            return view('datatable._nodelete', [
                                'model' => $divisi,
                                'form_url' => route('divisi.destroy', $divisi->id),
                                'edit_url' => route('divisi.edit', $divisi->id),
                                'confirm_message' => 'Apakah anda yakin mau menghapus pendaftaran '.$divisi->name.'?'
                            ]);
                        })
                        ->make(true);
        }
        return view('divisi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('divisi.create');
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
            'name' => 'required|unique:divisis'
        ]);

        Divisi::create($request->all());
        activity()->log('Menambahkan Data Divisi');
        return redirect()->route('divisi.index');
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
        return view('divisi.edit')->with(compact('divisi'));
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
        $this->validate($request, [
            'name' => 'required|unique:divisis,name,'.$divisi->id
        ]);
        $divisi = Divisi::find($divisi->id);
        $divisi->name = $request->name;
        $divisi->update();
        activity()->log('Merubah Data Divisi');
        return redirect()->route('divisi.index');
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
