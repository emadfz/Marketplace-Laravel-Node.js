@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('productConditions') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("message.product_conditions.index_title")}}</span>
                </div>
                
                {!! getCreateButton() !!}
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="productConditions-table">
                    <thead>
                        <tr>
                            <th>{{trans("message.product_conditions.id")}}</th>
                            <th>{{trans("message.product_conditions.name")}}</th>
                            <th>{{trans("message.product_conditions.description")}}</th>                                                        
                            <th>{{trans("message.product_conditions.created_at")}}</th>                                                        
                            <th>{{trans("message.product_conditions.updated_at")}}</th>                                                        
                            <th>{{trans("message.product_conditions.actions")}}</th>
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
                <h4 class="modal-title">{{trans("message.product_conditions.delete_title")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.product_conditions.delete_confirmation')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('form.product_conditions.btn_cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteProductCondition">{{trans('form.product_conditions.btn_delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>


    var oTable = $('#productConditions-table').DataTable({
        dom: "Bfrtip lrtip",
        autoWidth: false,
        processing: true,
        serverSide: false,
        data:<?php echo $productConditions; ?>,
        columns: [
            {data: 'id', name: 'id', 'width': '10%'},
            {data: 'name', name: 'name', 'width': '20%'},
            {data: 'description', name: 'description', orderable: true, searchable: true, 'width': '10%'},                        
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
    $("#productConditions-table").on("click", ".deleteProduct_conditions", function (e) {        
        e.preventDefault();
        $('#confirmDelete').modal('show');
        deleteUrl = $(this).data('product_conditions_delete_remote');        
        $(this).closest("tr").addClass("deletethis");
    });

    $('#confirmDeleteProductCondition').on('click', function (e) {        
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
                     window.location.reload();
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
