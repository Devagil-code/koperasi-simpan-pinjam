<?php

namespace App\Http\Controllers;

use App\TransaksiHarianAnggota;
use Illuminate\Http\Request;

class TransaksiHarianAnggotaController extends Controller
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
     * @param  \App\TransaksiHarianAnggota  $transaksiHarianAnggota
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiHarianAnggota $transaksiHarianAnggota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TransaksiHarianAnggota  $transaksiHarianAnggota
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiHarianAnggota $transaksiHarianAnggota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TransaksiHarianAnggota  $transaksiHarianAnggota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransaksiHarianAnggota $transaksiHarianAnggota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransaksiHarianAnggota  $transaksiHarianAnggota
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiHarianAnggota $transaksiHarianAnggota)
    {
        //
    }
}
