@push('styles')
<link rel="stylesheet" href="{{ asset('asset_admin/plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('asset_admin/plugins/datatables/buttons.dataTables.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('asset_admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush