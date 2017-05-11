@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('giftcards') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("message.giftcards.index_title")}}</span>
                </div>
                
                {!! getCreateButton() !!}
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="giftcards-table">
                    <thead>
                        <tr>                             
                            <th>{{trans("message.giftcards.datatable_id")}}</th>
                            <th>{{trans("message.giftcards.datatable_title")}}</th>
                            <th>{{trans("message.giftcards.datatable_price")}}</th>
                            <th>{{trans("message.giftcards.datatable_status")}}</th>
                            <th>{{trans("message.giftcards.datatable_image")}}</th>
                            <th>{{trans("message.giftcards.datatable_quantity")}}</th>
                            <th>{{trans("message.giftcards.datatable_listing_date")}}</th>
                            <th>{{trans("message.giftcards.datatable_actions")}}</th>                                                        
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
                <h4 class="modal-title">{{trans("message.giftcards.delete_title")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.giftcards.delete_confirmation')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.giftcards.btn_cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteGiftcards">{{trans('message.giftcards.btn_delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>


    var oTable = $('#giftcards-table').DataTable({
        dom: "Bfrtip",
//        dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
//                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
//                "<'row'<'col-md-12'rt>>" +
//                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
        autoWidth: false,
        processing: true,
        serverSide: false,
        data:<?php echo $giftCards; ?>,
        columns: [
            {data: 'id', name: 'id', 'width': '20%'},
            {data: 'title', name: 'title', 'width': '20%'},
            {data: 'price', name: 'price', orderable: false, searchable: true, 'width': '10%'},
            {data: 'status', name: 'status', orderable: false, searchable: true, 'width': '10%'},
            {data: 'image', name: 'image', 'width': '20%', 'className': 'dt-center'},
            {data: 'quantity', name: 'quantity', 'width': '20%', 'className': 'dt-center'},
            {data: 'created_at', name: 'created_at', orderable: false, searchable: true, 'width': '10%'},
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
    $("#giftcards-table").on("click", ".deleteGiftcards", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');
        deleteUrl = $(this).data('giftcards_delete_remote');
        $(this).closest("tr").addClass("deletethis");
    });

    $('#confirmDeleteGiftcards').on('click', function (e) {
        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true},
            success: function (r) {
                if (r.status == "success") {
                    $('.deletethis').hide();
                    $('#confirmDelete').modal('hide');                     
                    oTable.draw(false);
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
