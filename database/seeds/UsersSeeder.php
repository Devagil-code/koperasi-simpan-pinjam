<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\RoleUser;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
