@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('promotions') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("message.promotions.index_title")}}</span>
                </div>

                {!! getCreateButton() !!}
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
                </div>
                
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="promotions-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{trans("message.promotions.id")}}</th>
                                <th>{{trans("message.promotions.promo_code")}}</th>
                                <th>{{trans("message.promotions.discount")}}</th>                                                        
                                <th>{{trans("message.promotions.createdby")}}</th>
                                <th>{{trans("message.promotions.role")}}</th>                            
                                <th>{{trans("message.promotions.noofusers")}}</th>
                                <th>{{trans("message.promotions.start_date")}}</th>                                                        
                                <th>{{trans("message.promotions.end_date")}}</th>                                                        
                                <th>{{trans("message.promotions.updated_at")}}</th>                                                        
                                <th>{{trans("message.promotions.actions")}}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th search="false">{{trans("message.promotions.id")}}</th>
                                <th>{{trans("message.promotions.promo_code")}}</th>
                                <th>{{trans("message.promotions.discount")}}</th>                                                        
                                <th>{{trans("message.promotions.createdby")}}</th>
                                <th>{{trans("message.promotions.role")}}</th>                            
                                <th>{{trans("message.promotions.noofusers")}}</th>
                                <th>{{trans("message.promotions.start_date")}}</th>                                                        
                                <th>{{trans("message.promotions.end_date")}}</th>                                                        
                                <th>{{trans("message.promotions.updated_at")}}</th>                                                        
                                <th search="false">{{trans("message.promotions.actions")}}</th>
                            </tr>

                        </tfoot>

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
                <h4 class="modal-title">{{trans("message.promotions.delete_title")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.promotions.delete_confirmation')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('form.promotions.btn_cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeletePromotions">{{trans('form.promotions.btn_delete')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxmodel" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                
                <img src="{{URL('/assets/admin/global/img/loading-spinner-grey.gif')}}" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>







<?php //echo ($promotions);die; ?>
@endsection

@push('scripts')
<script>


    var oTable = $('#promotions-table').DataTable({
        dom: "Bfrtip lrtip",
        autoWidth: false,
        processing: true,
        serverSide: false,        
        data:<?php echo $promotions; ?>,
        columns: [
            {data: 'id', name: 'id', 'width': '10%'},
            {data: 'promo_code', name: 'promo_code', 'width': '10%'},
            {data: 'discount', name: 'discount', orderable: true, searchable: true, 'width': '10%'},
            {data: 'admin_users.first_name', name: 'admin_users.first_name', orderable: true, searchable: true, 'width': '10%'},
            {data: 'user_type', name: 'user_type', orderable: true, searchable: true, 'width': '10%'},
            {data: 'selected_users', name: 'selected_users', orderable: true, searchable: true, 'width': '10%'},
            {data: 'start_date', name: 'start_date', orderable: false, searchable: true, 'width': '10%'},
            {data: 'end_date', name: 'end_date', orderable: false, searchable: true, 'width': '10%'},
            {data: 'updated_at', name: 'updated_at', orderable: false, searchable: true, 'width': '10%'},
            {data: 'action', name: 'action', orderable: false, searchable: true, 'width': '10%'},
        ],
        fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {            
            if (aData.selected_users != "all")
            {   
                $('td:eq(5)', nRow).html('<a data-target="#ajaxmodel" data-toggle="modal" href="promotions/getprmotionusers/'+aData.id+'">' + aData.selected_users.split(',').length + '</a>');
            }
        },
        buttons: [
            {"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print"]
    });

//    $('#search-form').on('submit', function (e) {
//        oTable.draw();
//        e.preventDefault();
//    });

    //$(document).ready(function () {
    var deleteUrl = '';
    $("#promotions-table").on("click", ".deletePromotions", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');
        deleteUrl = $(this).data('promotions_delete_remote');        
        $(this).closest("tr").addClass("deletethis");
    });

    $('#confirmDeletePromotions').on('click', function (e) {
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
    
$(document).ready(function() {        
    
     $('#promotions-table tfoot  th').each( function () {         
        var title = $(this).text();        
        if(!$(this).attr('search') && $(this).attr('search')!='false')
            $(this).html( '<input type="text" style="width:'+parseInt(title.length*15)+'px" placeholder="Search '+title+'" />' );
        
    } );

    // Apply the search
    oTable.columns().every( function () {
        var that = this;        
        $( 'input', this.footer() ).on( 'keyup change', function () {                        
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );
$( "#promotions-table" ).wrap( "<div class='table-responsive' style='width:100%'></div>" );
</script>
@endpush
