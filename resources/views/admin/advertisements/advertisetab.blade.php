{{ !$lastSegment=collect(request()->segments())->last()}}
<div class="tabbable tabbable-tabdrop">                                
    <ul class="nav nav-tabs">                                  
        <li class="adv_menu {{$lastSegment=='advertisements'?'active':''}}"><a href="{{route(config('project.admin_route').'advertisements.index')}}">All Advertisement</a></li>
        <li class="adv_menu {{$lastSegment=='pendingadv'?'active':''}}"><a href="{{route(config('project.admin_route').'adver.pendingadv')}}">Pending Requests</a></li>
        <li class="adv_menu {{$lastSegment=='settingsadv'?'active':''}}"><a href="{{route(config('project.admin_route').'adver.settingsadv')}}">Settings</a></li>
        <li class="adv_menu"><a href="{{route(config('project.admin_route').'advertisements.create')}}">Post a New Advertisement</a></li>
    </ul>
</div>
