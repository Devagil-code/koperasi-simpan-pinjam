@extends('layouts.master')

@php
    $logo=asset(Storage::url('logo/'));
@endphp
@section('content')
<div class="content">
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Options</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Management</a></li>
                            <li class="breadcrumb-item active">Options</li>
                        </ol>
                    </div>
                </div> <!-- end row -->
            </div>
            <!-- end page-title -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">Options</h4>
                            <p class="sub-title">Silahkan Atur Sesuaikan Dengan Perusahaan Anda</p>

                            <!-- Nav tabs -->
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link active" data-toggle="tab" href="#company" role="tab">
                                        <span class="d-none d-md-block">Logo</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">
                                        <span class="d-none d-md-block">Profil Perusahaan</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#email-option" role="tab">
                                        <span class="d-none d-md-block">Email Perusahaan</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#social-media" role="tab">
                                        <span class="d-none d-md-block">Sosial Media</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active p-3" id="company" role="tabpanel">
                                    {{Form::model($option,array('url'=>'option','method'=>'POST','enctype' => "multipart/form-data"))}}
                                    <div class="card-body">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <h5>{{__('Logo')}}</h5>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="height: 150px;">
                                                            <img src="{{$logo.'/logo.png'}}" alt="">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                                                        <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Pilih Gambar')}} </span>
                                                                <span class="fileinput-exists"> {{__('Ubah')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="logo" id="logo">
                                                            </span>
                                                            <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Hapus')}} </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <h5>{{__('Small Logo')}}</h5>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="height: 150px;">
                                                            <img src="{{$logo.'/small_logo.png'}}" alt="">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                                                        <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Pilih Gambar')}} </span>
                                                                <span class="fileinput-exists"> {{__('Ubah')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="small_logo" id="small_logo">
                                                            </span>
                                                            <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Hapus')}} </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <h5>{{__('Favicon')}}</h5>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="height: 150px;">
                                                            <img src="{{$logo.'/favicon.png'}}" alt="">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                                                        <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Pilih Gambar')}} </span>
                                                                <span class="fileinput-exists"> {{__('Ubah')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="favicon" id="favicon">
                                                            </span>
                                                            <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Hapus')}} </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @error('logo')
                                                <span class="invalid-logo" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="row mt-20">
                                                <div class="form-group col-md-6">
                                                    {{Form::label('title_text',__('Title Text')) }}
                                                    {{Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))}}
                                                    @error('title_text')
                                                    <span class="invalid-title_text" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('footer_text',__('Footer Text')) }}
                                                    {{Form::text('footer_text',null,array('class'=>'form-control','placeholder'=>__('Footer Text')))}}
                                                    @error('footer_text')
                                                    <span class="invalid-footer_text" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        {{Form::submit(__('Simpan'),array('class'=>'btn btn-primary'))}}
                                    </div>
                                    {{Form::close()}}
                                </div>
                                <div class="tab-pane p-3" id="profile-1" role="tabpanel">
                                    <div class="row">
                                        {{Form::model($option,array('route'=>'company.option','method'=>'post'))}}
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    {{Form::label('company_name *',__('Nama Perusahaan *')) }}
                                                    {{Form::text('company_name',null,array('class'=>'form-control font-style'))}}
                                                    @error('company_name')
                                                    <span class="invalid-company_name" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('company_address',__('Alamat')) }}
                                                    {{Form::textarea('company_address',null,array('class'=>'form-control font-style', 'rows'=> '3'))}}
                                                    @error('company_address')
                                                    <span class="invalid-company_address" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('company_phone',__('Telepon')) }}
                                                    {{Form::text('company_phone',null,array('class'=>'form-control font-style'))}}
                                                    @error('company_phone')
                                                    <span class="invalid-company_phone" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('company_email',__('Email')) }}
                                                    {{Form::text('company_email',null,array('class'=>'form-control font-style'))}}
                                                    @error('company_email')
                                                    <span class="invalid-company_email" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('postal_code',__('Kode Pos')) }}
                                                    {{Form::text('postal_code',null,array('class'=>'form-control font-style'))}}
                                                    @error('postal_code')
                                                    <span class="invalid-postal_code" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('phone_wa',__('No Handphone (WA)')) }}
                                                    {{Form::text('phone_wa',null,array('class'=>'form-control font-style'))}}
                                                    @error('phone_wa')
                                                        <span class="invalid-phone_wa" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('text_wa',__('Default Text (WA)')) }}
                                                    {{Form::textarea('text_wa',null,array('class'=>'form-control font-style', 'rows'=> '3'))}}
                                                    @error('text_wa')
                                                        <span class="invalid-text_wa" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            {{Form::submit(__('Simpan'),array('class'=>'btn btn-primary'))}}
                                        </div>
                                        {{Form::close()}}
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="email-option" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="email-option-wrap">
                                        {{Form::open(array('route'=>'email.option','method'=>'post'))}}
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_driver',__('Mail Driver')) }}
                                                {{Form::text('mail_driver',env('MAIL_DRIVER'),array('class'=>'form-control','placeholder'=>__('Enter Mail Driver')))}}
                                                @error('mail_driver')
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_host',__('Mail Host')) }}
                                                {{Form::text('mail_host',env('MAIL_HOST'),array('class'=>'form-control ','placeholder'=>__('Enter Mail Driver')))}}
                                                @error('mail_host')
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_port',__('Mail Port')) }}
                                                {{Form::text('mail_port',env('MAIL_PORT'),array('class'=>'form-control','placeholder'=>__('Enter Mail Port')))}}
                                                @error('mail_port')
                                                <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_username',__('Mail Username')) }}
                                                {{Form::text('mail_username',env('MAIL_USERNAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Username')))}}
                                                @error('mail_username')
                                                <span class="invalid-mail_username" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_password',__('Mail Password')) }}
                                                {{Form::text('mail_password',env('MAIL_PASSWORD'),array('class'=>'form-control','placeholder'=>__('Enter Mail Password')))}}
                                                @error('mail_password')
                                                <span class="invalid-mail_password" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_encryption',__('Mail Encryption')) }}
                                                {{Form::text('mail_encryption',env('MAIL_ENCRYPTION'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                                @error('mail_encryption')
                                                <span class="invalid-mail_encryption" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_from_address',__('Mail From Address')) }}
                                                {{Form::text('mail_from_address',env('MAIL_FROM_ADDRESS'),array('class'=>'form-control','placeholder'=>__('Enter Mail From Address')))}}
                                                @error('mail_from_address')
                                                <span class="invalid-mail_from_address" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                {{Form::label('mail_from_name',__('Mail From Name')) }}
                                                {{Form::text('mail_from_name',env('MAIL_FROM_NAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                                @error('mail_from_name')
                                                <span class="invalid-mail_from_name" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @permission('create-email')
                                        <div class="text-right">
                                            {{Form::submit(__('Simpan'),array('class'=>'btn btn-primary'))}}
                                        </div>
                                        @endpermission
                                        {{Form::close()}}
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="social-media" role="tabpanel">
                                    <div class="row">
                                        {{Form::model($option,array('route'=>'social-media','method'=>'post'))}}
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    {{Form::label('company_fb *',__('Facebook')) }}
                                                    {{Form::text('company_fb',null,array('class'=>'form-control font-style'))}}
                                                    @error('company_fb')
                                                    <span class="invalid-company_fb" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('company_ig',__('Instagram')) }}
                                                    {{Form::text('company_ig',null,array('class'=>'form-control font-style'))}}
                                                    @error('company_ig')
                                                    <span class="invalid-company_ig" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('company_twitter',__('Twitter')) }}
                                                    {{Form::text('company_twitter',null,array('class'=>'form-control font-style'))}}
                                                    @error('company_twitter')
                                                    <span class="invalid-company_twitter" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('company_yt',__('Youtube')) }}
                                                    {{Form::text('company_yt',null,array('class'=>'form-control font-style'))}}
                                                    @error('company_yt')
                                                    <span class="invalid-company_yt" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            {{Form::submit(__('Simpan'),array('class'=>'btn btn-primary'))}}
                                        </div>
                                        {{Form::close()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
