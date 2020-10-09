

<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Tanggal Awal Periode</label>
    <div class="col-8">
        {!! Form::text('open_date', null, ['class' => $errors->has('open_date') ? 'form-control datepicker is-invalid' : 'form-control datepicker', 'placeholder' => 'Tanggal Awal Periode', 'autocomplete' => 'off' ]) !!}
        @error('open_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Tanggal Akhir Periode</label>
    <div class="col-8">
        {!! Form::text('close_date', null, ['class' => $errors->has('close_date') ? 'form-control datepicker is-invalid' : 'form-control datepicker', 'placeholder' => 'Tanggal Akhir Periode', 'autocomplete' => 'off' ]) !!}
        @error('close_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama Periode</label>
    <div class="col-8">
        {!! Form::text('name', null, ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Nama Periode']) !!}
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Status</label>
    <div class="col-8">
        {!! Form::select('status', ['1' => 'Aktif', '0' => 'None Aktif'], null, ['class'=>$errors->has('status') ? 'form-control is-invalid' : 'form-control','placeholder'=>'Select Status']) !!}
        @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('periode.index') }}" class="btn btn-danger">Kembali</a>
