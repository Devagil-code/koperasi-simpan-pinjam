<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Nama</label>
    <div class="col-8">
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nama Pengguna'])!!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Email Pengguna</label>
    <div class="col-8">
        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email'])!!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Hak Akses</label>
    <div class="col-8">
            {!! Form::select('role_id', [''=>'Hak Akses']+App\Role::whereNotIn('name', ['member'])->pluck('name','id')->all(), null, ['class' => 'form-control select2']) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Password</label>
    <div class="col-8">
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password'])!!}
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label" for="example-input-normal">Konfirmasi Password</label>
    <div class="col-8">
        {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Konfirmasi Password'])!!}
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
