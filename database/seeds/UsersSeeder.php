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
                'name' => 'manage debet simpanan',
                'display_name' => 'Manage Debet Simpanan',
                'description' => 'Bisa Memanage Debet Simpanan'
            ],
            [
                'name' => 'manage kredit simpanan',
                'display_name' => 'Manage Kredit Simpanan',
                'description' => 'Bisa Memanage Kredit Simpanan'
            ]
        ];

        foreach($permission as $key)
        {

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
            'manage debet simpanan'
        ];

        $userAdmin = User::create([
            'name' => 'Admin Koperasi',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Kopkar2019')
        ]);

        /*
        foreach($adminPermission as $ap)
        {
            $permission = Permission::where('name', $ap)->first();
            $adminRole->givePermissionTo($permission->id);
        }
        */

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
