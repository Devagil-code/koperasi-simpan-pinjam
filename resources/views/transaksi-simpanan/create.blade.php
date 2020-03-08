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
                <li class="breadcrumb-item active">Tambah Transaksi</li>
            </ol>
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
            <form id="basic-form" action="{{ route('transaksi-simpanan.store') }}" method="POST">
                @csrf
                <div>
                    <!-- Section Page 1 -->
                    <h3>Divisi</h3>
                    <section>
                        <div class="form-group clearfix">
                            <label class="control-label " for="userName">Tanggal Transaksi</label>
                            <div class="">
                                <input class="form-control required datepicker" id="userName" name="tgl" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label " for="password"> Jenis Pembayaran *</label>
                            <div class="">

                                <select class="form-control" name="jenis_pembayaran">
                                    <option value="1">Cash</option>
                                    <option value="2">Bank</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label " for="confirm">Divisi *</label>
                            <div class="">
                                {!! Form::select('divisi_id', [''=>'']+App\Divisi::where('id', '1')->pluck('name','id')->all(), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix anggota" style="display: none;">
                            <label class="control-label " for="confirm">No Anggota *</label>
                            {!! Form::select('anggota_id', [''=>'Pilih Anggota']+App\Anggota::pluck('nama','id')->all(), null, ['class' => 'form-control select2']) !!}
                        </div>
                        <div class="form-group clearfix anggota col-8" style="display: none;">
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
                    </section>
                    <!-- End Section Page 1 -->
                    <!-- Section Page 2 -->
                    <h3>Transaksi</h3>
                    <section>
                        <div class="form-group clearfix">
                            <label class="control-label" for="name"> Transaksi</label>
                            <div class="">
                                <select name="jenis_transaksi" id="" class="form-control">
                                    <option value=""><---Jenis Transaksi --></option>
                                    <option value="1">Debet</option>
                                    <option value="2">Kredit</option>
                                </select>
                            </div>
                        </div>
                        <!-- Show DIvisi ID == 2 AND If Jenis Transaksi == 1 -->
                        <div id="transaksi-debet" style="display: none;">
                            <div class="form-group clearfix">
                                <label for="Pokok" class="control-label">Pokok</label>
                                <div class="">
                                    <input type="hidden" class="form-control" name="biaya[0][biaya_id]" value="1">
                                    <input type="text" class="form-control biaya" name="biaya[0][nominal]">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="Pokok" class="control-label">Wajib</label>
                                <div class="">
                                    <input type="hidden" class="form-control" name="biaya[1][biaya_id]" value="2">
                                    <input type="text" class="form-control biaya" name="biaya[1][nominal]">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="Pokok" class="control-label">Sukarela</label>
                                <div class="">
                                    <input type="hidden" class="form-control" name="biaya[2][biaya_id]" value="3">
                                    <input type="text" class="form-control biaya" name="biaya[2][nominal]">
                                </div>
                            </div>
                        </div>
                        <!-- End Show Jenis Transaksi == 1 -->
                        <!-- Show If Divisi ID == 1 AND Jenis Transaksi == 2 -->
                        <div id="transaksi-kredit" style="display: none;">
                            <div class="form-group clearfix">
                                <label for="Pokok" class="control-label">Nominal</label>
                                <div class="">
                                    <input type="hidden" class="form-control" name="biaya_id" value="1">
                                    <input type="text" class="form-control biaya" name="nominal">
                                </div>
                            </div>
                        </div>
                        <!-- End Show If Jenis Transaksi == 2 -->
                        <!-- Show If Divisi ID == 2 AND JENIS TRANSAKSI == 1 -->
                        <div id="pinjam-debet" style="display: none;">
                            <div class="form-group clearfix">
                                <label for="Pokok" class="control-label">Nominal</label>
                                <div class="">
                                    <input type="hidden" class="form-control" name="cicilan[0][biaya_id]" value="5">
                                    <input type="text" class="form-control biaya" name="cicilan[0][nominal]">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="Pokok" class="control-label">Bunga</label>
                                <div class="">
                                    <input type="hidden" class="form-control" name="cicilan[1][biaya_id]" value="6">
                                    <input type="text" class="form-control biaya" name="cicilan[1][nominal]">
                                </div>
                            </div>
                        </div>
                        <!-- End Show If Divisi ID == 2 AND JENIS TRANSAKSI == 1 -->
                        <!-- Show If Divisi ID == 2 AND JENIS TRANSAKSI == 2 -->
                        <div id="pinjam-kredit" style="display: none;">
                            <div class="form-group clearfix">
                                <label for="Pokok" class="control-label">Nominal</label>
                                <div class="">
                                    <input type="hidden" class="form-control" name="pinjaman[0][biaya_id]" value="7">
                                    <input type="text" class="form-control biaya" name="pinjaman[0][nominal]">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="Pokok" class="control-label">Lama Kredit</label>
                                <div class="">
                                    <input type="number" class="form-control" name="lama_kredit">
                                </div>
                            </div>
                        </div>
                        <!-- End Show If Divisi ID == 2 AND JENIS TRANSAKSI == 1 -->
                        <!-- Show If ALl Divisi Not Equeal -->
                        <div id="all-divisi" style="display: none;">
                            <div class="form-group clearfix">
                                <label for="Pokok" class="control-label">Nominal</label>
                                <div class="">
                                    <input type="hidden" class="form-control" name="pinjaman[0][biaya_id]" value="7">
                                    <input type="text" class="form-control biaya" name="pinjaman[0][nominal]">
                                </div>
                            </div>
                        </div>
                        <!-- End Show -->
                    </section>
                    <!-- end Section Page 2 -->
                    <!-- Section Page 3 -->
                    <h3>Keterangan</h3>
                    <section>
                        <div class="form-group clearfix">
                            <label class="control-label " for="surname"> Keterangan </label>
                            <div class="">
                                <textarea name="keterangan" id="" cols="30" rows="10" class="form-control" required></textarea>
                            </div>
                        </div>
                    </section>
                    <!-- End Section Page 3 -->
                </div>
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

        $('select[name=divisi_id]').on('change', function(){
            var divisiId = $(this). children("option:selected"). val();
            if(divisiId === '1' || divisiId === '2')
            {
                $('.anggota').css('display', '');
            }else {
                $('.anggota').css('display', 'none');
                $(".anggota option:selected").prop("selected", false);
            }
        });

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

        $(".datepicker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });


        $('select[name=jenis_transaksi]').on('change', function(){

            var divisiId = $("select[name=divisi_id] option:selected").val();
            var jenisTransaksiId = $(this). children("option:selected"). val();
            if(divisiId === '1')
            {

                if(jenisTransaksiId === '1')
                {
                    $('#transaksi-debet').css('display', '');
                    $('#transaksi-kredit').css('display', 'none');
                }else {
                    $('#transaksi-debet').css('display', 'none');
                    $('#transaksi-kredit').css('display', '');
                }
            }

            if(divisiId === '2')
            {
                if(jenisTransaksiId === '1')
                {
                    $('#pinjam-debet').css('display', '');
                    $('#pinjam-kredit').css('display', 'none');
                }else {
                    $('#pinjam-debet').css('display', 'none');
                    $('#pinjam-kredit').css('display', '');
                }
            }
        });
    })
</script>
@endsection
