@if ($model->status_saldo == 0)
@permission($can_edit)
<a href="{{ $edit_url }}" class="btn btn-space btn-primary active btn-sm">Ubah</a>
@endpermission
<a href="{{ $copy_saldo }}" class="btn btn-space btn-success active btn-sm">Copy</a>
@endif

