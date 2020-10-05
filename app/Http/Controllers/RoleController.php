<?php

namespace App\Http\Controllers;

use App\Module;
use App\PermissionRole;
use App\Role;
use Illuminate\Http\Request;
use DataTables;

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
                        'confirm_message' => 'Apakah anda yakin mau menghapus pendaftaran ' . $role->name . '?'
                    ]);
                })
                ->editColumn('permission_role', function ($role) {
                    $permisson_name = '';
                    foreach ($role->permission_role as $row) {
                        $permisson_name .= ' '.'<span class="badge badge-danger">'.$row->permission->display_name.'</span>';
                    }
                    return  $permisson_name;
                })
                ->rawColumns(['permission_role', 'action'])
                ->make(true);
        }
        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
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
        $role = new Role();
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        return redirect()->route('role.edit', $role->id);
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
        $module = Module::with([
            'permission'
        ])
        ->whereHas('permission')
                ->get();
        $role = Role::find($id);
        return view('role.edit')->with(compact('module', 'role'));
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
        //
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
