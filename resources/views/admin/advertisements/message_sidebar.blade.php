<div class="modal fade bs-modal-sm" id="small" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="#" method="POST" id="folderform">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Folder name</h4>
                </div>
                <div class="modal-body"> 
                    <input type="text" name="folder_name" class="form-control"> 
                    <div class="help-block error">The Folder name is required.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn green">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="inbox-sidebar page-sidebar-menu" style="padding: 0px;">
    <a href="{{route(config('project.admin_route').'messagelist.create')}}" data-title="Compose" class="btn red compose-btn btn-block">
        <i class="fa fa-edit"></i> Compose </a>
        <ul class="inbox-nav" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="msginbox nav-item">
                <a href="{{route(config('project.admin_route').'messagelist.index')}}" class="nav-link nav-toggle">Inbox
                    <?php if($countallmessages['inbox'] > 0) { ?><span class="badge badge-info">{{$countallmessages['inbox']}}</span><?php } ?>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu inbox-nav" style="margin: 0px 0px 0px 15px;">
                    <li class="msginbox">
                        <a href="{{route(config('project.admin_route').'messagelist.inbox',['user_type'=>'employee'])}}">Employees
                            <?php if($countallmessages['employee'] > 0) { ?><span class="badge badge-info">{{$countallmessages['employee']}}</span><?php } ?>
                        </a>
                    </li>
                    <li class="msginbox">
                        <a href="{{route(config('project.admin_route').'messagelist.inbox',['user_type'=>'member'])}}">Members
                            <?php if($countallmessages['member'] > 0) { ?><span class="badge badge-info">{{$countallmessages['member']}}</span><?php } ?>
                        </a>
                    </li>
                    <li class="msginbox">
                        <a href="{{route(config('project.admin_route').'messagelist.inbox',['user_type'=>'other'])}}">Others
                            <?php if($countallmessages['other'] > 0) { ?><span class="badge badge-info">{{$countallmessages['other']}}</span><?php } ?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="msginbox">
                <a href="{{route(config('project.admin_route').'messagelist.sent')}}" data-type="sent" data-title="Sent">
                    <span class="title">Sent</span>
                </a>
            </li> 
            <li class="msginbox">
                <a href="{{route(config('project.admin_route').'messagelist.draft')}}" data-type="draft" data-title="Draft">Draft
                    <?php if($countallmessages['draft'] > 0) { ?><span class="badge badge-info">{{$countallmessages['draft']}}</span><?php } ?>
                </a>
            </li> 
            <li class="msginbox">
                <a href="{{route(config('project.admin_route').'messagelist.trash')}}" class="sbold uppercase" data-title="Trash"> Trash
                    <?php if($countallmessages['trash'] > 0) { ?><span class="badge badge-info">{{$countallmessages['trash']}}</span><?php } ?>
                </a>
            </li>
            <li class="msginbox">
                <!--<a id="create_folder_id" class="btn sbold" data-type="Create Folder" data-title="Create Folder">Create Folder</a> -->
                <a id="create_folder_id"  class="btn blue btn-outline sbold" data-toggle="modal" href="#small"> Create Folder </a>
            </li>                         
            
            @foreach ( $allfolders as $id=>$folder_details )            
            <li class="msginbox">
                <a href="{{route(config('project.admin_route').'messagelist.folder',['name'=>$folder_details['folder_name']])}}" data-type="folder" data-title="folder">{{ $folder_details['folder_name'] }}               
                <?php if($folder_details['folder_cnt'] > 0) { ?><span class="badge badge-info">{{$folder_details['folder_cnt']}}</span><?php } ?></a> 
            </li> 
            @endforeach                    
        </ul>
</div>

@push('scripts')
<script>
    $('.help-block').hide();
    inboxsidebarpath=location.protocol + '//' + location.host + location.pathname;    
    $('.msginbox').each(function() {
            if($(this).find('a[href="'+inboxsidebarpath+'"]').attr('href')){
                $(this).addClass('active');
            }                
    });   
            
    $( "#folderform" ).submit(function( event ) {
        event.preventDefault();
        var name = $( this ).find( "input[name='folder_name']" ).val();      
        if(name != null && name != '')
        {
            $('.help-block').hide();
            $( this ).find( "input[name='folder_name']" ).css('border-color','#555');
            $.ajax({
                    url: '{{URL("admin/addfolder")}}',                        
                    dataType: 'json',
                    data: { submit: true ,folder_name : name },
                    success: function (r) {
                        if (r.status == "success") {
                            window.location.href = r.redirectUrl;
                        } else if (r.status == "error") {
                            toastr.error(r.msg, "{{ trans('message.failure') }}", {timeOut: 10000});                                
                        }
                    },
                    error: function (data) {
                        var resp = $.parseJSON( data.responseText );
                        if (data.status === 422) {
                            toastr.error(resp.folder_name);
                        }
                        return false;
                    }
                });
            return false;
        }
        else
        {
            $( this ).find( "input[name='folder_name']" ).css('border-color','#e73d4a');
            $('.help-block').show();
            $('.help-block').css('color','#e73d4a');
            return false;
        }
      
    });
    
    

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });         
   
   $('#example-select-all').on('click', function(){
        $('input', oTable.cells().nodes()).prop('checked',this.checked);
   });
      
   $('.mt-checkbox-th').removeClass('sorting_asc');
   function getsearch(text){
        oTable.search( text ).draw();
        $('.mt-checkbox-th').removeClass('sorting_asc');
   }
    
</script>
@endpush
