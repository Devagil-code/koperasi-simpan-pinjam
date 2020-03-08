@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title float-left">Divisi</h4>

            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item active">Ubah Divisi</li>
            </ol>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">FORM UBAH DIVISI</h4>

            <div class="p-20">
                {!! Form::model($divisi, ['route' => ['divisi.update', $divisi->id], 'method'=>'put', 'class' => 'form-horizontal']) !!}
                    @include('divisi.form')
                {!! Form::close() !!}
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->
</div>
@endsection
