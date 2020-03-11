<?php

namespace App\Http\Controllers;

use App\Biaya;
use Illuminate\Http\Request;
use DataTables;

class BiayaController extends Controller
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
            $biaya = Biaya::with('divisi')->select();
            return DataTables::of($biaya)
                ->editColumn('jenis_biaya', function($biaya){
                    if($biaya->jenis_biaya == '1')
                    {
                        return 'Debet';
                    }

                    if($biaya->jenis_biaya == '2')
                    {
                        return 'Kredit';
                    }
                })
                ->make(true);
        }
        return view('biaya.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('biaya.create');
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
            'name' => 'required',
            'divisi_id' => 'required',
            'jenis_biaya' => 'required'
        ]);
        $biaya = new Biaya();
        $biaya->divisi_id = $request->divisi_id;
        $biaya->name = $request->name;
        $biaya->jenis_biaya = $request->jenis_biaya;
        $biaya->save();
        activity()->log('Menambahkan Data Biaya');
        return redirect()->route('biaya.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function show(Biaya $biaya)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function edit(Biaya $biaya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Biaya $biaya)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function destroy(Biaya $biaya)
    {
        //
    }

    public function checkBiayaDebet($divisi)
    {
        $biaya = Biaya::select()->where('divisi_id', $divisi)
            ->where('jenis_biaya', '1')
            ->first();
        return response()->json($biaya);
    }

    public function checkBiayaKredit($divisi)
    {
        $biaya = Biaya::select()->where('divisi_id', $divisi)
            ->where('jenis_biaya', '2')
            ->first();
        return response()->json($biaya);
    }
}
