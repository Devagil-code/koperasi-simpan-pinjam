<?php

namespace App\Http\Controllers;

use App\UserAnggota;
use Illuminate\Http\Request;
use App\Anggota;
use App\User;
use Illuminate\Support\Facades\DB;

class UserAnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $anggota = Anggota::select('id', 'nik', 'nama')->get();
        foreach($anggota as $row)
        {
            $userAnggota = UserAnggota::where('anggota_id', $row->id)->first();
            if(empty($userAnggota))
            {
                $user = new User();
                $user->email = $row->nik;
                $user->password = bcrypt('Kopkar2019');
                $user->name = $row->nama;
                $user->save();
                
                DB::table('role_user')->insert([
                    'user_id' => $user->id,
                    'role_id' => '2',
                    'user_type' => 'App\User'
                ]);

                $userAnggota = new UserAnggota();
                $userAnggota->anggota_id = $row->id;
                $userAnggota->user_id = $user->id;
                $userAnggota->save();
            }else {
                $user = User::where('id', $userAnggota->user_id)->first();
                $user->email = $row->nik;
                $user->password = bcrypt('Kopkar2019');
                $user->name = $row->nama;
                $user->update();
            }
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
     * @param  \App\UserAnggota  $userAnggota
     * @return \Illuminate\Http\Response
     */
    public function show(UserAnggota $userAnggota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserAnggota  $userAnggota
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAnggota $userAnggota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserAnggota  $userAnggota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAnggota $userAnggota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserAnggota  $userAnggota
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAnggota $userAnggota)
    {
        //
    }
}
