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
                <h4 class="page-title">Divisi Kredit </h4>
                <small class="text-danger">Periode : {{ periode()->name }}</small>
            </div>
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                <li class="breadcrumb-item active"><a href="{{route('divisi-kredit.index')}}">Divisi Kredit</a></li>
                </ol>
                <small class="text-danger">Tahun Buku : {{ periode()->open_date }} - {{ periode()->close_date }}</small>
            </div>
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
<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Divisi</th>
                        <th>Transaksi</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Status Buku</th>
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
                        ajax: "{{ route('divisi-kredit.index') }}",
                        columns: [
                            { data: 'id', name: 'id' },
                            { data: 'tgl', name: 'tgl' },
                            { data: 'jenis_pembayaran', name: 'jenis_pembayaran' },
                            { data: 'divisi.name', name: 'divisi.name' },
                            { data: 'jenis_transaksi', name: 'jenis_transaksi' },
                            { data: 'sumKreditAll', name: 'sumKreditAll' },
                            { data: 'keterangan', name: 'keterangan' },
                            { data: 'is_close', name: 'is_close' },
                            { data: 'action', name: 'action', orderable: false, searchable: false},
                        ],
                        dom: '<"toolbar">frtip',
                        order: [[ 0, "desc" ]],
                        scrollX: true
                    });
                    @permission('create-kredit-divisi')
                    $("div.toolbar").html(`<a href="{{ route('divisi-kredit.create') }}" class="btn btn-gradient waves-light waves-effect w-md"><i class="fa fa-plus"></i> Tambah</a>
                    @if(Pembukuan::closeBookDivisi('2') == '1')
                        <a href="{{ route('divisi-kredit.close-book') }}" class="btn btn-danger waves-light waves-effect w-md"><i class="fa fa-book"></i> Tutup Buku</a>
                    @endif
                    `);
                    @endpermission

    });
</script>
@endsection
