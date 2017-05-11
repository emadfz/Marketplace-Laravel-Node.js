{{--@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif--}}
<!-- BEGIN FORM-->
<div  class="form-body">
    <div class="inbox-compose-btn">
            <input type="submit" name="save" id="send" value="{{trans("message.messagelist.btn_send")}}" class="btn btn-primary green">
            <a class="btn default" href="{{route(config('project.admin_route').'messagelist.index')}}">{{trans("message.messagelist.btn_discard")}}</a>
            <input type="submit" name="save" id="draft" value="{{trans("message.messagelist.btn_draft")}}" class="btn default">                           
    </div>
    <div class="inbox-form-group {!! $errors->has('user_type') ? 'has-error' : '' !!}">
        {!! Form::label('user_type', trans("message.messagelist.user_type"), ['class' => 'control-label']) !!}    
        <div class="controls" style="margin-left:95px;">            
            <label class="mt-radio mt-radio-outline" style="margin-top:10px;"> {{trans("message.messagelist.type_employee")}}
                {{ Form::radio('user_type', 'employee', NULL , ['id'=>'emp', 'class'=>'form-control','style'=>'width:6%; float : left;'])}}
                <span></span>
            </label>
            
            <label class="mt-radio mt-radio-outline" style="margin-top:10px;"> {{trans("message.messagelist.type_member")}}
                {{ Form::radio('user_type', 'member', NULL , [ 'id'=>'member', 'class'=>'form-control','style'=>'width:6%; float : left;'])}}
                <span></span>
            </label>
            
            <label class="mt-radio mt-radio-outline" style="margin-top:10px;"> {{trans("message.messagelist.type_other")}}
                {{ Form::radio('user_type', 'other_users', NULL , [ 'id'=>'other_users', 'class'=>'form-control','style'=>'width:6%;float : left;'])}}
                <span></span>
            </label>
            {!! $errors->first('user_type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="inbox-form-group mail-to {!! $errors->has('msg_sentTo_id') ? 'has-error' : '' !!}">
        {!! Form::label('msg_sentTo_id', trans("message.messagelist.msg_sentto"), ['class' => 'control-label']) !!}                   
        <div id='user_email' class="controls controls-to form-group">
            <?php
            if(!empty($view_msg->name)) {
              if(!empty($view_msg->user_ids)){ 
                  $test = explode(',',$view_msg->name);                  
                  ?>
                  {{ Form::hidden('user_ids', $view_msg->user_ids, ['class'=>'form-control'])}} 
              <?php } ?>            
            {{ Form::hidden('user_details', $view_msg->name, ['class'=>'form-control','id'=>'user_details'])}}
            {{ Form::select('user_emails[]', $test, 0 , ['class'=>'form-control select2','multiple'])}}
            <?php }else { ?>
            {{ Form::select('user_emails[]', array('0'=>'select'),NULL, ['class'=>'form-control select2','multiple'])}}
            <?php } ?>
        </div>
    </div>

    <div class="inbox-form-group required {!! $errors->has('title') ? 'has-error' : '' !!}">
        {!! Form::label('msg_subject', trans("message.messagelist.msg_subject"), ['class' => 'control-label']) !!}    
        <div class="controls">
            {!! Form::text('msg_subject', NULL , ['class'=>'form-control' ]) !!}
            {!! $errors->first('msg_subject', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <?php
    if(!empty($view_msg->msg_content )){
    ?>
    <div class="inbox-form-group required {!! $errors->has('price') ? 'has-error' : '' !!}">                          
        {!! Form::textarea('msg_content', '<div id="reply_email_content_body" class="hide">
            <input type="text">
            <br>
            <br>
            <blockquote> '.$view_msg->msg_content.' </blockquote></div>' , ['class'=>'inbox-editor inbox-wysihtml5','id'=>'summernote_1','rows'=>'15']) !!}            
        {!! $errors->first('msg_content', '<span class="help-block">:message</span>') !!}
    </div>   
    <?php }else { ?>
        <div class="inbox-form-group required {!! $errors->has('price') ? 'has-error' : '' !!}">                          
            {!! Form::textarea('msg_content', NULL , ['class'=>'inbox-editor inbox-wysihtml5','id'=>'summernote_1','rows'=>'15']) !!}            
            {!! $errors->first('msg_content', '<span class="help-block">:message</span>') !!}
        </div>
    <?php } ?>
    
    <div class="inbox-compose-btn">
        <input type="submit" name="save" id="send" value="{{trans("message.messagelist.btn_send")}}" class="btn btn-primary green">
        <a class="btn default" href="{{route(config('project.admin_route').'messagelist.index')}}">{{trans("message.messagelist.btn_discard")}}</a>
        <input type="submit" name="save" id="draft" value="{{trans("message.messagelist.btn_draft")}}" class="btn default">                           
    </div>
</div>
<!-- END FORM-->  
<input type="hidden" value="<?php echo url('/uploads/messages/php/').'/';?>" id="document_path" >
@push('styles')
<style>
    .select2-container--bootstrap .select2-selection{
        border: 0px !important;
    }            
    .panel-default{border-color : #fff;}
    .note-editor.note-frame{border:0px !important;}
</style>

<link href="{{ asset('assets/admin/apps/css/inbox.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/css/jquery.fileupload.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/css/jquery.fileupload-ui.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/jquery-ui/jquery-ui.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function () {
    
    $(".inbox-wysihtml5").wysihtml5({stylesheets: ["{{ asset('assets/admin/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css')}}"]});
    var $radios = $('input:radio[name=user_type]');
    if($radios.is(':checked') === false) {
        $radios.filter('[value=employee]').prop('checked', true);        
    }          
    
    $('.select2').select2({
		formatInputTooShort : function() {return false;},
		minimumInputLength : 1,
                width: '100%',
                ajax: {               
                    type: 'get',
                    url: '{{URL("admin/autocomplete")}}',
                    dataType: 'json',
                    cache: true,
                    data: function (params){
                        var query = {
                          keyword : params.term,
                          user_type: $('input[name=user_type]:checked', '#sendMessageForm').val()                          
                        }
                        // Query paramters will be ?search=[term]&page=[page]
                        return query;
                      },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function(obj) {
                                return obj;
                            })
                        };
                    },
	    }
    });
                
    $(function () {
        'use strict';
        // Initialize the jQuery File Upload widget:
        $('#sendMessageForm').fileupload({
            url: $('#document_path').val()
        });

        $('#sendMessageForm').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            // xhrFields: {withCredentials: true},
            url: $('#document_path').val(),
            dataType: 'json',
            context: $('#sendMessageForm')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });
    });
    
});
</script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>        

<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js') }}"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/jquery.fileupload.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/vendor/load-image.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/admin/apps/scripts/inbox.min.js') }}" type="text/javascript"></script>
@endpush