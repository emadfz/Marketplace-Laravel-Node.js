@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('modules') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("form.module.index_title")}}</span>
                </div>
                
             <?php  /*   {!! getCreateButton() !!}*/ ?>
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="module-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.module.id")}}</th>
                            <th>{{trans("form.module.module_name")}}</th>                            
                            <th>{{trans("form.module.actions")}}</th>                                                        
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
                <h4 class="modal-title">{{trans("message.module.delete_title")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.module.delete_confirmation')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.module.btn_cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteModule">{{trans('message.module.btn_delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>


    var oTable = $('#module-table').DataTable({
        dom: "Bfrtip",
//        dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
//                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
//                "<'row'<'col-md-12'rt>>" +
//                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
        autoWidth: false,
        processing: true,
        serverSide: false,
        data:<?php echo $module; ?>,
        columns: [
            {data: 'id', name: 'id', 'width': '20%'},
            {data: 'alias_name', name: 'alias_name', 'width': '70%'},
            
            {data: 'action', name: 'action', orderable: false, searchable: true, 'width': '10%'},
        ],        
//        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                                         
//                if ( aData[4] == "A" )
//                {                    
//                        $('td:eq(4)', nRow).html( '<b>A</b>' );
//                }
//        },
        buttons: [
//                {
//                text: '<b>Create</b>',
//                action: function ( e, dt, node, config ) {                    
//                                        
//                }             
//            },
        {"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print"]
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    //$(document).ready(function () {
    var deleteUrl = '';
    $("#module-table").on("click", ".deleteModule", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');
        deleteUrl = $(this).data('module_delete_remote');
    });

    $('#confirmDeleteModule').on('click', function (e) {
        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true},
            success: function (r) {
                if (r.status == "success") {
                    $('#confirmDelete').modal('hide');                     
                    //oTable.draw(true);
                    window.location.reload();
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
