@extends('admin.layouts.app')

@section('content')
<input type="hidden" id="folder_name" value="sent" >
<input type="hidden" name="type" id="type" value="{{ $type }}">
<input type="hidden" id="view_msg_url" value="{{route(config('project.admin_route').'messagelist.view_msg')}}" >                    
                    
<div class="inbox">
<div class="row">
    <div class="col-md-2" style="padding-right: 0px;">
         @include('admin.messagelist.message_sidebar')
    </div>
    
    <div class="col-md-10">    
        <div class="portlet light bordered" id="msg_details">            
            <div class="portlet-title" >
                <div class="caption font-dark" style="width: 100% !important;">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("message.messagelist.index_title")}}</span>
                </div>                
                
                <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                    <div class="inbox-body" style="padding:0px;">                                                  
                                                                                       
                    <div class="portlet-body">
                    <div class="table-toolbar"></div>
                    <div style="float:left;">
                        <div style="float:left;padding: 5px;">                            
                            <button id="deleteTriger" class="btn btn-danger">Delete</button>                            
                        </div>
                        <?php if(empty($type) || $type != 'sent'){ ?>
                        <div style="float:left; padding: 5px;">{{ Form::select('mark_as', array('0'=>'Mark As','read'=>'Read','unread'=>'Unread','flagged'=>'Flagged','unflagged'=>'UnFlagged'),NULL, ['class'=>'form-control','id'=>'mark_as'])}} </div>
                        <?php                        
                            $folder_names = array_reduce($allfolders, function ($result, $folder) {
                            $result[$folder['id']] = $folder['folder_name'];return $result;}, array()); ?>
                        <div style="float:left; padding: 5px;">{{ Form::select('move_to', (['-1'=>'Move to','0'=>'Inbox']+$folder_names  ),NULL, ['class'=>'form-control','id'=>'move_to'])}} </div>
                        <?php } ?>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="giftcards-table">
                        <thead>
                            <tr>                             
                                <th class="sorting_disabled mt-checkbox-th">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input name="select_all" id="example-select-all" class="mail-checkbox" type="checkbox">
                                    <span></span>
                                    </label>
                                </th>
                                <th></th>
                                <th></th>                            
                                <th>{{trans("message.messagelist.date")}}</th>                                                
                            </tr>
                        </thead>
                    </table>
                    </div>                               
                                                    
                    </div>
                </div>                            
        </div>
        </div>
    </div>
</div>
</div>

@endsection

@push('styles')
<link href="{{ asset('assets/admin/apps/css/inbox.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/admin/apps/scripts/inbox.min.js') }}" type="text/javascript"></script>
<script>    
    
    var oTable = $('#giftcards-table').DataTable({
        dom: "Bfrtip lrtip",
        autoWidth: false,
        processing: true,
        serverSide: false,
        data:<?php echo $allmessages; ?>,
        columns: [
            {data: 'id', name: 'id', 'width': '2%', orderable: false, searchable: false,
                'render': function (data, type, full, meta){
                    return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">\n\
                            <input type="checkbox" class="ids_chk" name="id[]" class="mail-checkbox" value="' + $('<div/>').text(data).html() + '">\n\
                            <span></span>\n\
                            </label>';
                    }},
            {data: 'name', name: 'name', orderable: false, searchable: true, 'width': '20%',className: 'view-message hidden-xs'},            
            {data: 'msg_subject', name: 'msg_subject', orderable: false, searchable: true, 'width': '20%',className: 'view-message'},
            {data: 'created_at', name: 'Date', orderable: true, searchable: false, 'width': '10%',className: 'view-message text-right'},
        ],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {           
            $(nRow).attr( 'data-messageid', aData["id"]);
            return nRow;
        },
        buttons: []
    });
    
    $('#deleteTriger').on("click", function(event){ // triggering delete one by one
        if( $('.ids_chk:checked').length > 0 ){  // at-least one checkbox checked
            var ids = [];
            $('.ids_chk').each(function(){
                if($(this).is(':checked')) { 
                    $(this).closest("tr").addClass("deletethis");
                    ids.push($(this).val());
                    
                }
            });
            var ids_string = ids.toString();  // array to string conversion             
            $.ajax({
                type: "POST",
                url: "{{route(config('project.admin_route').'messagelist.delete')}}",
                data: {data_ids:ids_string, msg_type :'sent'},
                success: function (r) {
                    if (r.status == "success") {                        
                        $('.deletethis').hide();
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
                },
                async:false
            });
        }
    }); 
    
</script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}" type="text/javascript"></script>
@endpush
