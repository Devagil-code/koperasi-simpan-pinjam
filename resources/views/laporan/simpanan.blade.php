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
            <h4 class="page-title float-left">Laporan Simpanan</h4>

            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                <li class="breadcrumb-item active">Laporan Simpanan</li>
            </ol>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-lg-6">
        <div class="card-box">
            <form id="basic-form" action="{{ route('laporan.simpanan') }}" method="GET">
                @csrf
                <div class="form-group">
                    <label for="">Tanggal Awal</label>
                    <input type="text" class="form-control datepicker" name="start_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Akhir</label>
                    <input type="text" class="form-control datepicker" name="end_date" autocomplete="off">
                </div>
                @role('admin')
                <div class="form-group clearfix">
                    <label class="control-label " for="confirm">No Anggota *</label>
                    {!! Form::select('anggota_id', [''=>'Pilih Anggota']+App\Anggota::pluck('nama','id')->all(), null, ['class' => 'form-control select2']) !!}
                </div>
                @endrole
                <input type="submit" value="Cari" class="btn btn-primary" name="search">
                @role('admin')
                <input type="submit" value="Excell" class="btn btn-danger" name="export_excell">
                @endrole
            </form>
        </div>
    </div>
    @if (!empty($anggota))
        <div class="col-lg-6 anggota">
            <div class="card-box">
                <table class="table">
                    <tr>
                        <td><strong>Nama Anggota</strong></td>
                        <td>:</td>
                        <td id="nama-anggota">{{ $anggota->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Inisial</strong></td>
                        <td>:</td>
                        <td id="nama-inisial">{{ $anggota->inisial }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status Anggota</strong></td>
                        <td>:</td>
                        <td id="status-anggota">{{ $anggota->status }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Daftar</strong></td>
                        <td>:</td>
                        <td id="tanggal-daftar">{{ Tanggal::tanggal_id($anggota->tgl_daftar )}}</td>
                    </tr>
                </table>
            </div>
        </div>
    @else
        <div class="col-lg-6 anggota" style="display: none;">
            <div class="card-box">
                <table class="table">
                    <tr>
                        <td><strong>Nama Anggota</strong></td>
                        <td>:</td>
                        <td id="nama-anggota"></td>
                    </tr>
                    <tr>
                        <td><strong>Nama Inisial</strong></td>
                        <td>:</td>
                        <td id="nama-inisial"></td>
                    </tr>
                    <tr>
                        <td><strong>Status Anggota</strong></td>
                        <td>:</td>
                        <td id="status-anggota"></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Daftar</strong></td>
                        <td>:</td>
                        <td id="tanggal-daftar"></td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
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

        $('select[name=anggota_id]').on('change', function(){
            var anggotaId = $(this). children("option:selected"). val();
            if(anggotaId === '')
            {
                $('.anggota').css('display', 'none');
            }else {
                $('.anggota').css('display', '');
                $.ajax({
                    url: '{{ route('transaksi-harian.chek-anggota')}}',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        anggota_id: anggotaId
                    },
                    success: function(data)
                    {
                        console.log(data)
                        $('#nama-anggota').text(data.nama)
                        $('#nama-inisial').text(data.inisial)
                        $('#status-anggota').text(data.status)
                        $('#tanggal-daftar').text(data.tgl_daftar)
                    }
                });
            }

        });
    })
</script>
@endsection
