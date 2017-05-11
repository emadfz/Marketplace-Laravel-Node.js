<div class="row">
    <div class="col-md-12">
        <div class="portlet-body">
            <div class="table-toolbar margin-bottom-10">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ trans('form.global_setting.view_history') }} | {{ trans("form.global_setting.manage_ship_carrier") }}</h4>
            </div>
            <table id="settings-table" class="table">
                <thead>
                    <tr>
                        <th>{{trans("form.id")}}</th>
                        <th>{{ trans("form.global_setting.active_in_system") }}</th>
                        <th>{{ trans("form.global_setting.additional_profit_margin") }}</th>
                        <th>{{ trans("form.status") }}</th>
                        <th>{{ trans("form.global_setting.effective_from_date") }}</th>
                        <th>{{ trans("form.created_at") }}</th>
                        <th>{{ trans("form.updated_at") }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    $('#settings-table').DataTable({
        processing: true,
        serverSide: true,
        sorting:[[0,'desc']],
        ajax: '{{ route("getShippingCarrierSettingLog",$vendorId) }}',
        columns: [
            {data: 'id', name: 'id', visible: false},
            {data: 'active_in_system', name: 'active_in_system'},
            {data: 'additional_profit_margin', name: 'additional_profit_margin'},
            {data: 'status', name: 'status'},
            {data: 'effective_from_date', name: 'effective_from_date'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'}
        ]
    });
</script>