@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">Dashboard </h4>
                <small>Periode : {{ $periode->name }}</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Kopkar</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <small>Tahun Buku : {{ date('d-m-Y', strtotime($periode->open_date)) }} - {{ date('d-m-Y', strtotime($periode->close_date)) }}</small>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box tilebox-one">
            <i class="fi-layers float-right"></i>
            <h6 class="text-muted text-uppercase mb-3">Saldo Pokok</h6>
            <h6 class="mb-3">{{ Money::stringToRupiah($sum_pokok) }}</h6>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box tilebox-one">
            <i class="fi-layers float-right"></i>
            <h6 class="text-muted text-uppercase mb-3">Saldo Wajib</h6>
            <h6 class="mb-3"><span>{{ Money::stringToRupiah($sum_wajib) }}</span></h6>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box tilebox-one">
            <i class="fi-layers float-right"></i>
            <h6 class="text-muted text-uppercase mb-3">Saldo Sukarela</h6>
            <h6 class="mb-3"><span>{{ Money::stringToRupiah($sum_sukarela) }}</span></h6>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box tilebox-one">
            <i class="fi-layers float-right"></i>
            <h6 class="text-muted text-uppercase mb-3">Kredit Simpanan</h6>
            <h6 class="mb-3"><span>{{ Money::stringToRupiah($kredit_simpanan) }}</span></h6>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-7">
        <div class="card-box">
            <h4 class="header-title">Transactions History</h4>

            <div class="row">
                <div class="col-sm-4">
                    <div class="text-center mt-3">
                        <h6 class="font-normal text-muted font-14">Conversion Rate</h6>
                        <h6 class="font-18"><i class="mdi mdi-arrow-up-bold-hexagon-outline text-success"></i> <span class="text-dark">1.78%</span> <small></small></h6>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="text-center mt-3">
                        <h6 class="font-normal text-muted font-14">Average Order Value</h6>
                        <h6 class="font-18"><i class="mdi mdi-arrow-up-bold-hexagon-outline text-success"></i> <span class="text-dark">25.87</span> <small>USD</small></h6>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="text-center mt-3">
                        <h6 class="font-normal text-muted font-14">Total Wallet Balance</h6>
                        <h6 class="font-18"><i class="mdi mdi-arrow-up-bold-hexagon-outline text-success"></i> <span class="text-dark">87,4517</span> <small>USD</small></h6>
                    </div>
                </div>
            </div>
            <canvas id="transactions-chart" height="350" class="mt-4"></canvas>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card-box">
            <h4 class="header-title">Sales History</h4>

            <div class="row">
                <div class="col-sm-4">
                    <div class="text-center mt-3">
                        <h6 class="font-normal text-muted font-14">Conversion Rate</h6>
                        <h6 class="font-18"><i class="mdi mdi-arrow-up-bold-hexagon-outline text-success"></i> <span class="text-dark">3.94%</span> <small></small></h6>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="text-center mt-3">
                        <h6 class="font-normal text-muted font-14">Average Sales</h6>
                        <h6 class="font-18"><i class="mdi mdi-arrow-down-bold-hexagon-outline text-danger"></i> <span class="text-dark">16.25</span> <small>USD</small></h6>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="text-center mt-3">
                        <h6 class="font-normal text-muted font-14">Total Sales</h6>
                        <h6 class="font-18"><i class="mdi mdi-arrow-up-bold-hexagon-outline text-success"></i> <span class="text-dark">124,858.67</span> <small>USD</small></h6>
                    </div>
                </div>
            </div>

            <canvas id="sales-history" height="350" class="mt-4"></canvas>
        </div>
    </div>
