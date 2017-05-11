@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('view_message') !!}
<?php if(!empty($res['folder_name']) && $res['folder_name'] != 'sent') { ?>
<input type="hidden" id="reply_msg_url" value="{{route(config('project.admin_route').'messagelist.reply_msg',[ 'reply_message_id'=> $view_msg->id ,'folder_name' => $res['folder_name'] ])}}" >
<?php } ?>
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
                    <span class="caption-subject bold"><?php echo trans("message.messagelist.msg_detail") ?></span>
                </div>
            </div>
            <div class="inbox-header inbox-view-header">
                <h1 class="pull-left"><?php echo $view_msg->msg_subject;?> 
                    <?php
                    if(!empty($res['folder_name']) && $res['folder_name'] != 'sent' ){
                        if( $res['folder_name'] != 'Inbox' ) { ?>
                    <a href="{{route(config('project.admin_route').'messagelist.folder',['name'=> $res['folder_name']])}}"><?php echo $res['folder_name']; ?> </a>
                    <?php } else {
                        ?>
                    <a href="{{route(config('project.admin_route').'messagelist.index')}}"><?php echo $res['folder_name']; ?> </a>
                        <?php } } ?>
                </h1>
                <div class="pull-right">
                    <a href="javascript:window.print()" class="btn btn-icon-only dark btn-outline">
                        <i class="fa fa-print"></i>
                    </a>
                </div>
            </div>
            <div class="inbox-view-info">
                <div class="row">
                    <div class="col-md-7">
                        <!--<img src="../assets/pages/media/users/avatar1.jpg" class="inbox-author"> -->
                        <span><?php echo $view_msg->name ;?></span> to
                        <span class="sbold"> me </span> on <?php echo $view_msg->created_at;?>
                    </div>
                    <?php if(!empty($res['folder_name']) && $res['folder_name'] != 'sent' ){ ?>
                    <div class="col-md-5 inbox-info-btn">
                        <div class="btn-group">
                            <button data-messageid="23" class="btn green reply-btn">
                                <i class="fa fa-reply"></i> Reply                    
                            </button>                
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="inbox-view">
                <?php echo $view_msg->msg_content ;?>
            </div>
            <hr>
            <!-- <div class="inbox-attached">
                <div class="margin-bottom-15">
                    <span>attachments — </span>
                    <a href="javascript:;">Download all attachments </a>
                    <a href="javascript:;">View all images </a>
                </div>
                <div class="margin-bottom-25">
                    <img src="../assets/pages/media/gallery/image4.jpg">
                    <div>
                        <strong>image4.jpg</strong>
                        <span>173K </span>
                        <a href="javascript:;">View </a>
                        <a href="javascript:;">Download </a>
                    </div>
                    <div class="margin-bottom-25">
                        <img src="../assets/pages/media/gallery/image3.jpg">
                        <div>
                            <strong>IMAG0705.jpg</strong>
                            <span>14K </span>
                            <a href="javascript:;">View </a>
                            <a href="javascript:;">Download </a>
                        </div>
                    </div>
                    <div class="margin-bottom-25">
                        <img src="../assets/pages/media/gallery/image5.jpg">
                        <div>
                            <strong>test.jpg</strong>
                            <span>132K </span>
                            <a href="javascript:;">View </a>
                            <a href="javascript:;">Download </a>
                        </div>
                    </div>
                    </div>
                </div> -->
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
@endpush