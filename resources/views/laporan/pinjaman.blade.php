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
                <h4 class="page-title">Laporan Pinjaman Anggota </h4>
                <small class="text-danger">Periode : {{ periode()->name }}</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                <li class="breadcrumb-item active"><a href="{{route('laporan.pinjaman')}}">Laporan Pinjaman Anggota</a></li>
                </ol>
                <small class="text-danger">Tahun Buku : {{ periode()->open_date }} - {{ periode()->close_date }}</small>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->

<!-- end row -->
<div class="row">
    <div class="col-lg-6">
        <div class="card-box">
            <form id="basic-form" action="{{ route('pinjaman-anggota.excel') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Tanggal Awal</label>
                    <input type="text" class="form-control datepicker" name="start_date" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Akhir</label>
                    <input type="text" class="form-control datepicker" name="end_date" autocomplete="off">
                </div>
                @permission('filter-pinjaman-anggota')
                <div class="form-group clearfix">
                    <label class="control-label " for="confirm">No Anggota *</label>
                    {!! Form::select('anggota_id', [''=>'Pilih Anggota']+App\Anggota::pluck('nama','id')->all(), null, ['class' => 'form-control select2']) !!}
                </div>
                @endpermission
                @permission('search-pinjaman-anggota')
                <button class="btn btn-primary" type="button" id="cari" data-url="{{ route('pinjaman-anggota.cari') }}">Cari</button>
                @endpermission
                @permission('excell-pinjaman-anggota')
                <input type="submit" value="Excell" class="btn btn-danger" name="export_excell">
                @endpermission
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
<div id="result"></div>
<div id="loader" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="false" style="display: none;">
    <div id="process_img" style="display: none; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="response">
                        <img src="{{ asset('loader.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
@endsection
@section('script')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script>
        $(function(){
            $(".select2").select2();

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

            $('#cari').on('click', function(e){
                e.preventDefault();
                var url = $(this).data('url');
                var data = $('#basic-form').serialize();
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    beforeSend: function() {
                        $("#loader").modal("show");
                        $('#process_img').css("display", "block");
                    },
                    success: function(response){
                        if(response.error)
                        {
                            $.toast({
                                heading: 'Error !',
                                text: response.error,
                                position: 'top-right',
                                loaderBg: '#bf441d',
                                icon: 'error',
                                hideAfter: 3000,
                                stack: 1
                            });
                        }else {
                            $('#result').html(response);
                            $('#response').html(`<img src="{!! asset('icon-success.png') !!}" alt="" height="50" width="50">`);
                        }
                    }
                });
            })
        })

        function closeModal() {
            $('#loader').on('shown.bs.modal', function(e) {
                $("#loader").modal("hide");
            });
        }
    </script>
@endsection
