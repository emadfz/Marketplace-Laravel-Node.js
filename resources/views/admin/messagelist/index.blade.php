@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('messages') !!}
<input type="hidden" name="type" id="type" value="{{ $type }}">
<input type="hidden" id="view_msg_url" value="{{route(config('project.admin_route').'messagelist.view_msg')}}" >
<input type="hidden" id="reply_msg_url" value="{{route(config('project.admin_route').'messagelist.reply_msg')}}" >
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
                    <?php if(!empty($folder_name) && $folder_name != 'Inbox') { ?>
                        <span class="caption-subject">{{'Folder : '.$folder_name}}</span>
                    <?php } else { ?>
                        <?php if(!empty($type) && $type == 'draft'){ ?>
                            <span class="caption-subject bold">{{trans("message.messagelist.draft_title")}}</span>
                        <?php }else{ ?>
                            <span class="caption-subject bold">{{trans("message.messagelist.index_title")}}</span>
                        <?php } 
                    } ?>                        
                </div>
                
                <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                    <div class="inbox-body" style="padding:0px;">                          
                        <?php if(!empty($emp_dept)) { ?>
                            <div class="tabbable tabbable-tabdrop">                                
                                <ul class="nav nav-tabs">
                                  @foreach ( $emp_dept as $k=>$emp )
                                  <li>
                                      <a href="javascript:getsearch('{!! $emp !!}');">{{ $emp }}</a>
                                  </li>
                                  @endforeach
                                </ul>                     
                            </div>
                        <?php } ?>                                                                                                                   
                    <div class="portlet-body">
                    <div class="table-toolbar"></div>
                    
                    <div style="float:left;">
                        <div style="float:left;padding: 5px;">                            
                            <button id="deleteTriger" class="btn btn-danger">Delete</button>                            
                        </div>
                        <?php if(empty($type) || ($type != 'sent' && $type != 'draft')){ ?>
                        <div style="float:left; padding: 5px;">{{ Form::select('mark_as', array('0'=>'Mark As','read'=>'Read','unread'=>'Unread','flagged'=>'Flagged','unflagged'=>'UnFlagged'),NULL, ['class'=>'form-control','id'=>'mark_as'])}} </div>
                        <?php   
                        $operationname = getCurrentOperation();
                        
                            $folder_names = array_reduce($allfolders, function ($result, $folder) {
                            $result[$folder['id']] = $folder['folder_name'];return $result;}, array()); 
                            if($operationname == 'index' || $operationname == 'inbox'){?>
                        <div style="float:left; padding: 5px;">{{ Form::select('move_to', (['-1'=>'Move to']+$folder_names  ),NULL, ['class'=>'form-control','id'=>'move_to'])}} </div>
                            <?php }else { ?>
                        <div style="float:left; padding: 5px;">{{ Form::select('move_to', (['-1'=>'Move to','0'=>'Inbox']+$folder_names  ),NULL, ['class'=>'form-control','id'=>'move_to'])}} </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    
                    <?php if(!empty($folder_name)) { ?>
                    <input type="hidden" id="folder_name" value="{{ $folder_name }}" >
                    <?php } ?>
                    <!--<input type="hidden" id="inbox_url" value="{{route(config('project.admin_route').'messagelist.inbox1')}}" > -->
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="messagelist-table" >
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
    <div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{trans("message.messagelist.delete_title")}}</h4>
                </div>
                <div class="modal-body">
                    <p>{{trans('message.messagelist.delete_confirmation')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.messagelist.btn_cancel')}}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteGiftcards">{{trans('message.messagelist.btn_delete')}}</button>
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
    var oTable = $('#messagelist-table').DataTable({
        dom: "Bfrtip lrtip",
        autoWidth: false,
        processing: true,
        serverSide: false,
        data: <?php echo $allmessages; ?>,
        columns: [
            {data: 'id', name: 'id', width: '2%', orderable: false, searchable: false,
                render: function (data, type, full, meta){
                    return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">\n\
                            <input type="checkbox" class="ids_chk" name="id[]" class="mail-checkbox" value="' + $('<div/>').text(data).html() + '">\n\
                            <span></span>\n\
                            </label>';
                    }},
            {data: 'msg_isFlagged', name: 'msg_isFlagged', width : '2%', orderable : false ,searchable: false,
                render: function  (data, type, full, meta){                   
                        var msg_type = $('#type').attr('value');
                        if(msg_type != 'trash')
                        {
                            var flg_class = '';
                            if(data == 1)
                            { flg_class = 'inbox-started' }
                            return '<i class="fa fa-star '+flg_class+'"></i>';
                        }
                        return '';
                    }},
            {data: 'name', name: 'name', orderable: false, searchable: true, 'width': '20%',className: 'view-message hidden-xs'},            
            {data: 'msg_subject', name: 'msg_subject', orderable: false, searchable: true, 'width': '20%',className: 'view-message'},
            {data: 'created_at', name: 'Date', orderable: true, searchable: false, 'width': '10%',className: 'view-message text-right'},
        ],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            if ( aData["msg_isRead"] != 1 )
            {
                $(nRow).addClass( 'unread' );
            }
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
                data: {data_ids : ids_string, msg_type : $('#type').attr('value') },
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
        else
        {
            alert('Please select messages to delete');
        }
    }); 
    
    $('#mark_as').on("change", function(event){
        var mark_as = this.value;
        if( $('.ids_chk:checked').length > 0 ){  // at-least one checkbox checked
            var ids = [];            
            $('.ids_chk').each(function(){
                if($(this).is(':checked')) {
                    ids.push($(this).val());                    
                    if(mark_as == 'flagged'){ $(this).closest("tr").find('i').addClass("inbox-started"); }
                    else if(mark_as == 'unflagged'){ $(this).closest("tr").find('i').removeClass("inbox-started");  }
                    else if(mark_as == 'read'){                        
                        $(this).closest("tr").removeClass("unread");
                    }
                    else if(mark_as == 'unread'){     
                        $(this).closest("tr").addClass("unread");
                    }
                }
            });
            var ids_string = ids.toString();  // array to string conversion
            $.ajax({
                type: "POST",
                url: "{{route(config('project.admin_route').'messagelist.mark_as')}}",
                data: { data_ids : ids_string, msg_type : $('#type').attr('value'), mark_type : mark_as },
                success: function (r) {
                    if (r.status == "success") {
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
        $("#mark_as option:selected").removeAttr("selected");
    });
    
    $('#move_to').on("change", function(event){
        var move_to_value = this.value;
        if( $('.ids_chk:checked').length > 0 ){  // at-least one checkbox checked
            var ids = [];
            
            $('.ids_chk').each(function(){
                if($(this).is(':checked')) { 
                    $(this).closest("tr").addClass("movethis");
                    ids.push($(this).val());                    
                }
            });
            var ids_string = ids.toString();  // array to string conversion             
            $.ajax({
                type: "POST",
                url: "{{route(config('project.admin_route').'messagelist.move_to')}}",
                data: { data_ids : ids_string, msg_type : $('#type').attr('value') , move_to : move_to_value },
                success: function (r) {
                    if (r.status == "success") { 
                        $('.movethis').hide();
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
        $("#move_to option:selected").removeAttr("selected");
    });
</script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
@endpush
