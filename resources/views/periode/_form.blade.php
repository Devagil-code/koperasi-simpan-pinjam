

<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Tanggal Awal Periode</label>
    <div class="col-8">
        {!! Form::text('open_date', null, ['class' => 'form-control datepicker', 'placeholder' => 'Tanggal Awal Periode', 'autocomplete' => 'off' ]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Tanggal Akhir Periode</label>
    <div class="col-8">
        {!! Form::text('close_date', null, ['class' => 'form-control datepicker', 'placeholder' => 'Tanggal Akhir Periode', 'autocomplete' => 'off' ]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Periode</label>
    <div class="col-8">
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nama Periode']) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Status</label>
    <div class="col-8">
        {!! Form::select('status', ['1' => 'Aktif', '0' => 'None Aktif', '2' => 'Tutup Buku'], null, ['class'=>'form-control','placeholder'=>'Select Status']) !!}
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('periode.index') }}" class="btn btn-danger">Kembali</a>
