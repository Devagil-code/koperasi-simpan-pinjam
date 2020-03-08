<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Option</label>
    <div class="col-8">
        {!! Form::text('option_name', null, ['class' => 'form-control', 'placeholder' => 'Nama Option'])!!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Option Value</label>
    <div class="col-8">
        {!! Form::text('option_value', null, ['class' => 'form-control', 'placeholder' => 'Option Value'])!!}
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
