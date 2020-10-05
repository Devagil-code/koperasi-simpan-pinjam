@extends('layouts.master')
@section('style')
<!-- DataTables -->
<link href="{{ asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title float-left">Permission</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Permission</a></li>
                <li class="breadcrumb-item active">Permission</li>
            </ol>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
@if (session()->has('flash_notification.message'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    </div>
</div>
@endif
<!-- end row -->
<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <table id="table" class="table table-sm table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nama Permission</th>
                        <th>Displayy</th>
                        <th>Deskripsi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('script')
<!-- Required datatable js -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
<script>
    $(document).ready(function(){
        var oTable = $('#table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('permission.index') }}",
                        columns: [
                            { data: 'name', name: 'name' },
                            { data: 'display_name', name: 'display_name' },
                            { data: 'description', name: 'description' },
                            { data: 'action', name: 'action', searchable: false, orderable: false }
                        ],
                        order: [[ 0, "desc" ]],
                        dom: '<"toolbar">frtip',
                    });
        $("div.toolbar").html(`<a href="{{ route('permission.create') }}" class="btn btn-gradient btn-rounded waves-light waves-effect w-md">Tambah Permission</a>`);

    });
</script>
@endsection
