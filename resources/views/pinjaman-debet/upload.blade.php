@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title float-left">Upload Transaksi</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                <li class="breadcrumb-item active">Upload Transaksi</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Upload Transaksi</b></h4>
            <p class="text-muted m-b-30 font-13">
                Silahkan Upload File Excell Yang Telah Di Download Dari File Template
            </p>
            <form id="basic-form" action="{{ route('pinjaman-debet.doupload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <section>
                        <div class="form-group clearfix">
                            <label class="control-label " for="userName">Upload Excell</label>
                            <div class="">
                                <input class="form-control required" id="userName" name="file" type="file" autocomplete="off">
                            </div>
                        </div>
                    </section>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
