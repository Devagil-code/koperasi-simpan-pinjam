<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Module</label>
    <div class="col-8">
        {!! Form::text('name', null, ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Nama Module'])!!}
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{route('module.index')}}" class="btn btn-warning" >Kembali</a>
