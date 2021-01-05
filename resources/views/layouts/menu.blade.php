<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> <span>Dashboard</span> </a></li>
                <li class="menu-title">Master Data</li>
                @permission('manage-anggota')
                <li class="{{ set_active(['anggota.index', 'anggota.create', 'anggota.edit'])}}">
                    <a href="{{ route('anggota.index') }}" class="{{ set_active(['anggota.index', 'anggota.create', 'anggota.edit'])}}">
                        <i class="fi-head"></i> <span>Anggota</span>
                    </a>
                </li>
                @endpermission
                @permission('manage-divisi')
                <li class="{{ set_active(['divisi.index', 'divisi.create', 'divisi.edit'])}}">
                    <a href="{{ route('divisi.index') }}" class="{{ set_active(['divisi.index', 'divisi.create', 'divisi.edit'])}}">
                        <i class="fi-layers"></i> <span>Divisi</span>
                    </a>
                </li>
                @endpermission
                @permission('manage-periode')
                <li class="{{ set_active(['periode.index', 'periode.create', 'periode.edit'])}}">
                    <a href="{{ route('periode.index') }}" class="{{ set_active(['periode.index', 'periode.create', 'periode.edit'])}}">
                        <i class="fi-clock"></i> <span>Periode</span>
                    </a>
                </li>
                @endpermission
                @permission('manage-biaya')
                <li class="{{ set_active(['biaya.index', 'biaya.create'])}}">
                    <a href="{{ route('biaya.index') }}" class="{{ set_active(['biaya.index', 'biaya.create'])}}">
                        <i class="fa fa-money"></i> <span>Biaya</span>
                    </a>
                </li>
                @endpermission
                @permission('manage-debet-simpanan|manage-kredit-simpanan|manage-debet-pinjaman
                |manage-kredit-pinjaman|manage-debet-divisi|manage-kredit-divisi|manage-copy-saldo')
                <li class="menu-title">Transaksi</li>
                @endpermission
                @permission('manage-copy-saldo')
                <li class="{{ set_active(['copy-saldo.index', 'copy-saldo.create', 'copy-saldo.edit'])}}">
                    <a href="{{ route('copy-saldo.index') }}" class="{{ set_active(['copy-saldo.index', 'copy-saldo.create', 'copy-saldo.edit'])}}">
                        <i class="fi-cloud-upload"></i> <span>Copy Saldo</span>
                    </a>
                </li>
                @endpermission
                @permission('manage-debet-simpanan|manage-kredit-simpanan')
                <li class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload',
                'simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">
                    <a href="javascript: void(0);" class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload',
                    'simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">
                        <i class="fi-map"></i> <span> Simpanan </span> <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level collapse" aria-expanded="false" style="">
                        @permission('manage-debet-simpanan')
                        <li class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload'])}}">
                            <a href="{{ route('simpanan-debet.index') }}" class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload'])}}">
                                Debet
                            </a>
                        </li>
                        @endpermission
                        @permission('manage-kredit-simpanan')
                        <li class="{{ set_active(['simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">
                            <a href="{{ route('simpanan-kredit.index') }}" class="{{ set_active(['simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">Kredit</a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endpermission
                @permission('manage-debet-pinjaman|manage-kredit-simpanan|pinjaman-debet-create')
                <li class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload',
                'pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                    <a href="javascript: void(0);" class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload',
                    'pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                        <i class="fi-map"></i> <span> Pinjaman </span> <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level collapse" aria-expanded="false" style="">
                        @permission('manage-debet-pinjaman')
                        <li class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload'])}}">
                            <a href="{{ route('pinjaman-debet.index') }}" class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload'])}}">
                                Debet
                            </a>
                        </li>
                        @endpermission
                        @permission('manage-kredit-pinjaman')
                        <li class="{{ set_active(['pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                            <a href="{{ route('pinjaman-kredit.index') }}" class="{{ set_active(['pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                                Kredit
                            </a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endpermission
                @permission('manage-debet-divisi|manage-kredit-divisi')
                <li class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload',
                'divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">
                    <a href="javascript: void(0);" class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload',
                    'divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">
                        <i class="fi-map"></i> <span> Divisi </span> <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level collapse" aria-expanded="false">
                        @permission('manage-debet-divisi')
                        <li class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload'])}}">
                            <a href="{{ route('divisi-debet.index') }}" class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload'])}}">Debet</a>
                        </li>
                        @endpermission
                        @permission('manage-kredit-divisi')
                        <li class="{{ set_active(['divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">
                            <a href="{{ route('divisi-kredit.index') }}" class="{{ set_active(['divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">Kredit</a>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @endpermission
                @permission('manage-laporan-kas-bank|manage-laporan-divisi|manage-laporan-pinjaman-anggota|manage-laporan-simpanan-anggota|
                manage-laporan-pinjaman-all|manage-laporan-simpanan-all')
                <li class="menu-title">Laporan</li>
                @endpermission
                @permission('manage-laporan-kas-bank')
                <li><a href="{{ route('laporan.cash-bank') }}"><i class="fi-file"></i> <span>Laporan Kas/Bank</span> </a></li>
                @endpermission
                @permission('manage-laporan-simpanan-all')
                <li><a href="{{ route('laporan.simpanan-all') }}"><i class="fi-file"></i> <span>Laporan Simpanan</span> </a></li>
                @endpermission
                @permission('manage-laporan-pinjaman-all')
                <li><a href="{{ route('laporan.pinjaman-all') }}"><i class="fi-file"></i> <span>Laporan Pinjaman</span> </a></li>
                @endpermission
                @permission('manage-simpanan-anggota')
                <li><a href="{{ route('laporan.simpanan') }}"><i class="fi-file"></i> <span>Simpanan Anggota</span> </a></li>
                @endpermission
                @permission('manage-pinjaman-anggota')
                <li><a href="{{ route('laporan.pinjaman') }}"><i class="fi-file"></i> <span>Pinjaman Anggota</span> </a></li>
                @endpermission
                @permission('manage-laporan-divisi')
                <li><a href="{{ route('laporan.per-divisi') }}"><i class="fi-file"></i> <span>Laporan Per Divisi</span> </a></li>
                @endpermission
                @permission('manage-permissions|manage-user|manage-role|manage-option|manage-module')
                <li class="menu-title">Management</li>
                @endpermission
                @permission('manage-module')
                <li class="{{ set_active(['module.index', 'module.create', 'module.edit'])}}">
                    <a href="{{ route('module.index') }}" class="{{ set_active(['module.index', 'module.create', 'module.edit'])}}">
                        <i class="fi-file-add"></i> <span>Module</span>
                    </a>
                </li>
                @endpermission
                @permission('manage-permissions')
                <li class="{{ set_active(['permission.index', 'permission.create', 'permission.edit'])}}">
                    <a href="{{ route('permission.index') }}" class="{{ set_active(['permission.index', 'permission.create', 'permission.edit'])}}">
                        <i class="fi-lock"></i> <span>Permission</span>
                    </a>
                </li>
                @endpermission
                @permission('manage-role')
                <li class="{{ set_active(['role.index', 'role.create', 'role.edit'])}}">
                    <a href="{{ route('role.index') }}" class="{{ set_active(['role.index', 'role.create', 'role.edit'])}}">
                        <i class="fi-help"></i> <span>Role</span>
                    </a>
                </li>
                @endpermission
                @permission('manage-user')
                <li class="{{ set_active(['user.index', 'user.create', 'user.edit'])}}">
                    <a href="{{ route('user.index') }}" class="{{ set_active(['user.index', 'user.create', 'user.edit'])}}">
                        <i class="fi-head"></i> <span>Pengguna</span>
                    </a>
                </li>
                @endpermission
                @permission('manage-option')
                <li class="{{ set_active(['option.index', 'option.create', 'option.edit'])}}">
                    <a href="{{ route('option.index') }}" class="{{ set_active(['option.index', 'option.create', 'option.edit'])}}">
                        <i class="fi-cog"></i> <span>Options</span>
                    </a>
                </li>
                @endpermission
            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
