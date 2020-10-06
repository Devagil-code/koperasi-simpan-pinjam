<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Module</label>
    <div class="col-8">
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nama Module'])!!}
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{route('module.index')}}" class="btn btn-warning" >Kembali</a>
