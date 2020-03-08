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
                <li class="breadcrumb-item active">Profile Pengguna</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
@if (session()->has('flash_notification.message'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">Profile Pengguna</h4>
            <div class="p-20">
                <table class="table no-border">
                    <tbody>
                        <tr>
                            <td><strong>NIK / Username</strong></td>
                            <td>:</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>:</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->

    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">
                Reset Password
            </h4>
            <div class="p-20">
                {!! Form::model($user, ['route' => ['user.edit-password', $user->id], 'method'=>'put', 'class' => 'form-horizontal', 'id' => 'basic-form']) !!}
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Password Lama</label>
                        <div class="col-8">
                            <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" autocomplete="current-password" placeholder="Masukan Password Lama">
                            @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Password Baru</label>
                        <div class="col-8">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="Masukan Password Baru">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Konfirmasi Password Baru</label>
                        <div class="col-8">
                            <input id="confirm-password" type="password" class="form-control @error('confirm-password') is-invalid @enderror" name="confirm-password" autocomplete="current-password" placeholder="Konfirmasi Password Baru">
                            @error('confirm-password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>                
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')    
<script src="{{ asset('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('js/jquery.qrcode.min.js')}}"></script>
@endsection