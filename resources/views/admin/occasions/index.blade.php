@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('occasions') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("message.occasions.index_title")}}</span>
                </div>
                
                {!! getCreateButton() !!}
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="occasions-table">
                    <thead>
                        <tr>                             
                            <th>{{trans("message.occasions.datatable_id")}}</th>
                            <th>{{trans("message.occasions.datatable_name")}}</th>                            
                            <th>{{trans("message.occasions.datatable_status")}}</th>                                                                                    
                            <th>{{trans("message.occasions.datatable_start_date")}}</th>
                            <th>{{trans("message.occasions.datatable_end_date")}}</th>
                            <th>{{trans("message.occasions.datatable_created_at")}}</th>
                            <th>{{trans("message.occasions.datatable_updated_at")}}</th>
                            <th>{{trans("message.occasions.datatable_action")}}</th>
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
                <h4 class="modal-title">{{trans("message.occasions.delete_title")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.occasions.delete_confirmation')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.occasions.btn_cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteOccasions">{{trans('message.occasions.btn_delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>


    var oTable = $('#occasions-table').DataTable({
        dom: "Bfrtip",
        autoWidth: false,
        processing: true,
        serverSide: false,
        data:<?php echo $occasions; ?>,
        "order": [[ 1, "asc" ]],
        columns: [
            {data: 'id', name: 'id', 'width': '10%'},
            {data: 'name', name: 'name', 'width': '20%'},
            {data: 'status', name: 'status', orderable: true, searchable: true, 'width': '10%'},            
            {data: 'start_date', name: 'start_date', 'width': '10%', 'className': 'dt-center'},
            {data: 'end_date', name: 'end_date', 'width': '10%', 'className': 'dt-center'},
            {data: 'created_at', name: 'created_at', orderable: false, searchable: true, 'width': '10%'},
            {data: 'updated_at', name: 'updated_at', orderable: false, searchable: true, 'width': '10%'},
            {data: 'action', name: 'action', orderable: false, searchable: true, 'width': '10%'},
        ],        
        buttons: [

        {"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print"]
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    //$(document).ready(function () {
    var deleteUrl = '';
    $("#occasions-table").on("click", ".deleteOccasions", function (e) {        
        e.preventDefault();
        $('#confirmDelete').modal('show');
        deleteUrl = $(this).data('occasions_delete_remote');
        $(this).closest("tr").addClass("deletethis");
    });

    $('#confirmDeleteOccasions').on('click', function (e) {
        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true},
            success: function (r) {
                if (r.status == "success") {
                    $('.deletethis').hide();
                    $('#confirmDelete').modal('hide');
                    oTable.draw(true);
                    toastr.success(r.msg);
                } else if (r.status == "error") {
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
    //});

</script>
@endpush
