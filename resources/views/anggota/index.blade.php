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
            <div class="float-left">
                <h4 class="page-title">Anggota </h4>
                <small class="text-danger">Periode : {{ periode()->name }}</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Anggota</li>
                </ol>
                <small class="text-danger">Tahun Buku : {{ periode()->open_date }} - {{ periode()->close_date }}</small>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Inisial</th>
                        <th>Tanggal Daftar</th>
                        <th>Home Base</th>
                        <th>Status</th>
                        <th>ACTION DEFAULT</th>
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
        var oTable = $('#datatable-buttons').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('anggota.index') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'inisial', name: 'inisial' },
                { data: 'tgl_daftar', name: 'tgl_daftar' },
                { data: 'homebase', name: 'homebase' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            dom: '<"toolbar">frtip',
            order: [[ 0, "desc" ]],
            scrollX: true
        });
        $("div.toolbar").html(`@permission('create-anggota')<a href="{{ route('anggota.create') }}" class="btn btn-gradient waves-light waves-effect w-md">Tambah</a>@endpermission
        @permission('download-anggota')<a href="{{ route('anggota.export') }}" class="btn btn-success waves-light waves-effect w-md"><i class="mdi mdi-file-excel"></i>Download</a>@endpermission`);

    });
</script>
@endsection
