<div>
    <section>
            <div class="form-group clearfix">
                <label class="control-label " for="from-periode">From Periode</label>
                <div class="">
                    {!! Form::select('from_periode_id', [''=>'']+App\Periode::pluck('name','id')->all(), null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group clearfix">
                <label class="control-label " for="to-periode">To Periode</label>
                <div class="">
                    {!! Form::select('to_periode_id', [''=>'']+App\Periode::pluck('name','id')->all(), null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group clearfix">
                <label class="control-label " for="divisi">Divisi</label>
                <div class="">
                    {!! Form::select('divisi_id', [''=>'']+App\Divisi::pluck('name','id')->all(), null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group clearfix">
                <label class="control-label" for="status">Status</label>
                <div class="">
                    {!! Form::select('status_saldo', ['0' => 'Belom dicopy', '1' => 'Sudah dicopy'], null, ['class'=>'form-control','placeholder'=>'Select Status']) !!}
                </div>
            </div>
    </section>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{route('copy-saldo.index')}}" class="btn btn-success"> Kembali</a>
