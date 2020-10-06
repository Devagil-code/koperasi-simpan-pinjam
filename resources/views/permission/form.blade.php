<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Display Name</label>
    <div class="col-8">
        {!! Form::text('display_name', null, ['class' => 'form-control', 'placeholder' => 'Display Name'])!!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Divisi</label>
    <div class="col-8">
        {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Deskripsi'])!!}
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route ('permission.index')}}" class="btn btn-warning"> Kembali</a>
