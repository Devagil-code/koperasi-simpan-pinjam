@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title float-left">Biaya</h4>

            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item active">Tambah Biaya</li>
            </ol>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">FORM TAMBAH BIAYA</h4>

            <div class="p-20">
                <form role="form" class="form-horizontal" method="post" action="{{ route('biaya.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Nama Biaya</label>
                        <div class="col-8">
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nama Biaya'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Jenis Biaya</label>
                        <div class="col-8">
                            {!! Form::select('jenis_biaya', ['1' => 'Debet', '2' => 'Kredit'], null, ['class' => 'form-control', 'placeholder' => 'Pilih Jenis Biaya']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="example-input-normal">Divisi Biaya</label>
                        <div class="col-8">
                            {!! Form::select('divisi_id', [''=>'']+App\Divisi::pluck('name','id')->all(), null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->
</div>
@endsection
