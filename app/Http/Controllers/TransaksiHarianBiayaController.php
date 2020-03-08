<?php

namespace App\Http\Controllers;

use App\TransaksiHarianBiaya;
use Illuminate\Http\Request;

class TransaksiHarianBiayaController extends Controller
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
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TransaksiHarianBiaya  $transaksiHarianBiaya
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiHarianBiaya $transaksiHarianBiaya)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TransaksiHarianBiaya  $transaksiHarianBiaya
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiHarianBiaya $transaksiHarianBiaya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TransaksiHarianBiaya  $transaksiHarianBiaya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransaksiHarianBiaya $transaksiHarianBiaya)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransaksiHarianBiaya  $transaksiHarianBiaya
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiHarianBiaya $transaksiHarianBiaya)
    {
        //
    }
}
