<div class="portlet-title" >
                <div class="caption font-dark" style="width: 100% !important;">
                    <i class="icon-settings font-dark"></i>
                    
                        <span class="caption-subject bold"><?php echo trans("message.messagelist.msg_detail") ?></span>
                                        
                </div>   
</div>
<div class="inbox-header inbox-view-header">
    <h1 class="pull-left"><?php echo $view_msg->msg_subject;?>        
        <a href="javascript:;"><?php echo $res['folder_name']; ?> </a>
    </h1>
    <div class="pull-right">
        <a href="javascript:;" class="btn btn-icon-only dark btn-outline">
            <i class="fa fa-print"></i>
        </a>
    </div>
</div>
<div class="inbox-view-info">
    <div class="row">
        <div class="col-md-7">
            <!--<img src="../assets/pages/media/users/avatar1.jpg" class="inbox-author"> -->
            <span class="sbold"><?php echo $view_msg->name ;?> </span>
            <span>&#60;<?php echo $view_msg->email;?>&#62; </span> to
            <span class="sbold"> me </span> on <?php echo $view_msg->created_at;?> </div>
        <div class="col-md-5 inbox-info-btn">
            <div class="btn-group">
                <button data-messageid="23" class="btn green reply-btn">
                    <i class="fa fa-reply"></i> Reply
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="javascript:;" data-messageid="23" class="reply-btn">
                            <i class="fa fa-reply"></i> Reply </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-arrow-right reply-btn"></i> Forward </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-print"></i> Print </a>
                    </li>
                    <li class="divider"> </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-ban"></i> Spam </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-trash-o"></i> Delete </a>
                    </li>
                    <li>
            </div>
        </div>
    </div>
</div>
<div class="inbox-view">
    <?php echo $view_msg->msg_content ;?>
</div>
<hr>
<div class="inbox-attached">
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