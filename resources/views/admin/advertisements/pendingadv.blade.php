@extends('admin.layouts.app')
@section('content')

<div class="row">    
    <div class="col-md-12">
                       
        
        <div class="portlet light bordered">      
            <div class="portlet-title" >
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>                    
                        <span class="caption-subject">Advertisements List</span>                                         
                    </div> 
            </div> 
            @include('admin.advertisements.advertisetab')

            <div class="portlet-body">
                <div class="table-toolbar"></div>                                       
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="advertise-table">
                    <thead>
                        <tr>                           
                            <th>Type</th>
                            <th>Status</th>
                            <th>Ad Location</th>
                            <th>Advertise Name</th>
                            <th>StartDate</th>
                            <th>EndDate</th>
                            <th>Action</th>                                                
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
                <h4 class="modal-title">{{trans("message.messagefolder.delete_folder")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.messagefolder.are_you_sure_delete_folder')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('employee.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAttribute">{{trans('employee.delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')

@endpush

@push('scripts')
<script>
    $(document).ready(function () {
    var oTable = $('#advertise-table').DataTable({
        //dom: "lfprtip",
        dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
                "<'row'<'col-md-12'rt>>" +
                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
        autoWidth: false,
        processing: true,
        serverSide: true,
        "order": [[ 7, "desc" ]],
        ajax: {
            type: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("pendingadvadvertisementListing") }}',
        }, 
        columns: [
            {data: 'type', name: 'adv.type', width : '10%', orderable : true ,searchable: true ,className: 'dt-center'},            
            {data: 'status', name: 'status', orderable: true, searchable: false, 'width': '10%',className: 'dt-center',
            render: function (data, type, full, meta){                    
                    if(data == 1){ 
                        return '<span class="label label-sm label-success">Approved</span>'; 
                    }
                    else { 
                        if(data == -1)
                        {
                            return '<span class="label label-sm label-danger">Rejected</span>'; 
                        }
                        else
                        {
                            return '<span class="label label-sm label-info">Pending</span>';
                        }
                    }}},
            {data: 'location', name: 'location', width : '15%', orderable : true ,searchable: false ,className: 'dt-center'},
            {data: 'advr_name', name: 'advr_name', orderable: true, searchable: true, 'width': '20%',className: 'dt-center'},            
            {data: 'start_date', name: 'start_date', width : '15%', orderable : true ,searchable: false ,className: 'dt-center'},
            {data: 'end_date', name: 'end_date', width : '15%', orderable : true ,searchable: false ,className: 'dt-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false,className: 'dt-center','width': '5%'},
            {data: 'id', name: 'id', visible : false , searchable: false}
        ],
    });
    
    inboxsidebarpath=location.protocol + '//' + location.host + location.pathname;    
    $('.adv_menu').each(function() {
            if($(this).find('a[href="'+inboxsidebarpath+'"]').attr('href')){
                $(this).addClass('active');
            }                
    }); 
    
    var deleteUrl = '';
    $("#advertise-table").on("click", ".deleteAttribute", function (e) {
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
    
    $( document ).ajaxStop(function() {

     $('.approveAttribute').on('click', function (e) {
        e.preventDefault();
        approveUrl = $(this).data('attribute_approve_remote');        
        $.ajax({
            url: approveUrl,
            type: 'GET',
            dataType: 'json',            
            success: function (r) {                
                    if (r.success == 1) {
                        oTable.draw(false);
                        toastr.success(r.msg);
                    } else if (r.status == "error") {
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
    
});
});
</script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
@endpush
