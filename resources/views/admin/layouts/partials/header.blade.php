<?php header('Access-Control-Allow-Origin: *');  

 
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    
?>
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{route(config('project.admin_route').'home.index')}}">
                <img src="{{asset('assets/admin/layouts/layout4/img/logo-light.png')}}" alt="logo" class="logo-default" /> </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->

        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN HEADER SEARCH BOX -->
            <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
<!--            <form class="search-form" action="" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control input-sm" placeholder="Search..." name="query">
                    <span class="input-group-btn">
                        <a href="javascript:;" class="btn submit">
                            <i class="icon-magnifier"></i>
                        </a>
                    </span>
                </div>
            </form>-->
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="separator hide"> </li>
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                        
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->
                    <li class="separator hide"> </li>
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-envelope-open"></i>
                            <span class="badge badge-danger"> 0 </span>
                        </a>

                    </li>
                    <!-- END INBOX DROPDOWN -->
                    <li class="separator hide"> </li>
                    <!-- BEGIN TODO DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                    <!-- END TODO DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span class="username username-hide-on-mobile"> 
                                @if(auth()->guard('admin')->user())
                                {{ auth()->guard('admin')->user()->first_name}}&nbsp;{{ auth()->guard('admin')->user()->last_name}}
                                @endif
                            </span>
                            <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                            <img alt="" class="img-circle" src="{{asset('assets/admin/layouts/layout4/img/avatar9.jpg')}}" /> </a>
                        <ul class="dropdown-menu dropdown-menu-default">
<!--                            <li>
                                <a href="javascript:;">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-calendar"></i> My Calendar </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-envelope-open"></i> My Inbox
                                    <span class="badge badge-danger"> 3 </span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-rocket"></i> My Tasks
                                    <span class="badge badge-success"> 7 </span>
                                </a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-lock"></i> Lock Screen </a>
                            </li>-->
                            <li>
                                <a href="{{ route('adminLogout') }}">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
<!--                    <li class="dropdown dropdown-extended quick-sidebar-toggler">
                        <span class="sr-only">Toggle Quick Sidebar</span>
                        <i class="icon-logout"></i>
                    </li>-->
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>

<!-- END HEADER -->
@push('scripts')
<script>

//check for toggle menu in header
<?php if (\Session::has('sidebar')) {
            if(\Session::get('sidebar') == 'close'){ ?>
                $(document.body).addClass('page-sidebar-closed');
                $(".page-sidebar ul:first").addClass("page-sidebar-menu-closed");
            <?php } ?>
<?php } ?>
//end
function getNotifications(){
        $.ajax({
            url: '<?php echo URL('/admin/getnotifications'); ?>',
            type: 'post',
            dataType: 'json',
            data: { submit: true},
            headers: {
                'X-CSRF-Token': "<?php echo csrf_token(); ?>"                
            },
            success: function (r) {                                
                if (r.status == "success") {
                    $('#header_notification_bar').html(r.html);
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
    }
  
     
        getNotifications();
        
        var socket = io( 'http://10.2.2.59:3000' );                
       
        socket.on("event-notifications:App\\Events\\NotificationEvent", function(message){
            getNotifications();            
        });        

        socket.on("message-<?php echo \Auth::guard('admin')->user()->id; ?>:App\\Events\\messageEvent", function(message){         
           
           var settings = {
                            theme: 'smoke',
                            sticky: false,
                            horizontalEdge: 'bottom',
                            verticalEdge: 'right'
                        },
                        $button = $(this);                                                
                        settings.heading = 'New Message';
                        settings.life = 5000;                        

                        $.notific8('zindex', 11500);
                        $.notific8($.trim("From : "+message.user_email+'<br>'+message.msg), settings);
                        
                        $button.attr('disabled', 'disabled');
                        
                        setTimeout(function() {
                            $button.removeAttr('disabled');
                        }, 1000);
                        
           getMessages();           
        }); 
        
       
$(document).ready(function(){
    $(document).on('click','.alert-notification',function(e){
        e.preventDefault();
        self=$(this);
        $.ajax({
            url: '<?php echo URL('/admin/readnotifications'); ?>',
            type: 'post',
            dataType: 'json',
            async: true,
            data: { id : $(this).data('id')},
            success: function (r) {                                
                if (r.status == "success") {                     
                    window.location.assign(self.attr('href'));
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

    //click for toggle menu in header
    $(document).on('click','.menu-toggler',function(e){
        e.preventDefault();
        var state = '';
        if($('body').hasClass('page-sidebar-closed')) {
            state = 'close';
        } else {
            state = 'open';
        }
        $.ajax({
            url: '<?php echo route('setSidebarOpenClose'); ?>'+'?state='+state,
            type: 'get',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': "<?php echo csrf_token(); ?>"
            },
            success: function (r) {
                if (r.status == "success"){

                } else if (r.status == "error") {
                    toastr.error(r.msg, "{{ trans('message.failure') }}", {timeOut: 1000});
                }
            },
            error: function (data) {
                if (data.status === 422) {
                    toastr.error("{{ trans('message.failure') }}");
                }
            }
        });
    });
    //end

});    

function getMessages(){
        $.ajax({
            url: '<?php echo URL('admin/messagelist/getMessages'); ?>',
            type: 'post',
            dataType: 'json',
            data: { submit: true},
            headers: {
                'X-CSRF-Token': "<?php echo csrf_token(); ?>"                
            },
            success: function (r) {                                
                if (r.status == "success"){                    
                    $('#header_inbox_bar').html(r.html);
                } else if (r.status == "error") {
                    toastr.error(r.msg, "{{ trans('message.failure') }}", {timeOut: 1000});                    
                }
            },
            error: function (data) {
                if (data.status === 422) {
                    toastr.error("{{ trans('message.failure') }}");
                }
            }
        });
    }
    getMessages();
</script>
@endpush