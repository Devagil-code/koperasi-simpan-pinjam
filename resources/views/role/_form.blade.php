
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama</label>
    <div class="col-8">
        {!! Form::text('name', null, ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Nama']) !!}
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Display Name</label>
    <div class="col-8">
        {!! Form::text('display_name', null, ['class' => $errors->has('display_name') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Display Name']) !!}
        @error('display_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Deskripsi</label>
    <div class="col-8">
        {!! Form::text('description', null, ['class' => $errors->has('description') ? 'form-control is-invalid' :  'form-control', 'placeholder' => 'Deskripsi', 'autocomplete' => 'off' ]) !!}
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('role.index') }}" class="btn btn-danger">Kembali</a>
