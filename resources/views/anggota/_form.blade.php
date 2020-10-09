<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">NO Anggota</label>
    <div class="col-8">
        {{ Form::text('nik', null, ['class' => $errors->has('nik') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'NIK']) }}
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
        {{ Form::text('nama', null, ['class' => $errors->has('nama') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Nama Anggota']) }}
        @error('nama')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Inisial</label>
    <div class="col-8">
        {{ Form::text('inisial', null, ['class' => $errors->has('inisial') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Nama Inisial']) }}
        @error('inisial')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Tanggal Daftar</label>
    <div class="col-8">
        {{ Form::text('tgl_daftar', null, ['class' => $errors->has('tgl_daftar') ? 'form-control datepicker is-invalid' : 'form-control datepicker', 'placeholder' => 'Tanggal Daftar']) }}
        @error('tgl_daftar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Status</label>
    <div class="col-8">
        {!! Form::select('status', ['1' => 'Aktif', '0' => 'Non Aktif'], null, ['class'=>$errors->has('status') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Pilih Status']) !!}
        @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Home Base</label>
    <div class="col-8">
        {!! Form::text('homebase', null, ['class'=>$errors->has('homebase') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Home Base']) !!}
        @error('homebase')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('anggota.index') }}" class="btn btn-help-block">Kembali</a>
