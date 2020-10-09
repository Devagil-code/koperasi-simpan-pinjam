@extends('layouts.master')
@section('style')
<link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">Pengguna</h4>
                <small class="text-danger">Periode : {{ periode()->name }}</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Management</a></li>
                <li class="breadcrumb-item active"><a href="{{route('user.index')}}">Pengguna</a></li>
                    <li class="breadcrumb-item active">Ubah</li>
                </ol>
                <small class="text-danger">Tahun Buku : {{ periode()->open_date }} - {{ periode()->close_date }}</small>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">FORM UBAH PENGGUNA</h4>
            <div class="p-20">
                {!! Form::model($user, ['route' => ['user.update', $user->id], 'method'=>'put', 'class' => 'form-horizontal', 'id' => 'basic-form']) !!}
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Nama</label>
                        <div class="col-8">
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nama Pengguna'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Email Pengguna</label>
                        <div class="col-8">
                            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Hak Akses</label>
                        <div class="col-8">
                                {!! Form::select('role_id', [''=>'Hak Akses']+App\Role::whereNotIn('name', ['member'])->pluck('name','id')->all(), null, ['class' => 'form-control select2']) !!}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
