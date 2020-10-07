<?php

namespace App\Http\Controllers;

use App\Module;
use Illuminate\Http\Request;
use DataTables;
use PhpParser\Node\Expr\AssignOp\Mod;
use Session;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (\Auth::user()->can('manage-module')) {
            # code...
            if ($request->ajax()) {
                $module = Module::select();
                return  DataTables::of($module)
                    ->addColumn('action', function ($module) {
                        return view('datatable._nodelete', [
                            'model' => $module,
                            'form_url' => route('module.destroy', $module->id),
                            'edit_url' => route('module.edit', $module->id),
                            'can_edit' => 'edit-module',
                            'confirm_message' => 'Apakah anda yakin mau menghapus pendaftaran ' . $module->name . '?'
                        ]);
                    })
                    ->make(true);
            }
            return view('module.index');
        } else {
            # code...
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->can('create-module')) {
            return view('module.create');
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
        if (\Auth::user()->can('create-module')) {
            $this->validate($request, [
                'name' => 'required|unique:modules'
            ]);

            Module::create($request->all());
            activity()->log('Menambahkan Data Module');
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Data Berhasil ditambah !!!"
            ]);
            return redirect()->route('module.index');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        if (\Auth::user()->can('edit-module')) {
            # code...
            return view('module.edit')->with(compact('module'));
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        if (\Auth::user()->can('edit-module')) {
            $this->validate($request, [
                'name' => 'required|unique:modules,name,' . $module->id
            ]);
            $module = Module::find($module->id);
            $module->name = $request->name;
            $module->update();
            activity()->log('Merubah Data module');
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Data Berhasil diubah !!!"
            ]);
            return redirect()->route('module.index');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        //
    }
}
