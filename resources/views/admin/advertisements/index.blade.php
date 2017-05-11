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
                            <th>id</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Ad Location</th>
                            <th>Advertise Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
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
                <h4 class="modal-title">{{trans("message.advertisements.delete_adv")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.advertisements.are_you_sure_delete_ad')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.advertisements.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAttribute">{{trans('message.advertisements.delete')}}</button>
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

    $(window).load(function(){
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
            url: '{{ route("advertisementListing") }}',
        }, 
        columns: [
            {data: 'id', name: 'id', width : '10%', orderable : true ,searchable: false ,className: 'dt-center'},            
            {data: 'type', name: 'type', width : '10%', orderable : true ,searchable: false ,className: 'dt-center'},            
            {data: 'status', name: 'status', orderable: true, searchable: false, 'width': '10%',className: 'dt-center',
            render: function (data, type, full, meta){
                    if(data == 1){
                        return '<span class="label label-sm label-success">Approved</span>'; 
                    }
                    else if(data == 2){
                        return '<span class="label label-sm label-warning">Paused</span>'; 
                    } 
                    else if(data == 3){
                        return '<span class="label label-sm label-danger">Resumed</span>'; 
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
            {data: 'location', name: 'location', width : '15%', orderable : true ,searchable: true ,className: 'dt-center'},
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
}); 
</script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
@endpush
