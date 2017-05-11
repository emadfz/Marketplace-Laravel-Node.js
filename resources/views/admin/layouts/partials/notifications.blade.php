
<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
    <i class="icon-bell"></i>
    <span class="badge badge-success"> {{ @$notifications->count() }}</span>
</a>
<ul class="dropdown-menu">
    <li class="external">
        <h3>
            <span class="bold">{{ @$notifications->count() }} pending</span> notifications</h3>
        <a href="{{route("admin.home.notifications")}}">view all</a>
    </li>
    <li>
        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">                                                       
            @foreach($notifications as $notification)
            <li>
                <a href="{{$notification->url}}" class="alert-notification" data-id="{{encrypt($notification->id)}}">
                    <span class="time">                                                    
                        {!! Carbon\Carbon::parse($notification->created_at)->diffForHumans(); !!}
                    </span>
                    <span class="details">
                        <span class="label label-sm label-icon label-{{$notification->icon}}">
                            <i class="fa fa-plus"></i>
                        </span>{{$notification->text}}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </li>
</ul>

