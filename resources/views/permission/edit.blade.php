@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title float-left">Permission</h4>

            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item active">Ubah Permission</li>
            </ol>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">FORM UBAH PERMISSION</h4>

            <div class="p-20">
                {!! Form::model($permission, ['route' => ['permission.update', $permission->id], 'method'=>'put', 'class' => 'form-horizontal']) !!}
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Nama Permission</label>
                        <div class="col-8">
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nama Permission', 'disabled'=>'disabled'])!!}
                        </div>
                    </div>
                    @include('permission.form')
                {!! Form::close() !!}
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->
</div>
@endsection