</div>
<!-- end row -->
<!-- end row -->
<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box tilebox-one">
            <i class="fi-head float-right"></i>
            <h6 class="text-muted text-uppercase mb-3">Kredit Pinjaman</h6>
            <h6 class="mb-3">{{ Money::stringToRupiah($kredit_pinjaman) }}</h6>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box tilebox-one">
            <i class="fi-layers float-right"></i>
            <h6 class="text-muted text-uppercase mb-3">Debet Bunga</h6>
            <h6 class="mb-3"><span>{{ Money::stringToRupiah($bunga_pinjaman) }}</span></h6>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box tilebox-one">
            <i class="fi-layers float-right"></i>
            <h6 class="text-muted text-uppercase mb-3">Debet Pinjaman</h6>
            <h6 class="mb-3"><span>{{ Money::stringToRupiah($debet_pinjaman) }}</span></h6>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card-box">
            <h4 class="header-title mb-4">LOG PENGGUNA</h4>

            <div class="inbox-widget slimscroll" style="max-height: 370px;">
                <a href="#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/avatar-1.jpg" class="rounded-circle bx-shadow-lg" alt=""></div>
                        <p class="inbox-item-author">Chadengle</p>
                        <p class="inbox-item-text">Hey! there I'm available...</p>
                        <p class="inbox-item-date">13:40 PM</p>
                    </div>
                </a>
                <a href="#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/avatar-2.jpg" class="rounded-circle bx-shadow-lg" alt=""></div>
                        <p class="inbox-item-author">Tomaslau</p>
                        <p class="inbox-item-text">I've finished it! See you so...</p>
                        <p class="inbox-item-date">13:34 PM</p>
                    </div>
                </a>
                <a href="#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/avatar-3.jpg" class="rounded-circle bx-shadow-lg" alt=""></div>
                        <p class="inbox-item-author">Stillnotdavid</p>
                        <p class="inbox-item-text">This theme is awesome!</p>
                        <p class="inbox-item-date">13:17 PM</p>
                    </div>
                </a>
                <a href="#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/avatar-4.jpg" class="rounded-circle bx-shadow-lg" alt=""></div>
                        <p class="inbox-item-author">Kurafire</p>
                        <p class="inbox-item-text">Nice to meet you</p>
                        <p class="inbox-item-date">12:20 PM</p>
                    </div>
                </a>
                <a href="#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/avatar-5.jpg" class="rounded-circle bx-shadow-lg" alt=""></div>
                        <p class="inbox-item-author">Shahedk</p>
                        <p class="inbox-item-text">Hey! there I'm available...</p>
                        <p class="inbox-item-date">10:15 AM</p>
                    </div>
                </a>
                <a href="#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/avatar-6.jpg" class="rounded-circle bx-shadow-lg" alt=""></div>
                        <p class="inbox-item-author">Adhamdannaway</p>
                        <p class="inbox-item-text">This theme is awesome!</p>
                        <p class="inbox-item-date">9:56 AM</p>
                    </div>
                </a>
                <a href="#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/avatar-8.jpg" class="rounded-circle bx-shadow-lg" alt=""></div>
                        <p class="inbox-item-author">Arashasghari</p>
                        <p class="inbox-item-text">Hey! there I'm available...</p>
                        <p class="inbox-item-date">10:15 AM</p>
                    </div>
                </a>
                <a href="#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/avatar-9.jpg" class="rounded-circle bx-shadow-lg" alt=""></div>
                        <p class="inbox-item-author">Joshaustin</p>
                        <p class="inbox-item-text">I've finished it! See you so...</p>
                        <p class="inbox-item-date">9:56 AM</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-box">
            <h4 class="header-title mb-4">TRANSAKSI TERAKHIR</h4>
            <ul class="list-unstyled transaction-list slimscroll mb-0" style="max-height: 370px;">
                @foreach ($transaksi_harian as $item)
                    @if ($item->jenis_transaksi == '1')
                        <li>
                            <i class="dripicons-arrow-down text-success"></i>
                            <span class="tran-text">{{ $item->keterangan }}</span>
                            <span class="pull-right text-success tran-price">+{{ Money::stringToRupiah($item->sumDebitAll->sum('nominal')) }}</span>
                            <span class="pull-right text-muted">{{ Tanggal::tanggal_id($item->tgl) }}</span>
                            <span class="clearfix"></span>
                        </li>
                    @else
                        <li>
                            <i class="dripicons-arrow-up text-danger"></i>
                            <span class="tran-text">{{ $item->keterangan }}</span>
                            <span class="pull-right text-danger tran-price">-{{ Money::stringToRupiah($item->sumKreditAll->sum('nominal'))}}</span>
                            <span class="pull-right text-muted">{{ Tanggal::tanggal_id($item->tgl) }}</span>
                            <span class="clearfix"></span>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

</div>
@endsection
@section('script')

<script src="{{ asset('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('plugins/counterup/jquery.counterup.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('plugins/chart.js/chart.bundle.js') }}"></script>

<!-- init dashboard -->
<script src="{{ asset('pages/jquery.dashboard.init.js') }}"></script>
@endsection
