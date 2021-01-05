<?php

use App\Module;
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
        $moduleAnggota = Module::create([
            'name' => 'Module Anggota'
        ]);

        $permissionModuleAnggota = [
            [
                'name' => 'manage-anggota',
                'display_name' => 'Manage Anggota',
                'description' => 'Bisa Memanage Anggota'
            ],
            [
                'name' => 'create-anggota',
                'display_name' => 'create Anggota',
                'description' => 'Bisa Membuat Anggota'
            ],
            [
                'name' => 'edit-anggota',
                'display_name' => 'edit anggota',
                'description' => 'Bisa Mengubah Anggota'
            ],
            [
                'name' => 'download-anggota',
                'display_name' => 'download anggota',
                'description' => 'Bisa Download Anggota'
            ],
        ];

        foreach ($permissionModuleAnggota as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleAnggota->id
            ]);
        }

        $moduleDivisi = Module::create([
            'name' => 'Module Divisi'
        ]);

        $permissionModuleDivisi = [
            [
                'name' => 'manage-divisi',
                'display_name' => 'Manage Divisi',
                'description' => 'Bisa Memanage Divis'
            ],
            [
                'name' => 'create-divisi',
                'display_name' => 'Create Divisi',
                'description' => 'Bisa Membuat Divisi'
            ],
            [
                'name' => 'edit-divisi',
                'display_name' => 'Edit Divisi',
                'description' => 'Bisa Mengubah Divisi'
            ],
        ];

        foreach ($permissionModuleDivisi as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleDivisi->id
            ]);
        }

        $modulePeriode = Module::create([
            'name' => 'Module Periode Buku'
        ]);

        $permissionModulePeriode = [
            [
                'name' => 'manage-periode',
                'display_name' => 'Manage Periode',
                'description' => 'Bisa Memanage Periode'
            ],
            [
                'name' => 'create-periode',
                'display_name' => 'Create Periode',
                'description' => 'Bisa Membuat Periode'
            ],
            [
                'name' => 'edit-periode',
                'display_name' => 'Edit Periode',
                'description' => 'Bisa Mengubah Periode'
            ],
            [
                'name' => 'delete-periode',
                'display_name' => 'Delete Periode',
                'description' => 'Bisa Menghapus Periode'
            ],
        ];

        foreach ($permissionModulePeriode as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $modulePeriode->id
            ]);
        }

        $moduleBiaya = Module::create([
            'name' => 'Module Biaya'
        ]);

        $permissionModuleBiaya = [
            [
                'name' => 'manage-biaya',
                'display_name' => 'Manage biaya',
                'description' => 'Bisa Memanage biaya'
            ],
            [
                'name' => 'create-biaya',
                'display_name' => 'create biaya',
                'description' => 'Bisa Membuat biaya'
            ],
        ];

        foreach ($permissionModuleBiaya as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleBiaya->id
            ]);
        }

        $moduleSimpananDebet = Module::create([
            'name' => 'Module Simpanan Debet'
        ]);

        $permissionSimpananDebet = [
            [
                'name' => 'manage-debet-simpanan',
                'display_name' => 'Manage Debet Simpanan',
                'description' => 'Bisa Memanage debet simpanan'
            ],
            [
                'name' => 'create-debet-simpanan',
                'display_name' => 'Buat Debet Simpanan',
                'description' => 'Bisa Membuat debet simpanan'
            ],
            [
                'name' => 'edit-debet-simpanan',
                'display_name' => 'Edit Debet Simpanan',
                'description' => 'Bisa Mengubah debet simpanan'
            ],
            [
                'name' => 'delete-debet-simpanan',
                'display_name' => 'Delete Debet Simpanan',
                'description' => 'Bisa Menghapus debet simpanan'
            ],
            [
                'name' => 'download-debet-simpanan',
                'display_name' => 'Download Debet simpanan',
                'description' => 'Bisa Mendownload debet simpanan'
            ],
            [
                'name' => 'upload-debet-simpanan',
                'display_name' => 'Upload Debet Simpanan',
                'description' => 'Bisa Upload debet simpanan'
            ],
        ];

        foreach ($permissionSimpananDebet as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleSimpananDebet->id
            ]);
        }

        $moduleLaporan = Module::create([
            'name' => 'Module Laporan'
        ]);

        $permissionLaporan = [
            [
                'name' => 'manage-laporan-kas-bank',
                'display_name' => 'Manage laporan kas bank',
                'description' => 'Bisa Memanage laporan kas bank'
            ],
            [
                'name' => 'search-laporan-kas-bank',
                'display_name' => 'search laporan kas bank',
                'description' => 'Bisa Mencari laporan kas bank'
            ],
            [
                'name' => 'excell-laporan-kas-bank',
                'display_name' => 'excell laporan kas bank',
                'description' => 'Bisa Download laporan kas bank'
            ],
            [
                'name' => 'manage-laporan-simpanan-all',
                'display_name' => 'Manage laporan simpanan all',
                'description' => 'Bisa Memanage laporan simpanan all'
            ],
            [
                'name' => 'search-laporan-simpanan-all',
                'display_name' => 'Search Laporan Simpanan All',
                'description' => 'Bisa Mencari laporan simpanan all'
            ],
            [
                'name' => 'excell-laporan-simpanan-all',
                'display_name' => 'excell laporan simpanan all',
                'description' => 'Bisa Download laporan simpanan all'
            ],
            [
                'name' => 'manage-laporan-pinjaman-all',
                'display_name' => 'Manage laporan pinjaman all',
                'description' => 'Bisa Memanage laporan pinjaman all'
            ],
            [
                'name' => 'search-laporan-pinjaman-all',
                'display_name' => 'search laporan pinjaman all',
                'description' => 'Bisa Mencari laporan pinjaman all'
            ],
            [
                'name' => 'excell-laporan-pinjaman-all',
                'display_name' => 'excell laporan pinjaman all',
                'description' => 'Bisa Download laporan pinjaman all'
            ],
            [
                'name' => 'manage-simpanan-anggota',
                'display_name' => 'Manage simpanan anggota',
                'description' => 'Bisa Memanage simpanan anggota'
            ],
            [
                'name' => 'search-simpanan-anggota',
                'display_name' => 'search simpanan anggota',
                'description' => 'Bisa Mencari simpanan anggota'
            ],
            [
                'name' => 'excell-simpanan-anggota',
                'display_name' => 'Excell Simpanan Anggota',
                'description' => 'Bisa Download simpanan anggota'
            ],
            [
                'name' => 'filter-simpanan-anggota',
                'display_name' => 'Filter Simpanan Anggota',
                'description' => 'Bisa Filter simpanan anggota'
            ],
            [
                'name' => 'filter-pinjaman-anggota',
                'display_name' => 'Filter Pinjaman Anggota',
                'description' => 'Bisa Filter Pinjaman anggota'
            ],
            [
                'name' => 'manage-pinjaman-anggota',
                'display_name' => 'Manage pinjaman anggota',
                'description' => 'Bisa Memanage pinjaman anggota'
            ],
            [
                'name' => 'search-pinjaman-anggota',
                'display_name' => 'Search Pinjaman Anggota',
                'description' => 'Bisa Mencari pinjaman anggota'
            ],
            [
                'name' => 'excell-pinjaman-anggota',
                'display_name' => 'excell pinjaman anggota',
                'description' => 'Bisa Download pinjaman anggota'
            ],
            [
                'name' => 'manage-laporan-divisi',
                'display_name' => 'Manage laporan divisi',
                'description' => 'Bisa Memanage laporan divisi'
            ],
            [
                'name' => 'search-laporan-divisi',
                'display_name' => 'search laporan divisi',
                'description' => 'Bisa Mencari laporan divisi'
            ],
            [
                'name' => 'excell-laporan-divisi',
                'display_name' => 'excell laporan divisi',
                'description' => 'Bisa Download laporan divisi'
            ],
        ];

        foreach ($permissionLaporan as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleLaporan->id
            ]);
        }

        $moduleSimpananKredit = Module::create([
            'name' => 'Module Simpanan Kredit'
        ]);

        $permissionSimpananKredit = [
            [
                'name' => 'manage-kredit-simpanan',
                'display_name' => 'Manage Kredit Simpanan',
                'description' => 'Bisa Memanage kredit simpanan'
            ],
            [
                'name' => 'create-kredit-simpanan',
                'display_name' => 'Create Kredit Simpanan',
                'description' => 'Bisa Membuat kredit simpanan'
            ],
            [
                'name' => 'edit-kredit-simpanan',
                'display_name' => 'Edit Credit Simpanan',
                'description' => 'Bisa Mengubah kredit simpanan'
            ],
            [
                'name' => 'delete-kredit-simpanan',
                'display_name' => 'Delete Kredit Simpanan',
                'description' => 'Bisa Menghapus kredit simpanan'
            ],
            [
                'name' => 'download-kredit-simpanan',
                'display_name' => 'Download Kredit Simpanan',
                'description' => 'Bisa Mendownload kredit simpanan'
            ],
            [
                'name' => 'upload-kredit-simpanan',
                'display_name' => 'Upload Kredit Simpanan',
                'description' => 'Bisa Upload kredit simpanan'
            ],
        ];

        foreach ($permissionSimpananKredit as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleSimpananKredit->id
            ]);
        }

        $modulePinjamanDebet = Module::create([
            'name' => 'Module Pinjaman Debet'
        ]);

        $permissionPinjamanDebet = [
            [
                'name' => 'manage-debet-pinjaman',
                'display_name' => 'Manage Debet Pinjaman',
                'description' => 'Bisa Memanage debet pinjaman'
            ],
            [
                'name' => 'create-debet-pinjaman',
                'display_name' => 'Create Debet Pinjaman',
                'description' => 'Bisa Membuat debet pinjaman'
            ],
            [
                'name' => 'edit-debet-pinjaman',
                'display_name' => 'Edit Debet Pinjaman',
                'description' => 'Bisa Mengubah debet pinjaman'
            ],
            [
                'name' => 'delete-debet-pinjaman',
                'display_name' => 'Delete Debet Pinjaman',
                'description' => 'Bisa Menghapus debet pinjaman'
            ],
            [
                'name' => 'download-debet-pinjaman',
                'display_name' => 'Download Debet Pinjaman',
                'description' => 'Bisa Mendownload debet pinjaman'
            ],
            [
                'name' => 'upload-debet-pinjaman',
                'display_name' => 'Upload Debet Pinjaman',
                'description' => 'Bisa Upload debet pinjaman'
            ],
        ];

        foreach ($permissionPinjamanDebet as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $modulePinjamanDebet->id
            ]);
        }

        $modulePinjamanKredit = Module::create([
            'name' => 'Module Pinjaman Kredit'
        ]);

        $permissionPinjamanKredit = [
            [
                'name' => 'manage-kredit-pinjaman',
                'display_name' => 'Manage Kredit Pinjaman',
                'description' => 'Bisa Memanage kredit pinjaman'
            ],
            [
                'name' => 'create-kredit-pinjaman',
                'display_name' => 'Create Kredit Pinjaman',
                'description' => 'Bisa Membuat kredit pinjaman'
            ],
            [
                'name' => 'edit-kredit-pinjaman',
                'display_name' => 'Edit Kredit Pinjaman',
                'description' => 'Bisa Mengubah kredit pinjaman'
            ],
            [
                'name' => 'delete-kredit-pinjaman',
                'display_name' => 'Delete Kredit Pinjaman',
                'description' => 'Bisa Menghapus kredit pinjaman'
            ],
            [
                'name' => 'download-kredit-pinjaman',
                'display_name' => 'Download Kredit Pinjaman',
                'description' => 'Bisa Mendownload kredit pinjaman'
            ],
            [
                'name' => 'upload-kredit-pinjaman',
                'display_name' => 'Upload Kredit Pinjaman',
                'description' => 'Bisa Upload kredit pinjaman'
            ],
        ];

        foreach ($permissionPinjamanKredit as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $modulePinjamanKredit->id
            ]);
        }

        $moduleDivisiDebet = Module::create([
            'name' => 'Module Divisi Debet'
        ]);

        $permissionDivisiDebet = [
            [
                'name' => 'manage-debet-divisi',
                'display_name' => 'Manage Debet Divisi',
                'description' => 'Bisa Memanage debet divisi'
            ],
            [
                'name' => 'create-debet-divisi',
                'display_name' => 'Create Debet Divisi',
                'description' => 'Bisa Membuat debet divisi'
            ],
            [
                'name' => 'edit-debet-divisi',
                'display_name' => 'Edit Debet Divisi',
                'description' => 'Bisa Mengubah debet divisi'
            ],
            [
                'name' => 'delete-debet-divisi',
                'display_name' => 'Delete Debet Divisi',
                'description' => 'Bisa Menghapus Debet Divisi'
            ],
        ];

        foreach ($permissionDivisiDebet as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleDivisiDebet->id
            ]);
        }

        $moduleDivisiKredit = Module::create([
            'name' => 'Module Divisi Kredit'
        ]);

        $permissionDivisiKredit = [
            [
                'name' => 'manage-kredit-divisi',
                'display_name' => 'Manage kredit Divisi',
                'description' => 'Bisa Memanage debet kredit'
            ],
            [
                'name' => 'create-kredit-divisi',
                'display_name' => 'Create Kredit Divisi',
                'description' => 'Bisa Membuat debet kredit'
            ],
            [
                'name' => 'edit-kredit-divisi',
                'display_name' => 'Edit Kredit Divisi',
                'description' => 'Bisa Mengubah debet kredit'
            ],
            [
                'name' => 'delete-kredit-divisi',
                'display_name' => 'Delete Kredit Divisi',
                'description' => 'Bisa Menghapus Debet Kredit'
            ],
        ];

        foreach ($permissionDivisiKredit as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleDivisiKredit->id
            ]);
        }

        $modulePengguna = Module::create([
            'name' => 'Module Pengguna'
        ]);

        $permissionPengguna = [
            [
                'name' => 'manage-user',
                'display_name' => 'Manage user',
                'description' => 'Bisa Memanage user'
            ],
            [
                'name' => 'edit-user',
                'display_name' => 'edit user',
                'description' => 'Bisa Mengubah user'
            ],
            [
                'name' => 'create-user',
                'display_name' => 'create user',
                'description' => 'Bisa menambah user'
            ],
            [
                'name' => 'reset-password',
                'display_name' => 'Reset Password',
                'description' => 'Bisa reset password'
            ],
        ];

        foreach ($permissionPengguna as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $modulePengguna->id
            ]);
        }

        $moduleOption = Module::create([
            'name' => 'Module Option'
        ]);

        $permissionOption = [
            [
                'name' => 'manage-option',
                'display_name' => 'Manage option',
                'description' => 'Bisa Memanage option'
            ],
            [
                'name' => 'edit-option',
                'display_name' => 'edit option',
                'description' => 'Bisa Mengubah option'
            ],
            [
                'name' => 'create-option',
                'display_name' => 'create option',
                'description' => 'Bisa menambah option'
            ],
            [
                'name' => 'delete-option',
                'display_name' => 'Delete Option',
                'description' => 'Bisa Menghapus Option'
            ],
        ];

        foreach ($permissionOption as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleOption->id
            ]);
        }

        $moduleRole = Module::create([
            'name' => 'Module Role'
        ]);

        $permissionRole = [
            [
                'name' => 'manage-role',
                'display_name' => 'Manage Role',
                'description' => 'Bisa Manage Role'
            ],
            [
                'name' => 'edit-role',
                'display_name' => 'Edit Role',
                'description' => 'Bisa Mengubah Role'
            ],
            [
                'name' => 'create-role',
                'display_name' => 'Create Role',
                'description' => 'Bisa Menambah role'
            ],
        ];

        foreach ($permissionRole as $key) {
            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleRole->id
            ]);
        }

        $modulePermission = Module::create([
            'name' => 'Module Permission'
        ]);

        $permission = [

            [
                'name' => 'manage-permissions',
                'display_name' => 'Manage Permission',
                'description' => 'Bisa Manage Permission'
            ],
            [
                'name' => 'edit-permissions',
                'display_name' => 'Edit Permission',
                'description' => 'Bisa Mengubah Permission'
            ],
            [
                'name' => 'create-permissions',
                'display_name' => 'Create Permission',
                'description' => 'Bisa Menambah Permission'
            ],
        ];

        foreach ($permission as $key) {

            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $modulePermission->id
            ]);
        }

        $module = Module::create([
            'name' => 'Module'
        ]);

        $permission = [

            [
                'name' => 'manage-module',
                'display_name' => 'Manage Module',
                'description' => 'Bisa Manage Module'
            ],
            [
                'name' => 'edit-module',
                'display_name' => 'Edit Module',
                'description' => 'Bisa Mengubah Module'
            ],
            [
                'name' => 'create-module',
                'display_name' => 'Create Module',
                'description' => 'Bisa Menambah Module'
            ],
        ];

        foreach ($permission as $key) {

            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $module->id
            ]);
        }

        $moduleCopySaldo = Module::create([
            'name' => 'Module Copy Saldo '
        ]);

        $permission = [

            [
                'name' => 'manage-copy-saldo',
                'display_name' => 'Manage Copy Saldo',
                'description' => 'Bisa Manage Module'
            ],
            [
                'name' => 'edit-copy-saldo',
                'display_name' => 'Edit Copy Saldo',
                'description' => 'Bisa Mengubah Copy Saldo'
            ],
            [
                'name' => 'create-copy-saldo',
                'display_name' => 'Create Copy Saldo',
                'description' => 'Bisa Menambah Copy Saldo'
            ],
        ];

        foreach ($permission as $key) {

            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleCopySaldo->id
            ]);
        }

        //
        $moduleEmail = Module::create([
            'name' => 'Module Email'
        ]);

        $permissionModuleEmail = [

            [
                'name' => 'manage-email',
                'display_name' => 'Manage Email',
                'description' => 'Bisa Manage Email'
            ],
            [
                'name' => 'edit-email',
                'display_name' => 'Edit Email',
                'description' => 'Bisa Mengubah Email'
            ],
            [
                'name' => 'create-email',
                'display_name' => 'Create Email',
                'description' => 'Bisa Menambah Email'
            ],
        ];

        foreach ($permissionModuleEmail as $key) {

            Permission::create([
                'name' => $key['name'],
                'display_name' => $key['display_name'],
                'description' => $key['description'],
                'module_id' => $moduleEmail->id
            ]);
        }

        //Adminstrator Rules
        Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Ini Adalah Role Admin'
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $adminPermission = [
            'manage-anggota',
            'create-anggota',
            'edit-anggota',
            'download-anggota',
            'manage-divisi',
            'create-divisi',
            'edit-divisi',
            'manage-periode',
            'create-periode',
            'edit-periode',
            'delete-periode',
            'manage-biaya',
            'create-biaya',
            'manage-debet-simpanan',
            'create-debet-simpanan',
            'edit-debet-simpanan',
            'delete-debet-simpanan',
            'download-debet-simpanan',
            'upload-debet-simpanan',
            'manage-kredit-simpanan',
            'create-kredit-simpanan',
            'edit-kredit-simpanan',
            'delete-kredit-simpanan',
            'download-kredit-simpanan',
            'upload-kredit-simpanan',
            'manage-debet-pinjaman',
            'create-debet-pinjaman',
            'edit-debet-pinjaman',
            'delete-debet-pinjaman',
            'download-debet-pinjaman',
            'upload-debet-pinjaman',
            'manage-kredit-pinjaman',
            'create-kredit-pinjaman',
            'edit-kredit-pinjaman',
            'download-kredit-pinjaman',
            'upload-kredit-pinjaman',
            'manage-debet-divisi',
            'create-debet-divisi',
            'edit-debet-divisi',
            'delete-debet-divisi',
            'manage-kredit-divisi',
            'create-kredit-divisi',
            'edit-kredit-divisi',
            'delete-kredit-divisi',
            'manage-laporan-kas-bank',
            'search-laporan-kas-bank',
            'excell-laporan-kas-bank',
            'manage-laporan-simpanan-all',
            'search-laporan-simpanan-all',
            'excell-laporan-simpanan-all',
            'manage-laporan-pinjaman-all',
            'search-laporan-pinjaman-all',
            'excell-laporan-pinjaman-all',
            'manage-simpanan-anggota',
            'search-simpanan-anggota',
            'excell-simpanan-anggota',
            'filter-simpanan-anggota',
            'manage-pinjaman-anggota',
            'search-pinjaman-anggota',
            'excell-pinjaman-anggota',
            'filter-pinjaman-anggota',
            'manage-laporan-divisi',
            'search-laporan-divisi',
            'excell-laporan-divisi',
            'manage-user',
            'edit-user',
            'create-user',
            'reset-password',
            'manage-option',
            'edit-option',
            'create-option',
            'delete-option',
            'manage-role',
            'edit-role',
            'create-role',
            'manage-permissions',
            'edit-permissions',
            'create-permissions',
            'manage-module',
            'create-module',
            'edit-module',
            'manage-copy-saldo',
            'create-copy-saldo',
            'edit-copy-saldo',
            'manage-email',
            'create-email',
            'edit-email',
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

        //Member Rules
        Role::create([
            'name' => 'member',
            'display_name' => 'Member',
            'description' => 'Role Member'
        ]);

        $memberRole = Role::where('name', 'member')->first();
        $memberPermission = [
            'manage-simpanan-anggota',
            'search-simpanan-anggota',
            'excell-simpanan-anggota',
            'manage-pinjaman-anggota',
            'search-pinjaman-anggota',
            'excell-pinjaman-anggota'
        ];

        $memberUser = User::create([
            'name' => 'Member Koperasi',
            'email' => 'member@gmail.com',
            'password' => bcrypt('Kopkar2019')
        ]);


        foreach ($memberPermission as $ap) {
            $permission = Permission::where('name', $ap)->first();
            $memberRole->attachPermission($permission->id);
        }

        $memberUser->attachRole($memberRole);
    }
}
