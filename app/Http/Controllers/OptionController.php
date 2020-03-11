<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;
use DataTables;

class OptionController extends Controller
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
            $option = Option::select();
            return DataTables::of($option)
                ->addColumn('action', function($option){
                    return view('datatable._action-default', [
                        'model' => $option,
                        'form_url' => route('option.destroy', $option->id),
                        'edit_url' => route('option.edit', $option->id),
                        'confirm_message' => 'Apakah anda yakin mau menghapus pendaftaran '.$option->name.'?'
                    ]);
                })
                ->make(true);
        }
        return view('option.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('option.create');
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
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function show(Option $option)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function edit(Option $option)
    {
        //
        return view('option.edit')->with(compact('option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option $option)
    {
        //
        $this->validate($request, [
            'option_name' => 'required',
            'option_value' => 'required'
        ]);
        $option = Option::find($option->id);
        $option->option_name = $request->option_name;
        $option->option_value = $request->option_value;
        $option->update();
        activity()->log('Merubah Data Option');
        return redirect()->route('option.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        //
    }
}
