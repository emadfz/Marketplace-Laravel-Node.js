<div class="row">
    <div class="col-md-12">
        <div class="portlet-body">
            <div class="table-toolbar margin-bottom-10">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ trans('form.global_setting.view_history') }} | {{ trans("form.global_setting.reward_points_setting") }}</h4>
            </div>
            <table id="reward-settings-table" class="table">
                <thead>
                    <tr>
                        <th>{{trans("form.id")}}</th>
                        <th>{{ trans("form.global_setting.buyer_earns_reward_point_on_purchase_of_every") }}</th>
                        <th>{{ trans("form.global_setting.one_reward_point") }}</th>
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
    $('#reward-settings-table').DataTable({
        processing: true,
        serverSide: true,
        sorting: [[0, 'desc']],
        ajax: '{{ route("getRewardPointSettingLog") }}',
        columns: [
            {data: 'id', name: 'id', visible: false},
            {data: 'buyer_earns_reward_point_on_purchase_of_every', name: 'buyer_earns_reward_point_on_purchase_of_every'},
            {data: 'reward_point_value', name: 'reward_point_value'},
            {data: 'status', name: 'status'},
            {data: 'effective_from_date', name: 'effective_from_date'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'}
        ]
    });
</script>