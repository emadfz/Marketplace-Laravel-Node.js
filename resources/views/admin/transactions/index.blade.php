@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('forums') !!}

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{trans("form.vendors.manage_vendors")}}</span>
                </div>
                <div class="actions">
                    
                </div>
            </div>
            <br>
            <div class="btn-group">
                        @foreach($vendor_types['all_vendor_types'] as $id=>$vendor_type_name)
                            <a href= "javascript:getvendor('{!! $id !!}');" class="btn sbold default">{!! $vendor_type_name !!}</i></a>                            
                        @endforeach 
            </div>
            <div class="btn-group1">
            
            </div> 
            
            
            
            
<div class="row accinfo">
                                            <div class="col-md-6">
                                                <h3>Account Number</h3>
                                                <div class="well">
                                                    <address>
                                                        <strong>Loop, Inc.</strong>
                                                        <br> 795 Park Ave, Suite 120
                                                        <br> San Francisco, CA 94107
                                                        <br>
                                                        <abbr title="Phone">P:</abbr> (234) 145-1810 </address>
                                                    <address>
                                                        <strong>Full Name</strong>
                                                        <br>
                                                        <a href="mailto:#"> first.last@email.com </a>
                                                    </address>
                                                </div>
                                            </div>
                                            
</div>            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <div class="portlet-body">
                <div class="table-toolbar">
<!--                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <button class="btn blue btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-print"></i> Print </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>-->
                </div>
                <div class="table-scrollable">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="categories-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.forums.id")}}</th>
                            <th>{{trans("form.forums.topic_name")}}</th>
                            <th>{{trans("form.forums.department")}}</th>
                            <th>{{trans("form.forums.posted_date")}}</th>
                            <th>{{trans("form.forums.member_id")}}</th>
                            <th>{{trans("form.forums.status")}}</th>
                            <th>{{trans("form.forums.total_likes")}}</th>   
                            <th>{{trans("form.forums.total_dislikes")}}</th>   
                            <th>{{trans("form.forums.comments")}}</th>   
                            <th>{{trans("form.forums.views")}}</th>   
                            <th>{{trans("form.forums.last_activity_date")}}</th>
                            <th>{{trans("form.forums.action")}}</th>
                        </tr>
                    </thead>


                </table>
                </div>    
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
                <h4 class="modal-title">{{trans("form.forums.delete_topic")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.forums.are_you_sure_delete_topic')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('form.forums.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCategory">{{trans('form.forums.delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    //$(document).ready(function () {
    var categorydeleteUrl = '';
    $("#categories-table").on("click", ".deleteCategory", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');
        categorydeleteUrl = $(this).data('category_delete_remote');
    });
    $('#confirmDeleteCategory').on('click', function (e) {
        $.ajax({
            url: categorydeleteUrl,
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
    //});
function getvendor(vendor_types_id){

        $.get('{{ url('information') }}/getvendors/ajax-state?vendor_types_id=' + vendor_types_id, function(data) {            
            $('.btn-group1').empty();
            $.each(data, function(index,subCatObj){ 
                $('.btn-group1').append('<a href="javascript: getaccountinfo('+subCatObj.id+');" class="btn sbold default">'+subCatObj.vendor_name+'</i></a>');
            });
                $('.btn-group1').append('<a href="http://localhost/marketplacedev/marketplace/public/admin/transaction/create/'+vendor_types_id+'" class="btn sbold default">Add New Transaction &nbsp;<i class="fa fa-plus"></i></a>');
                $('.btn-group1').append('<a href="http://localhost/marketplacedev/marketplace/public/admin/vendors/create" class="btn sbold default">Add New Vendor &nbsp;<i class="fa fa-plus"></i></a>');
        });
     
}
function getaccountinfo(id){

        $.get('{{ url('information') }}/getvendorsacccount/ajax-state?id=' + id, function(data) {            
            $('.accinfo').empty();
            $.each(data, function(index,subCatObj){ 
                $('.accinfo').append('<div class="col-md-6"><h3>Account Number : '+subCatObj.account_number+'</h3><div class="well"><address><strong>'+subCatObj.vendor_name+'</strong><br> '+subCatObj.contact_person+'<br> '+subCatObj.address_line1+', '+subCatObj.zipcode+'<br><abbr title="Phone">P:</abbr> '+subCatObj.contact_number+' </address><address><strong>Full Name</strong><br><a href="mailto:#"> '+subCatObj.contact_email+' </a></address></div></div>');
// Datatable starts here                
    var oTable = $('#categories-table').DataTable({
        //dom: "lfprtip",
         retrieve: true,
        dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
                "<'row'<'col-md-12'rt>>" +
                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
        processing: true,
        serverSide: true,
        ajax: {
            //type: 'POST',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("adminForumsListing") }}',
        },
        columns: [
            {data: 'id', name: 'forums.id'},
            {data: 'topic_name', name: 'forums.topic_name'},
            {data: 'employee_departments.department_name', name: 'forums.employee_departments.department_name'},
            {data: 'created_at', name: 'forums.created_at'},
            {data: 'admin_users.first_name', name: 'admin_users.first_name'},
            {data: 'status', name: 'forums.status'},
            {data: 'total_likes', name: 'forums.total_likes'},
            {data: 'total_dislikes', name: 'forums.total_dislikes'},
            {data: 'total_comments', name: 'forums.total_comments'},
            {data: 'total_views', name: 'forums.total_views'},
            {data: 'updated_at', name: 'forums.updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ],
        //buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print", "reset", "reload"]
    });                
      // Datatable Ends here          
        });
        });
     
}
</script>
@endpush
