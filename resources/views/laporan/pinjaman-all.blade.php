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
            <h4 class="page-title float-left">Laporan Pinjaman</h4>

            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                <li class="breadcrumb-item active">Laporan Pinjaman</li>
            </ol>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-lg-8">
        <div class="card-box">
            <form id="basic-form" action="{{ route('laporan.pinjaman-all') }}" method="GET">
                @csrf
                <div class="form-group">
                    <label for="">Tanggal Awal</label>
                    <input type="text" class="form-control datepicker" name="start_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Akhir</label>
                    <input type="text" class="form-control datepicker" name="end_date" autocomplete="off">
                </div>
                {{-- <input type="submit" value="Cari" class="btn btn-primary" name="search">
                @role('admin')
                <input type="submit" value="Excell" class="btn btn-danger" name="export_excell">
                @endrole --}}
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            @role('admin')
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anggota as $item)
                            <td class="checkbox checkbox-success form-check-inline">
                                <input type="checkbox" id="inlineCheckbox{{$item->id}}" value="{{$item->id}}">
                                <label for="inlineCheckbox{{$item->id}}"> {{ $item->nama }} </label>
                            </td>
                        @endforeach
                    </tbody>
                </table>
                @endrole
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card text-center m-b-30">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tgl</th>
                            <th>Keterangan</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Pokok</th>
                            <th>Wajib</th>
                            <th>Sukarela</th>
                            <th>Kredit</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    @if (!empty($transaksi_harian))
                    <tbody>
                            @php
                                $saldo = 0;
                                $i = 0;
                            @endphp
                            @php
                                $saldo = $sum_pokok + $sum_wajib + $sum_sukarela - $sum_kredit_simpanan;
                            @endphp
                            <tr>
                                <td></td>
                                <td><strong>Saldo Mutasi</strong></td>
                                <td></td>
                                <td></td>
                                <td>{{ Money::stringToRupiah($sum_pokok) }}</td>
                                <td>{{ Money::stringToRupiah($sum_wajib) }}</td>
                                <td>{{ Money::stringToRupiah($sum_sukarela) }}</td>
                                <td>{{ Money::stringToRupiah($sum_kredit_simpanan) }}</td>
                                <td>{{ Money::stringToRupiah($saldo) }}</td>
                            </tr>
                            @foreach ($transaksi_harian as $row)
                                @php
                                    $saldo += $row->sumPokok->sum('nominal') + $row->sumWajib->sum('nominal') + $row->sumSukarela->sum('nominal') - $row->sumKredit->sum('nominal');
                                @endphp
                                <tr>
                                    <td>{{ Tanggal::tanggal_id($row->tgl) }}</td>
                                    <td>{{ $row->keterangan }}</td>
                                    <td>{{ $anggota->nik }}</td>
                                    <td>{{ $anggota->nama }}</td>
                                    <td>{{ Money::stringToRupiah($row->sumPokok->sum('nominal')) }}</td>
                                    <td>{{ Money::stringToRupiah($row->sumWajib->sum('nominal')) }}</td>
                                    <td>{{ Money::stringToRupiah($row->sumSukarela->sum('nominal')) }}</td>
                                    <td>{{ Money::stringToRupiah($row->sumKredit->sum('nominal')) }}</td>
                                    <td>{{ Money::stringToRupiah($saldo) }}</td>
                                </tr>
                            @endforeach
                    </tbody>
                    @endif
                </table>
            </div>
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
        $(".select2").select2();

        $(".datepicker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });
    })
</script>
@endsection
