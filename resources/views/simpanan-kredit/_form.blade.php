<div>
    <!-- Section Page 1 -->
    <h3>Divisi</h3>
    <section>
        <div class="form-group clearfix">
            <label class="control-label " for="userName">Tanggal Transaksi</label>
            <div class="">
                {!! Form::text('tgl', null, ['class' => 'form-control required datepicker', 'autocomplete' => 'off'])!!}
            </div>
        </div>
        <div class="form-group clearfix">
            <label class="control-label " for="password"> Jenis Pembayaran *</label>
            <div class="">
                {!! Form::select('jenis_pembayaran', ['1' => 'Cash', '2' => 'Bank'], null, ['placeholder' => '<---Jenis Transaksi -->', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group clearfix">
            <label class="control-label " for="confirm">Divisi *</label>
            <div class="">
                {!! Form::select('divisi_id', [''=>'']+App\Divisi::where('id', '1')->pluck('name','id')->all(), null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group clearfix anggota">
            <label class="control-label " for="confirm">No Anggota *</label>
            {!! Form::select('anggota_id', [''=>'Pilih Anggota']+App\Anggota::pluck('nama','id')->all(), null, ['class' => 'form-control select2']) !!}
        </div>
        <div class="form-group clearfix anggota col-8">
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
                {!! Form::select('jenis_transaksi', ['2' => 'Kredit'], null, ['placeholder' => '<---Jenis Transaksi -->', 'class' => 'form-control']) !!}
            </div>
        </div>
        <!-- End Show Jenis Transaksi == 1 -->
        <!-- Show If Divisi ID == 1 AND Jenis Transaksi == 2 -->
        <div id="transaksi-kredit">
            <div class="form-group clearfix">
                <label for="Pokok" class="control-label">Nominal</label>
                <div class="">
                    <input type="hidden" class="form-control" name="biaya_id" value="4">
                    {!! Form::text('nominal', null, ['class' => 'form-control biaya', 'autocomplete' => 'off'])!!}
                </div>
            </div>
        </div>
        <!-- End Show If Jenis Transaksi == 2 -->
    </section>
    <!-- end Section Page 2 -->
    <!-- Section Page 3 -->
    <h3>Keterangan</h3>
    <section>
        <div class="form-group clearfix">
            <label class="control-label " for="surname"> Keterangan </label>
            <div class="">
                {!! Form::textarea('keterangan', null, ['class' => 'form-control required', 'autocomplete' => 'off'])!!}
            </div>
        </div>
    </section>
    <!-- End Section Page 3 -->
</div>