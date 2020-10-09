<?php

namespace App\Http\Controllers;

use App\Module;
use App\PermissionRole;
use App\Role;
use Illuminate\Http\Request;
use DataTables;
use Session;

class RoleController extends Controller
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

        if (\Auth::user()->can('manage-role')) {
            # code...
            if ($request->ajax()) {
                $role = Role::with([
                    'permission_role' => function ($sql) {
                        $sql->with('permission');
                    }
                ]);
                return DataTables::of($role)
                    ->addColumn('action', function ($role) {
                        return view('datatable._nodelete', [
                            'edit_url' => route('role.edit', $role->id),
                            'confirm_message' => 'Apakah anda yakin mau menghapus pendaftaran ' . $role->name . '?',
                            'can_edit' => 'edit-role'
                        ]);
                    })
                    ->editColumn('permission_role', function ($role) {
                        $permisson_name = '';
                        foreach ($role->permission_role as $row) {
                            $permisson_name .= ' ' . '<span class="badge badge-danger">' . $row->permission->display_name . '</span>';
                        }
                        return  $permisson_name;
                    })
                    ->rawColumns(['permission_role', 'action'])
                    ->make(true);
            }
            return view('role.index');
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
        if (\Auth::user()->can('create-role')) {
            # code...
            return view('role.create');
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
        if (\Auth::user()->can('create-role')) {
            # code...
            $this->validate($request, [
                'name' => 'required|unique:roles',
                'display_name' => 'required',
                'description' => 'required'
            ]);

            $role = new Role();
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->save();

            return redirect()->route('role.edit', $role->id);
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
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
        //
        if (\Auth::user()->can('edit-role')) {
            # code...
            $module = Module::with([
                'permission'
            ])
                ->whereHas('permission')
                ->get();
            $role = Role::find($id);
            return view('role.edit')->with(compact('module', 'role'));
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if (\Auth::user()->can('edit-role')) {
            $this->validate($request, [
                'name' => 'required|unique:roles,name,' . $role->id,
                'display_name' => 'required',
                'description' => 'required'
            ]);
            $role = Role::find($role->id);
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->update();
            activity()->log('Merubah Data Role');
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Data Berhasil diubah !!!"
            ]);
            return redirect()->route('role.index');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
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
