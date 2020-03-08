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
                {!! Form::select('divisi_id', [''=>'']+App\Divisi::whereNotIn('id', ['1', '2'])->pluck('name','id')->all(), null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </section>
    <!-- End Section Page 1 -->
    <!-- Section Page 2 -->
    <h3>Transaksi</h3>
    <section>
        <div class="form-group clearfix">
            <label class="control-label" for="name"> Transaksi</label>
            <div class="">
                {!! Form::select('jenis_transaksi', ['1' => 'Debet'], null, ['placeholder' => '<---Jenis Transaksi -->', 'class' => 'form-control']) !!}
            </div>
        </div>
        <!-- Show If ALl Divisi Not Equeal -->
        <div id="all-divisi">
            <div class="form-group clearfix">
                <label for="Pokok" class="control-label">Nominal</label>
                <div class="">
                    {!! Form::hidden('biaya_id', null)!!}
                    {!! Form::text('nominal', null, ['class' => 'form-control biaya', 'autocomplete' => 'off'])!!}
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
                {!! Form::textarea('keterangan', null, ['class' => 'form-control required', 'autocomplete' => 'off'])!!}
            </div>
        </div>
    </section>
    <!-- End Section Page 3 -->
</div>