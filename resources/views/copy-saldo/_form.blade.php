<div>
    <section>
            <div class="form-group clearfix">
                <label class="control-label " for="from-periode">From Periode</label>
                <div class="">
                    {!! Form::select('from_periode_id', [''=>'']+App\Periode::pluck('name','id')->all(), null, ['class' => $errors->has('from_periode_id') ? 'form-control is-invalid' : 'form-control']) !!}
                        @error('from_periode_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
            </div>
            <div class="form-group clearfix">
                <label class="control-label " for="to-periode">To Periode</label>
                <div class="">
                    {!! Form::select('to_periode_id', [''=>'']+App\Periode::pluck('name','id')->all(), null, ['class' => $errors->has('to_periode_id') ? 'form-control is-invalid' : 'form-control']) !!}
                    @error('to_periode_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>
            <div class="form-group clearfix">
                <label class="control-label " for="divisi">Divisi</label>
                <div class="">
                    {!! Form::select('divisi_id', [''=>'']+App\Divisi::pluck('name','id')->all(), null, ['class' => $errors->has('divisi_id') ? 'form-control is-invalid' : 'form-control']) !!}
                    @error('divisi_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
            </div>
    </section>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{route('copy-saldo.index')}}" class="btn btn-success"> Kembali</a>
