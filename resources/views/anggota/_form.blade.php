<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">NO Anggota</label>
    <div class="col-8">
        {!! Form::text('nik', null, ['class' => 'form-control', 'placeholder' => 'NIK']) !!}
        @error('nik')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama</label>
    <div class="col-8">
        {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama']) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Inisial</label>
    <div class="col-8">
        {!! Form::text('inisial', null, ['class' => 'form-control', 'placeholder' => 'Nama Inisial']) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Tanggal Daftar</label>
    <div class="col-8">
        {!! Form::text('tgl_daftar', null, ['class' => 'form-control datepicker', 'placeholder' => 'Tanggal Daftar', 'autocomplete' => 'off' ]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Status</label>
    <div class="col-8">
        {!! Form::select('status', ['1' => 'Aktif', '0' => 'Non Aktif'], null, ['class'=>'form-control','placeholder'=>'Select Status']) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Home Base</label>
    <div class="col-8">
        {!! Form::text('homebase', null, ['class' => 'form-control', 'placeholder' => 'Home Base', 'autocomplete' => 'off' ]) !!}
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('anggota.index') }}" class="btn btn-danger">Kembali</a>
