@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">Option </h4>
                <small class="text-danger">Periode : {{ periode()->name }}</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Management</a></li>
                <li class="breadcrumb-item active"><a href="{{route('option.index')}}">Option</a></li>
                <li class="breadcrumb-item active">Tambah </li>
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
            <h4 class="m-t-0 header-title">FORM TAMBAH OPTION</h4>
            <div class="p-20">
                <div class="p20">
                    <div class="col-md-6">
                        {{-- <div class="panel panel-default panel-border-color panel-border-color-primary"> --}}
                            <label class="col-md-8 col-form-label">Logo</label>
                            <div class="panel-body">
                                <div class="row">
                                    @if ($option->logo)
                                        <div class="col-md-12 col-md-offset-3">
                                            <img src="{{ asset('data_file/'.$option->logo)}}" alt="">
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        {!! Form::model($option, ['url' => route('option.upload'), 'enctype' => 'multipart/form-data']) !!}
                                            <input type="hidden"  name="option_id">
                                            <div class="form-group xs-pt-10 {{ $errors->has('logo') ? ' has-error' : '' }}">
                                                {!! Form::file('logo', null, ['class' => 'form-control', 'placeholder' => 'Masukan Logo', 'required' => 'required'] ) !!}
                                                {!! $errors->first('logo', '<p class="text-danger">:message</p>') !!}
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        {{-- </div> --}}
                    </div>
                </div>
                {{-- {!! Form::open(['url' => route('option.store'), 'class' => 'form-horizontal']) !!}
                    @include('option._form')
                {!! Form::close() !!} --}}
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->
</div>
@endsection
