@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title float-left">Dashboard</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Devagil</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box tilebox-one">
            <i class="fi-head float-right"></i>
            <h6 class="text-muted text-uppercase mb-3">Anggota</h6>
            <h4 class="mb-3" data-plugin="counterup">{{ $countAnggota }}</h4>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box tilebox-one">
            <i class="fi-layers float-right"></i>
            <h6 class="text-muted text-uppercase mb-3">Divisi</h6>
            <h4 class="mb-3"><span data-plugin="counterup">{{ $countDivisi }}</span></h4>
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
