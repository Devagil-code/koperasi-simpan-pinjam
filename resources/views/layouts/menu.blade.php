<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> <span>Dashboard</span> </a></li>
                @role('admin')
                <li class="menu-title">Master Data</li>
                <li class="{{ set_active(['anggota.index', 'anggota.create', 'anggota.edit'])}}">
                    <a href="{{ route('anggota.index') }}" class="{{ set_active(['anggota.index', 'anggota.create', 'anggota.edit'])}}">
                        <i class="fi-head"></i> <span>Anggota</span>
                    </a>
                </li>
                <li class="{{ set_active(['divisi.index', 'divisi.create', 'divisi.edit'])}}">
                    <a href="{{ route('divisi.index') }}" class="{{ set_active(['divisi.index', 'divisi.create', 'divisi.edit'])}}">
                        <i class="fi-layers"></i> <span>Divisi</span>
                    </a>
                </li>
                <li class="{{ set_active(['periode.index', 'periode.create', 'periode.edit'])}}">
                    <a href="{{ route('periode.index') }}" class="{{ set_active(['periode.index', 'periode.create', 'periode.edit'])}}">
                        <i class="fi-clock"></i> <span>Periode</span>
                    </a>
                </li>
                <li class="{{ set_active(['biaya.index', 'biaya.create'])}}">
                    <a href="{{ route('biaya.index') }}" class="{{ set_active(['biaya.index', 'biaya.create'])}}">
                        <i class="fa fa-money"></i> <span>Biaya</span>
                    </a>
                </li>
                <li class="menu-title">Transaksi</li>
                <li class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload',
                'simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">
                    <a href="javascript: void(0);" class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload',
                    'simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">
                        <i class="fi-map"></i> <span> Simpanan </span> <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level collapse" aria-expanded="false" style="">
                        <li class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload'])}}">
                            <a href="{{ route('simpanan-debet.index') }}" class="{{ set_active(['simpanan-debet.index', 'simpanan-debet.create', 'simpanan-debet.edit', 'simpanan-debet.upload'])}}">
                                Debet
                            </a>
                        </li>
                        <li class="{{ set_active(['simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">
                            <a href="{{ route('simpanan-kredit.index') }}" class="{{ set_active(['simpanan-kredit.index', 'simpanan-kredit.create', 'simpanan-kredit.edit', 'simpanan-kredit.upload'])}}">Kredit</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload',
                'pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                    <a href="javascript: void(0);" class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload',
                    'pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                        <i class="fi-map"></i> <span> Pinjaman </span> <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level collapse" aria-expanded="false" style="">
                        <li class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload'])}}">
                            <a href="{{ route('pinjaman-debet.index') }}" class="{{ set_active(['pinjaman-debet.index', 'pinjaman-debet.create', 'pinjaman-debet.edit', 'pinjaman-debet.upload'])}}">
                                Debet
                            </a>
                        </li>
                        <li class="{{ set_active(['pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                            <a href="{{ route('pinjaman-kredit.index') }}" class="{{ set_active(['pinjaman-kredit.index', 'pinjaman-kredit.create', 'pinjaman-kredit.edit', 'pinjaman-kredit.upload'])}}">
                                Kredit
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload',
                'divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">
                    <a href="javascript: void(0);" class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload',
                    'divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">
                        <i class="fi-map"></i> <span> Divisi </span> <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level collapse" aria-expanded="false">
                        <li class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload'])}}">
                            <a href="{{ route('divisi-debet.index') }}" class="{{ set_active(['divisi-debet.index', 'divisi-debet.create', 'divisi-debet.edit', 'divisi-debet.upload'])}}">Debet</a>
                        </li>
                        <li class="{{ set_active(['divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">
                            <a href="{{ route('divisi-kredit.index') }}" class="{{ set_active(['divisi-kredit.index', 'divisi-kredit.create', 'divisi-kredit.edit', 'divisi-kredit.upload'])}}">Kredit</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-title">Laporan</li>
                <li><a href="{{ route('laporan.cash-bank') }}"><i class="fi-file"></i> <span>Laporan Kas/Bank</span> </a></li>
                <li><a href="{{ route('laporan.simpanan-all') }}"><i class="fi-file"></i> <span>Laporan Simpanan</span> </a></li>
                <li><a href="{{ route('laporan.simpanan-all') }}"><i class="fi-file"></i> <span>Laporan Pinjaman</span> </a></li>
                @endrole
                <li><a href="{{ route('laporan.simpanan') }}"><i class="fi-file"></i> <span>Simpanan Anggota</span> </a></li>
                <li><a href="{{ route('laporan.pinjaman') }}"><i class="fi-file"></i> <span>Pinjaman Anggota</span> </a></li>
                @role('admin')
                <li><a href="{{ route('laporan.per-divisi') }}"><i class="fi-file"></i> <span>Laporan Per Divisi</span> </a></li>
                <li class="menu-title">Management</li>
                <li class="{{ set_active(['role.index', 'role.create', 'role.edit'])}}">
                    <a href="{{ route('role.index') }}" class="{{ set_active(['role.index', 'role.create', 'role.edit'])}}">
                        <i class="fi-head"></i> <span>Role</span>
                    </a>
                </li>
                <li class="{{ set_active(['user.index', 'user.create', 'user.edit'])}}">
                    <a href="{{ route('user.index') }}" class="{{ set_active(['user.index', 'user.create', 'user.edit'])}}">
                        <i class="fi-head"></i> <span>Pengguna</span>
                    </a>
                </li>
                <li class="{{ set_active(['option.index', 'option.create', 'option.edit'])}}">
                    <a href="{{ route('option.index') }}" class="{{ set_active(['option.index', 'option.create', 'option.edit'])}}">
                        <i class="fi-cog"></i> <span>Option</span>
                    </a>
                </li>
                @endrole
            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
