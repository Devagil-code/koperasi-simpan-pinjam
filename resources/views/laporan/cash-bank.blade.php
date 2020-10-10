@extends('layouts.master')
@section('style')
<link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">Laporan Kas Bank </h4>
                <small class="text-danger">Periode : {{ periode()->name }}</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                <li class="breadcrumb-item active"><a href="{{route('laporan.cash-bank')}}">Laporan Kas Bank</a></li>
                </ol>
                <small class="text-danger">Tahun Buku : {{ periode()->open_date }} - {{ periode()->close_date }}</small>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-lg-6">
        <div class="card-box">
            <form id="basic-form" action="{{ route('laporan.cash-bank') }}" method="GET">
                @csrf
                <div class="form-group">
                    <label for="">Tanggal Awal</label>
                    <input type="text" class="form-control datepicker" name="start_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Akhir</label>
                    <input type="text" class="form-control datepicker" name="end_date" autocomplete="off">
                </div>
                <div class="form-group clearfix">
                    <label class="control-label " for="confirm">Jenis Pembayaran</label>
                    <select name="jenis_pembayaran" id="" class="form-control">
                        <option value=""><---Silahkan Pilih ---></option>
                        <option value="1">Kas</option>
                        <option value="2">Bank</option>
                    </select>
                </div>
                @permission('search-laporan-kas-bank')
                <input type="submit" value="Cari" class="btn btn-primary" name="search">
                @endpermission
                @permission('excell-laporan-kas-bank')
                <input type="submit" value="Excell" class="btn btn-danger" name="export_excell">
                @endpermission
            </form>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title">Laporan Cash/Bank</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tgl</th>
                        <th>Keterangan</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                @if (!empty($transaksi_harian))
                    <tbody>
                        @php
                            $no = 1;
                            $saldo = 0;
                            $i = 0;
                        @endphp
                        <tr>
                            <td scope="row"></td>
                            <td></td>
                            <td><strong>Saldo Mutasi</strong></td>
                            <td>{{ Money::stringToRupiah($saldo_debit) }}</td>
                            <td>{{ Money::stringToRupiah($saldo_kredit) }}</td>
                            <td>{{ Money::stringToRupiah($saldo_debit - $saldo_kredit) }}</td>
                        </tr>
                        @php
                            $saldo = $saldo_debit - $saldo_kredit;
                        @endphp
                        @foreach ($transaksi_harian as $row)
                            @php
                            $saldo += $row->sumDebitAll->sum('nominal') - $row->sumKreditAll->sum('nominal');
                            @endphp
                            <tr>
                                <td scope="row">{{ $no }}</td>
                                <td>{{ Tanggal::tanggal_id($row->tgl )}}</td>
                                <td>{{ $row->keterangan }}</td>
                                <td>{{ Money::stringToRupiah($row->sumDebitAll->sum('nominal')) }}</td>
                                <td>{{ Money::stringToRupiah($row->sumKreditAll->sum('nominal')) }}</td>
                                <td>{{ Money::stringToRupiah($saldo) }}</td>
                            </tr>
                            @php
                                $no++;
                            @endphp
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script>
        $(function(){
            var start = new Date('{{ periode()->open_date }}');
            var end = new Date('{{ periode()->close_date }}');

            $(".datepicker").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                startDate: start,
                endDate   : end,
                orientation: 'bottom'
            });
        })
    </script>
@endsection
