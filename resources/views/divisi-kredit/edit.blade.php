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
            <h4 class="page-title float-left">Transaksi Harian</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                <li class="breadcrumb-item active">Ubah Transaksi</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Ubah Transaksi</b></h4>
            <p class="text-muted m-b-30 font-13">
                Silahkan Lakukan Pengisian Transaksi Secara Lengkap
            </p>
            {!! Form::model($transaksiHarian, ['route' => ['divisi-kredit.update', $transaksiHarian->transaksi_harian_id], 'method'=>'put', 'class' => 'form-horizontal', 'id' => 'basic-form']) !!}
                @include('divisi-kredit._form')
            {!! Form::close() !!}
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

        $('select[name=divisi_id]').on('change', function(){

            var divisiId = $(this). children("option:selected"). val();
            var url = "{!! route('check-biaya-kredit.get', ['divisi' => '']) !!}"+"/"+divisiId;
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data)
                {
                    console.log(data)
                    $('input[name=biaya_id]').val(data.id)
                }
            })
        });

        $(".datepicker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });


        $('select[name=jenis_transaksi]').on('change', function(){

            var divisiId = $("select[name=divisi_id] option:selected").val();
            var jenisTransaksiId = $(this).children("option:selected").val();
            var url = "{!! route('check-biaya-kredit.get', ['divisi' => '']) !!}"+"/"+divisiId;
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data)
                {
                    console.log(data)
                    $('input[name=biaya_id]').val(data.id)
                }
            })
            if(jenisTransaksiId === '2')
            {
                $('#all-divisi').css('display', '');
            }
        });
    })
</script>
@endsection
