@extends('layouts.master')
@section('style')
<link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title float-left">Pengguna</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Management</a></li>
                <li class="breadcrumb-item active">Tambah Pengguna</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">FORM TAMBAH PENGGUNA</h4>
            <div class="p-20">
                {!! Form::open(['url' => route('user.store'), 'class' => 'form-horizontal']) !!}
                    @include('user._form')
                {!! Form::close() !!}
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->
</div>
@endsection
@section('script')    
<script src="{{ asset('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}" type="text/javascript"></script>
<script>
    $(function(){
        $(".select2").select2();
    });
</script>
@endsection