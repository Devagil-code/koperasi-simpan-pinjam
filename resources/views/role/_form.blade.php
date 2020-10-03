
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama</label>
    <div class="col-8">
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nama']) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Display Name</label>
    <div class="col-8">
        {!! Form::text('display_name', null, ['class' => 'form-control', 'placeholder' => 'Display Name']) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Deskripsi</label>
    <div class="col-8">
        {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Deskripsi', 'autocomplete' => 'off' ]) !!}
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('role.index') }}" class="btn btn-danger">Kembali</a>
