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
            <h4 class="page-title float-left">Transaksi Harian</h4>

            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                <li class="breadcrumb-item active">Transaksi Harian</li>
            </ol>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Divisi</th>
                        <th>Transaksi</th>
                        <th>Keterangan</th>
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
                        ajax: "{{ route('transaksi-harian.index') }}",
                        columns: [
                            {data: 'id', name: 'id'},
                            {data: 'tgl', name: 'tgl'},
                            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
                            {data: 'divisi.name', name: 'divisi.name'},
                            {data: 'jenis_transaksi', name: 'jenis_transaksi'},
                            {data: 'keterangan', name: 'keterangan'},
                        ],
                        dom: '<"toolbar">frtip',
                        order: [[ 0, "desc" ]]
                    });
                    $("div.toolbar").html('<a href="{{ route('transaksi-harian.create') }}" class="btn btn-gradient btn-rounded waves-light waves-effect w-md">Tambah Transaksi</a>');

    });
</script>
@endsection
