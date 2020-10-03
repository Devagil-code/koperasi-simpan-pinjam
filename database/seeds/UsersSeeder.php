<?php

use Illuminate\Database\Seeder;
use Laratrust\Models\LaratrustRole as Role;
use App\User;
use App\RoleUser;
use Laratrust\Models\LaratrustPermission as Permission;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            [
                'name' => 'manage anggota',
                'display_name' => 'Manage Anggota',
                'description' => 'Bisa Memanage Anggota'
            ],
            [
                'name' => 'create anggota',
                'display_name' => 'create Anggota',
                'description' => 'Bisa Membuat Anggota'
            ],
            [
                'name' => 'edit anggota',
                'display_name' => 'edit anggota',
                'description' => 'Bisa Mengubah Anggota'
            ],
            [
                'name' => 'download anggota',
                'display_name' => 'download anggota',
                'description' => 'Bisa Download Anggota'
            ],
            [
                'name' => 'manage divis',
                'display_name' => 'Manage Divisi',
                'description' => 'Bisa Memanage Divis'
            ],
            [
                'name' => 'create divisi',
                'display_name' => 'create Divisi',
                'description' => 'Bisa Membuat Divisi'
            ],
            [
                'name' => 'edit divisi',
                'display_name' => 'edit divisi',
                'description' => 'Bisa Mengubah Divisi'
            ],
            [
                'name' => 'manage periode',
                'display_name' => 'Manage Periode',
                'description' => 'Bisa Memanage Periode'
            ],
            [
                'name' => 'create periode',
                'display_name' => 'create Periode',
                'description' => 'Bisa Membuat Periode'
            ],
            [
                'name' => 'edit periode',
                'display_name' => 'edit periode',
                'description' => 'Bisa Mengubah Periode'
            ],
            [
                'name' => 'manage biaya',
                'display_name' => 'Manage biaya',
                'description' => 'Bisa Memanage biaya'
            ],
            [
                'name' => 'create biaya',
                'display_name' => 'create biaya',
                'description' => 'Bisa Membuat biaya'
            ],
            [
                'name' => 'manage debet simpanan',
                'display_name' => 'Manage debet simpanan',
                'description' => 'Bisa Memanage debet simpanan'
            ],
            [
                'name' => 'create debet simpanan',
                'display_name' => 'Buat Debet Simpanan',
                'description' => 'Bisa Membuat debet simpanan'
            ],
            [
                'name' => 'edit debet simpanan',
                'display_name' => 'Edit Debet Simpanan',
                'description' => 'Bisa Mengubah debet simpanan'
            ],
            [
                'name' => 'download debet simpanan',
                'display_name' => 'download debet simpanan',
                'description' => 'Bisa Mendownload debet simpanan'
            ],
            [
                'name' => 'upload debet simpanan',
                'display_name' => 'upload debet simpanan',
                'description' => 'Bisa Upload debet simpanan'
            ],
            [
                'name' => 'manage kredit simpanan',
                'display_name' => 'Manage kredit simpanan',
                'description' => 'Bisa Memanage kredit simpanan'
            ],
            [
                'name' => 'create kredit simpanan',
                'display_name' => 'create kredit simpanan',
                'description' => 'Bisa Membuat kredit simpanan'
            ],
            [
                'name' => 'edit kredit simpanan',
                'display_name' => 'edit kredit simpanan',
                'description' => 'Bisa Mengubah kredit simpanan'
            ],
            [
                'name' => 'download kredit simpanan',
                'display_name' => 'download kredit simpanan',
                'description' => 'Bisa Mendownload kredit simpanan'
            ],
            [
                'name' => 'upload kredit simpanan',
                'display_name' => 'upload kredit simpanan',
                'description' => 'Bisa Upload kredit simpanan'
            ],
            [
                'name' => 'manage debet pinjaman',
                'display_name' => 'Manage debet pinjaman',
                'description' => 'Bisa Memanage debet pinjaman'
            ],
            [
                'name' => 'create debet pinjaman',
                'display_name' => 'create debet pinjaman',
                'description' => 'Bisa Membuat debet pinjaman'
            ],
            [
                'name' => 'edit debet pinjaman',
                'display_name' => 'edit debet pinjaman',
                'description' => 'Bisa Mengubah debet pinjaman'
            ],
            [
                'name' => 'download debet pinjaman',
                'display_name' => 'download debet pinjaman',
                'description' => 'Bisa Mendownload debet pinjaman'
            ],
            [
                'name' => 'upload debet pinjaman',
                'display_name' => 'upload debet pinjaman',
                'description' => 'Bisa Upload debet pinjaman'
            ],
            [
                'name' => 'manage kredit pinjaman',
                'display_name' => 'Manage kredit pinjaman',
                'description' => 'Bisa Memanage kredit pinjaman'
            ],
            [
                'name' => 'create kredit pinjaman',
                'display_name' => 'create kredit pinjaman',
                'description' => 'Bisa Membuat kredit pinjaman'
            ],
            [
                'name' => 'edit kredit pinjaman',
                'display_name' => 'edit kredit pinjaman',
                'description' => 'Bisa Mengubah kredit pinjaman'
            ],
            [
                'name' => 'download kredit pinjaman',
                'display_name' => 'download kredit pinjaman',
                'description' => 'Bisa Mendownload kredit pinjaman'
            ],
            [
                'name' => 'upload kredit pinjaman',
                'display_name' => 'upload kredit pinjaman',
                'description' => 'Bisa Upload kredit pinjaman'
            ],
            [
                'name' => 'manage debet divisi',
                'display_name' => 'Manage debet divisi',
                'description' => 'Bisa Memanage debet divisi'
            ],
            [
                'name' => 'create debet divisi',
                'display_name' => 'create debet divisi',
                'description' => 'Bisa Membuat debet divisi'
            ],
            [
                'name' => 'edit debet divisi',
                'display_name' => 'edit debet divisi',
                'description' => 'Bisa Mengubah debet divisi'
            ],
            [
                'name' => 'manage debet kredit',
                'display_name' => 'Manage debet kredit',
                'description' => 'Bisa Memanage debet kredit'
            ],
            [
                'name' => 'create debet kredit',
                'display_name' => 'create debet kredit',
                'description' => 'Bisa Membuat debet kredit'
            ],
            [
                'name' => 'edit debet kredit',
                'display_name' => 'edit debet kredit',
                'description' => 'Bisa Mengubah debet kredit'
            ],
            [
                'name' => 'manage laporan kas bank',
                'display_name' => 'Manage laporan kas bank',
                'description' => 'Bisa Memanage laporan kas bank'
            ],
            [
                'name' => 'search laporan kas bank',
                'display_name' => 'search laporan kas bank',
                'description' => 'Bisa Mencari laporan kas bank'
            ],
            [
                'name' => 'excell laporan kas bank',
                'display_name' => 'excell laporan kas bank',
                'description' => 'Bisa Download laporan kas bank'
            ],
            [
                'name' => 'manage laporan simpanan all',
                'display_name' => 'Manage laporan simpanan all',
                'description' => 'Bisa Memanage laporan simpanan all'
            ],
            [
                'name' => 'search laporan simpanan all',
                'display_name' => 'search laporan simpanan all',
                'description' => 'Bisa Mencari laporan simpanan all'
            ],
            [
                'name' => 'excell laporan simpanan all',
                'display_name' => 'excell laporan simpanan all',
                'description' => 'Bisa Download laporan simpanan all'
            ],
            [
                'name' => 'manage laporan pinjaman all',
                'display_name' => 'Manage laporan pinjaman all',
                'description' => 'Bisa Memanage laporan pinjaman all'
            ],
            [
                'name' => 'search laporan pinjaman all',
                'display_name' => 'search laporan pinjaman all',
                'description' => 'Bisa Mencari laporan pinjaman all'
            ],
            [
                'name' => 'excell laporan pinjaman all',
                'display_name' => 'excell laporan pinjaman all',
                'description' => 'Bisa Download laporan pinjaman all'
            ],
            [
                'name' => 'manage simpanan anggota',
                'display_name' => 'Manage simpanan anggota',
                'description' => 'Bisa Memanage simpanan anggota'
            ],
            [
                'name' => 'search simpanan anggota',
                'display_name' => 'search simpanan anggota',
                'description' => 'Bisa Mencari simpanan anggota'
            ],
            [
                'name' => 'excell simpanan anggota',
                'display_name' => 'excell simpanan anggota',
                'description' => 'Bisa Download simpanan anggota'
            ],
            [
                'name' => 'manage pinjaman anggota',
                'display_name' => 'Manage pinjaman anggota',
                'description' => 'Bisa Memanage pinjaman anggota'
            ],
            [
                'name' => 'search pinjaman anggota',
                'display_name' => 'search pinjaman anggota',
                'description' => 'Bisa Mencari pinjaman anggota'
            ],
            [
                'name' => 'excell pinjaman anggota',
                'display_name' => 'excell pinjaman anggota',
                'description' => 'Bisa Download pinjaman anggota'
            ],
            [
                'name' => 'manage laporan devisi',
                'display_name' => 'Manage laporan devisi',
                'description' => 'Bisa Memanage laporan devisi'
            ],
            [
                'name' => 'search laporan devisi',
                'display_name' => 'search laporan devisi',
                'description' => 'Bisa Mencari laporan devisi'
            ],
            [
                'name' => 'excell laporan devisi',
                'display_name' => 'excell laporan devisi',
                'description' => 'Bisa Download laporan devisi'
            ],
            [
                'name' => 'manage user',
                'display_name' => 'Manage user',
                'description' => 'Bisa Memanage user'
            ],
            [
                'name' => 'edit user',
                'display_name' => 'edit user',
                'description' => 'Bisa Mengubah user'
            ],
            [
                'name' => 'create user',
                'display_name' => 'create user',
                'description' => 'Bisa menambah user'
            ],
            [
                'name' => 'manage option',
                'display_name' => 'Manage option',
                'description' => 'Bisa Memanage option'
            ],
            [
                'name' => 'edit option',
                'display_name' => 'edit option',
                'description' => 'Bisa Mengubah option'
            ],
            [
                'name' => 'create option',
                'display_name' => 'create option',
                'description' => 'Bisa menambah option'
            ],
        ];

        foreach ($permission as $key) {

            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => 'Bisa Memanage Debet Simpanan'
            ]);
        }

        Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Ini Adalah Role Admin'
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $adminPermission = [
            'manage debet simpanan',
            'create debet simpanan',
            'edit debet simpanan',
        ];

        $userAdmin = User::create([
            'name' => 'Admin Koperasi',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Kopkar2019')
        ]);


        foreach ($adminPermission as $ap) {
            $permission = Permission::where('name', $ap)->first();
            $adminRole->attachPermission($permission->id);
        }


        $userAdmin->attachRole($adminRole);


        /*
        // Membuat role admin
        $adminRole = new Role();
        $adminRole->name = "admin";
        $adminRole->display_name = "Admin";
        $adminRole->save();
        // Membuat role member
        $memberRole = new Role();
        $memberRole->name = "member";
        $memberRole->display_name = "Member";
        $memberRole->save();
        // Membuat sample admin

        $admin = new User();
        $admin->name = 'Admin Larapus';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('Kopkar2019');
        $admin->save();

        // Membuat sample member
        $member = new User();
        $member->name = "Sample Member";
        $member->email = '563211';
        $member->password = bcrypt('Kopkar2019');
        $member->save();

        $role_user = new RoleUser();
        $role_user->role_id = $adminRole->id;
        $role_user->user_id = $admin->id;
        $role_user->user_type = 'App\User';
        $role_user->save();

        $role_user = new RoleUser();
        $role_user->role_id = $memberRole->id;
        $role_user->user_id = $member->id;
        $role_user->user_type = 'App\User';
        $role_user->save();
        */
    }
}
