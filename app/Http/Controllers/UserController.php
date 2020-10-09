<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;
use Session;
use App\RoleUser;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Anngota;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if (\Auth::user()->can('manage-user')) {
            # code...
            if ($request->ajax()) {
                $user = User::with('roles');
                return DataTables::of($user)
                    ->addColumn('action', function ($user) {
                        return view('datatable._resetpassword', [
                            'edit_url' => route('user.edit', $user->id),
                            'reset_url' => route('user.reset-password', $user->id),
                            'confirm_message' => 'Apakah anda yakin mau menghapus pendaftaran ' . $user->name . '?'
                        ]);
                    })
                    ->make(true);
            }
            return view('user.index');
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
        if (\Auth::user()->can('create-user')) {
            # code...
            return view('user.create');
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
        if (\Auth::user()->can('create-user')) {
            # code...
            $this->validate($request, [
                'email' => 'required|unique:users',
                'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:8',
                'role_id' => 'required'
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            $role_user = new RoleUser();
            $role_user->user_id = $user->id;
            $role_user->role_id = $request->role_id;
            $role_user->user_type = 'App\User';
            $role_user->save();

            //Sent Session Message To View
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil Menambah Pengguna !!!"
            ]);

            return redirect()->route('user.index');
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
        if (\Auth::user()->can('edit-user')) {
            # code...
            $user = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->select('users.id as id', 'users.name as name', 'users.email as email', 'roles.name as role_name', 'roles.id as role_id')
                ->where('users.id', $id)
                ->first();
            if ($user->role_name == 'member') {
                Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Silahkan Update Pengguna Ini Di Menu Anggota !!!"
                ]);
                return redirect()->route('user.index');
            } else {
                return view('user.edit')->with(compact('user'));
            }
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
    public function update(Request $request, $id)
    {
        //
        if (\Auth::user()->can('edit-user')) {
            # code...
            $this->validate($request, [
                'email' => 'required|unique:users,email,' . $id,
                'role_id' => 'required',
                'name' => 'required'
            ]);

            $user = User::find($id);
            $user->email = $request->email;
            $user->name = $request->name;
            $user->update();

            $role_user = RoleUser::where('user_id', $id)->first();
            $role_user->role_id = $request->role_id;
            $role_user->user_type = 'App\User';
            $role_user->update();

            //Sent Session Message To View
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil Merubah Pengguna !!!"
            ]);

            return redirect()->route('user.index');
        } else {
            # code...
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

    public function resetPassword($id)
    {
        $user = User::find($id);
        return view('user.reset-password')->with(compact('user'));
    }

    public function putResetPass(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8'
        ]);
        $user = User::find($id);
        $user->password = bcrypt($request->password);
        $user->update();

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Password Berhasil Di Rubah !!!"
        ]);

        return redirect()->route('user.index');
    }

    public function editPasswordMember($id)
    {
        $user = User::find($id);
        if($user)
        {
            if ($user->id == Auth::user()->id) {
                return view('user-profile.reset-password')->with(compact('user'));
            } else {
                return view('errors.404');
            }
        }else {
            return view('errors.404');
        }

    }

    public function putEditPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:8',
            'confirm-password' => 'required_with:password|same:password|min:8'
        ]);
        //dd(bcrypt($request->old_password), $user->password);
        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => bcrypt($request->password)
            ])->save();

            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Password Berhasil Di Rubah !!!"
            ]);
            return redirect()->route('user.user-profile', Auth::user()->id);
        } else {
            Session::flash("flash_notification", [
                "level" => "error",
                "message" => "Password does not match !!"
            ]);
            return redirect()->route('user.user-profile', Auth::user()->id);
        }
    }
}
