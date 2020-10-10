@extends('layouts.master')
@section('style')
<!--Form Wizard-->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery.steps/css/jquery.steps.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">Pinjaman Debet </h4>
                <small class="text-danger">Periode : {{ periode()->name }}</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                <li class="breadcrumb-item active"><a href="{{route('pinjaman-debet.index')}}">Pinjaman Debet</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
                <small class="text-danger">Tahun Buku : {{ periode()->open_date }} - {{ periode()->close_date }}</small>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Menambah Transaksi Baru</b></h4>
            <p class="text-muted m-b-30 font-13">
                Silahkan Lakukan Pengisian Transaksi Secara Lengkap
            </p>
            <form id="basic-form" action="{{ route('pinjaman-debet.store') }}" method="POST">
                @csrf
                @include('pinjaman-debet._form')
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<!--Form Wizard-->
<script src="{{ asset('plugins/jquery.steps/js/jquery.steps.min.js') }}" type="text/javascript"></script>

<!--wizard initialization-->
<script src="{{ asset('pages/jquery.wizard-init.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.maskMoney.js')}}" type="text/javascript"></script>
<script src="{{ asset('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}" type="text/javascript"></script>
<script>
    $(function(){
        $(".select2").select2();

        $('.biaya').maskMoney({prefix: 'Rp. ', thousands: '.', decimal: ',', precision: 0});

        $('select[name=anggota_id]').on('change', function(){
            var anggotaId = $(this). children("option:selected"). val();
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
        });

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
