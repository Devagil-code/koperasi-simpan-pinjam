@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="float-left">
                <h4 class="page-title">Role </h4>
                <small class="text-danger">Periode : {{ periode()->name }}</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Management</a></li>
                <li class="breadcrumb-item active"><a href="{{route('permission.index')}}">Role</a></li>
                <li class="breadcrumb-item active">Ubah </li>
                </ol>
                <small class="text-danger">Tahun Buku : {{ periode()->open_date }} - {{ periode()->close_date }}</small>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title">FORM UBAH ROLE</h4>
            <div class="p-20">
                {!! Form::model($role, ['route' => ['role.update', $role->id], 'method'=>'put', 'class' => 'form-horizontal']) !!}
                    @include('role._form')
                {!! Form::close() !!}
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->
    <div class="col-lg-6">
        @php
            $accordion = 0;
        @endphp
            <div id="accordion" role="tablist" aria-multiselectable="true">
                @foreach ($module as $item)
                    <div class="card">
                        <div class="card-header" role="tab" id="heading{{$item->id}}">
                            <h6 class="mb-0 mt-0">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$item->id}}" class="text-dark collapsed"
                                    aria-expanded="{{ ($accordion == 0) ? 'true' : 'false'}}" aria-controls="collapse{{$item->id}}">
                                    {{ $item->name }}
                                </a>
                            </h6>
                        </div>
                        <div id="collapse{{$item->id}}" class="collapse {{ ($accordion == 0) ? 'show' : ''}}" role="tabpanel" aria-labelledby="heading{{$item->id}}" style="">
                            <div class="card-body">
                                @foreach ($item->permission as $row)
                                    <div class="checkbox checkbox-success form-check-inline">
                                        @php
                                            $permission_with_role = $row->permission_with_role($row->id, $role->id);
                                        @endphp
                                        <div class="checkbox checkbox-success form-check-inline">
                                            @if (!empty($permission_with_role))
                                                @if ($row->id == $permission_with_role->permission_id)
                                                    <input type="checkbox" id="inlineCheckbox{{$row->id}}" value="{{$row->id}}" checked="" data-permission="{{ $row->name }}">
                                                    <label for="inlineCheckbox{{$row->id}}"> {{ $row->display_name }} </label>
                                                @endif
                                            @else
                                                <input type="checkbox" id="inlineCheckbox{{$row->id}}" value="option{{$row->id}}" data-permission="{{ $row->name }}">
                                                <label for="inlineCheckbox{{$row->id}}"> {{ $row->display_name }} </label>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @php
                        $accordion++;
                    @endphp
                @endforeach
            </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', 'input[type=checkbox]', function(e){
                console.log($(this).data('permission'))
                if($(this).is(':checked')){
                    console.log("Checked")
                    $.ajax({
                        type:'POST',
                        url: '{{ route('permission.attach', $role->id) }}',
                        data: {
                            permission: $(this).data('permission')
                        },
                        success: function(data){
                            $.toast({
                                heading: 'Success !',
                                text: 'Telah Di Berikian Permission',
                                position: 'top-right',
                                loaderBg: '#bf441d',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 1
                            });
                        }
                    })
                } else {
                    $.ajax({
                        type:'POST',
                        url: '{{ route('permission.detach', $role->id) }}',
                        data: {
                            permission: $(this).data('permission')
                        },
                        success: function(data){
                            $.toast({
                                heading: 'Warning !',
                                text: 'Permission Telah Di Cabut',
                                position: 'top-right',
                                loaderBg: '#bf441d',
                                icon: 'warning',
                                hideAfter: 3000,
                                stack: 1
                            });
                        }
                    })
                }
            });
        })
    </script>
@endsection
