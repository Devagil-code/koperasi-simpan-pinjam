<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use DataTables;
use Session;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permission = Permission::select();
            return  DataTables::of($permission)
                ->addColumn('action', function ($permission) {
                    return view('datatable._nodelete', [
                        'model' => $permission,
                        'form_url' => route('permission.destroy', $permission->id),
                        'edit_url' => route('permission.edit', $permission->id),
                        'confirm_message' => 'Apakah anda yakin mau menghapus pendaftaran ' . $permission->name . '?'
                    ]);
                })
                ->make(true);
        }
        return view('permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions',
            'display_name' => 'required',
            'description' => 'required'
        ]);

        Permission::create($request->all());
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Data Permission Berhasil ditambah !!!"
        ]);
        return redirect()->route('permission.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permission.edit')->with(compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name,' . $id,
            'display_name' => 'required',
            'description' => 'required',
        ]);
        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->update();
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Data Permission Berhasil update !!!"
        ]);
        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
