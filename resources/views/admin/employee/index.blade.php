@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('employees') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("employee.all_employee")}}</span>
                </div>
                {!! getCreateButton() !!}
            </div>

            <div class="portlet-body">
                <div class="table-toolbar"></div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="attribute-table">
                    <thead>
                        <tr>
                            <th>EmpCode</th>
                            <th>{{ trans('employee.first_name') }}</th>
                            <th>{{ trans('employee.last_name') }}</th>   
                            <th>{{ trans('employee.employee_level') }}</th>                               
                            <th>{{ trans('employee.type_of_hire') }}</th>
                            <th>{{ trans('employee.service_location') }}</th>
                            <th>{{ trans('employee.contact_number') }}</th>
                            <th>{{ trans('employee.status') }}</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{trans("employee.delete_employee")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('employee.are_you_sure_delete_employee')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('employee.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAttribute">{{trans('employee.delete')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmblock" role="dialog" aria-labelledby="confirmBlockLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{trans("employee.block_employee")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('employee.are_you_sure_block_employee')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('employee.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmBlockAttribute">{{trans('employee.block')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .wordwrapcol{
        max-width:120px !important;
        word-wrap: break-word;
    }
</style>
@endpush
@push('scripts')
<script>
    var oTable = $('#attribute-table').DataTable({
        dom: "Bfrtip lrtip",
        autoWidth: false,
        processing: true,
        serverSide: true,
        "order": [[ 8, "desc" ]],
        ajax: {
            type: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("employeeListing") }}',
        },
        columns: [
            {data: 'employee_code', name: 'employee_code','className': 'dt-center',searchable: true,width : '10%',
                render: function ( data, type, full, meta )
                {                                        
                    return data;
                }
            },
            {data: 'first_name', name: 'first_name',width : '15%','className': 'dt-center',searchable: true },
            {data: 'last_name', name: 'last_name',width : '15%','className': 'dt-center',searchable: true},   
            {data: 'level_name', name: 'level_name',width : '15%','className': 'dt-center',searchable: true},               
            {data: 'type_of_hire', name: 'type_of_hire',width : '15%','className': 'dt-center',searchable: true},
            {data: 'service_location', name: 'service_location',width : '10%','className': 'dt-center',searchable: true},
            {data: 'contact_number', name: 'contact_number',width : '10%',orderable: false, searchable: true,'className': 'dt-center'},
            {data: 'confirmed', name: 'confirmed','className': 'dt-center', width : '5%', searchable: false, orderable: false ,
                render: function ( data, type, full, meta )
                {
                    var res = '';
                    if(data == 1)
                    {  res = '<i class="fa fa-check">Confirmed</i>';   }
                    else
                    {  res = ''; }
                    if(full.status == 'Blocked')
                    {
                        res += '<span class="glyphicon glyphicon-ban-circle">Blocked </span>';
                    }
                    return res;
                }
            },
            {data: 'action', name: 'action', orderable: false, searchable: false,'width': '15%'},
            {data: 'id', name: 'id', visible : false , searchable: false}
        ],
        oLanguage: {sLengthMenu: "<select style='margin:5px 0 0 15px;' class='selectpicker'>\n\
                                                <option value='10' selected='selected'>10</option>\n\
                                                <option value='25'>25</option>\n\
                                                <option value='50'>50</option><option value='100'>100</option>\n\
                                                <option value='-1'>All</option>\n\
                                  </select>"
                    },
        buttons: [
        {"extend": "collection","text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]},"print"]
    
    });    
    

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    var deleteUrl = '';
    $("#attribute-table").on("click", ".deleteAttribute", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');
        deleteUrl = $(this).data('attribute_delete_remote');
    });

    $('#confirmDeleteAttribute').on('click', function (e) {
        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true},
            success: function (r) {
                if (r.success == 1) {
                    $('#confirmDelete').modal('hide');
                    oTable.draw(false);
                    toastr.success(r.msg);
                } else if (r.success == 0) {
                    toastr.error(r.msg, "{{ trans('message.failure') }}", {timeOut: 10000});
                    $('#confirmDelete').modal('hide');
                }
            },
            error: function (data) {
                if (data.status === 422) {
                    toastr.error("{{ trans('message.failure') }}");
                }
            }
        });
    });
    
    var blockUrl = '';
    $("#attribute-table").on("click", ".blockattribute", function (e) {
        e.preventDefault();
        $('#confirmblock').modal('show');
        blockUrl = $(this).data('attribute_block_remote');
    });
        
    $('#confirmBlockAttribute').on('click', function (e) {
        $.ajax({
            url: blockUrl,
            type: 'GET',            
            data: { submit: true},
            success: function (r) {
                if (r.success == 1) {
                    $('#confirmblock').modal('hide');
                    oTable.draw(false);
                    toastr.success(r.msg);
                } else if (r.success == 0) {
                    toastr.error(r.msg, "{{ trans('message.failure') }}", {timeOut: 10000});
                    $('#confirmblock').modal('hide');
                }
            },
            error: function (data) {
                if (data.status === 422) {
                    toastr.error("{{ trans('message.failure') }}");
                }
            }
        });
    });
        
    $("#attribute-table").on("click", ".unblockattribute", function (e) {    
        unblockUrl = $(this).data('attribute_unblock_remote');        
        $.ajax({
            url: unblockUrl,
            type: 'GET',            
            data: { submit: true},
            success: function (r) {
                if (r.success == 1) {                    
                    oTable.draw(false);
                    toastr.success(r.msg);
                } else if (r.success == 0) {
                    toastr.error(r.msg, "{{ trans('message.failure') }}", {timeOut: 10000});                    
                }
            },
            error: function (data) {
                if (data.status === 422) {
                    toastr.error("{{ trans('message.failure') }}");
                }
            }
        });
    });
    
</script>
@endpush
