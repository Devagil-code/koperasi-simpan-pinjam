@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title float-left">Dashboard</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Kopkar</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card border-primary m-b-30">
            <div class="card-body text-primary">
                <h6 class="card-title">Member {!! Auth::user()->name !!}</h6>
                <p class="card-text">Selamat Datang Kembali, Member {!! Auth::user()->name !!}</p>
            </div>
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
