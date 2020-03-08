@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title float-left">Pengguna</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Management</a></li>
                <li class="breadcrumb-item active">Reset Password Pengguna</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">FORM RESET PASSWORD PENGGUNA</h4>
            <div class="p-20">
                    {!! Form::model($user, ['route' => ['user.reset-pass', $user->id], 'method'=>'put', 'class' => 'form-horizontal']) !!}                    
                    <div class="form-group row m-b-20">
                        <label class="col-4 col-form-label" for="example-input-normal">Password</label>
                        <div class="col-8">
                            {{ Form::password('password', ['class' => ($errors->has('password')) ? 'form-control is-invalid' : 'form-control']) }}
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Konfirmasi Password</label>
                        <div class="col-8">
                            {!! Form::password('password_confirmation', ['class' => ($errors->has('password')) ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Konfirmasi Password'])!!}
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                {!! Form::close() !!}
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->

    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">DETAIL PENGGUNA</h4>
            <div class="p-20">
                <table>
                    <tr>
                        <td>Nama Pengguna</td>
                        <td>:</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Login Pengguna</td>
                        <td>:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
