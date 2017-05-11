<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
    <i class="icon-envelope-open"></i>
    <span class="badge badge-danger"> {{ count($messagelists)}} </span>
</a>
<ul class="dropdown-menu">
    <li class="external">
        <h3>You have
            <span class="bold">{{ count($messagelists)}} New</span> Messages</h3>
        <a href="javascript:;">view all</a>
    </li>
    <li>
        <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">            
            @foreach($messagelists as $messagelist)            
            <li>
                <a href="{{route(config('project.admin_route').'messagelist.view_msg',['folder_name'=>$messagelist->folder_name,'message_id'=>$messagelist->id])}}">
                    <span class="photo"><img alt="" class="img-circle" src="{{asset('assets/admin/layouts/layout4/img/avatar6.jpg')}}" /></span>
                    <span class="subject">
                        <span class="from"> {{$messagelist->name}} </span>
                        <span class="time">{!! Carbon\Carbon::parse($messagelist->created_at)->diffForHumans(); !!} </span>
                    </span>
                    <span class="message"> {{$messagelist->msg_subject}}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </li>
</ul>