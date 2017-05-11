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
         {!! Form::submit(trans("message.messagelist.btn_send"), ['class'=>'btn btn-primary green']) !!}
         <a class="btn default" href="{{route(config('project.admin_route').'messagelist.index')}}">{{trans("message.messagelist.btn_discard")}}</a>
         {!! Form::submit(trans("message.messagelist.btn_draft"), ['class'=>'btn default']) !!}
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

    <div class="inbox-form-group mail-to required {!! $errors->has('msg_sentTo_id') ? 'has-error' : '' !!}">
        {!! Form::label('msg_sentTo_id', trans("message.messagelist.msg_sentto"), ['class' => 'control-label']) !!}                   
        <div id='user_email' class="controls controls-to">
            {{ Form::select('user_emails[]', array('0'=>'select'),NULL, ['class'=>'form-control select2','multiple'])}}
        </div>        
    </div>

    <div class="inbox-form-group required {!! $errors->has('title') ? 'has-error' : '' !!}">
        {!! Form::label('msg_subject', trans("message.messagelist.msg_subject"), ['class' => 'control-label']) !!}    
        <div class="controls">
            {!! Form::text('msg_subject', NULL , ['class'=>'form-control' ]) !!}
            {!! $errors->first('msg_subject', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="inbox-form-group required {!! $errors->has('price') ? 'has-error' : '' !!}">                           
        {!! Form::textarea('msg_content', NULL , ['class'=>'inbox-editor inbox-wysihtml5','id'=>'summernote_1','rows'=>'15']) !!}            
        {!! $errors->first('msg_content', '<span class="help-block">:message</span>') !!}
    </div>            
    
    <div class="inbox-compose-btn">
        <input type="submit" name="save" value="{{trans("message.messagelist.btn_send")}}" class="btn btn-primary green">
        <a class="btn default" href="{{route(config('project.admin_route').'messagelist.index')}}">{{trans("message.messagelist.btn_discard")}}</a>
        <input type="submit" name="save" value="{{trans("message.messagelist.btn_draft")}}" class="btn default">                           
    </div>
</div>
<!-- END FORM-->  
<input type="hidden" value="<?php echo url('/assets/admin/global/plugins/jquery-file-upload/server/php/').'/';?>" id="document_path" >
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
                    data: function (params) {
                        console.log(params);
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
        $('#fileupload1').fileupload({        
            url: $('#document_path').val()
        });

        $('#fileupload1').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#document_path').val(),
            dataType: 'json',
            context: $('#fileupload1')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
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
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<form class="inbox-compose form-horizontal" id="fileupload" action="#" method="POST" enctype="multipart/form-data">
    <div class="inbox-compose-btn">
        <button class="btn green">
            <i class="fa fa-check"></i>Send</button>
        <button class="btn default">Discard</button>
        <button class="btn default">Draft</button>
    </div>
    <div class="inbox-form-group mail-to">
        <label class="control-label">To:</label>
        <div class="controls controls-to">
            <input type="text" class="form-control" name="to" value="fiona.stone@arthouse.com, lisa.wong@pixel.com, jhon.doe@gmail.com">
            <span class="inbox-cc-bcc">
                <span class="inbox-cc " style="display:none"> Cc </span>
                <span class="inbox-bcc"> Bcc </span>
            </span>
        </div>
    </div>
    <div class="inbox-form-group input-cc">
        <a href="javascript:;" class="close"> </a>
        <label class="control-label">Cc:</label>
        <div class="controls controls-cc">
            <input type="text" name="cc" class="form-control" value="jhon.doe@gmail.com, kevin.larsen@gmail.com"> </div>
    </div>
    <div class="inbox-form-group input-bcc display-hide">
        <a href="javascript:;" class="close"> </a>
        <label class="control-label">Bcc:</label>
        <div class="controls controls-bcc">
            <input type="text" name="bcc" class="form-control"> </div>
    </div>
    <div class="inbox-form-group">
        <label class="control-label">Subject:</label>
        <div class="controls">
            <input type="text" class="form-control" name="subject" value="Urgent - Financial Report for May, 2013"> </div>
    </div>
    <div class="inbox-form-group">
        <div class="controls-row">
            <textarea class="inbox-editor inbox-wysihtml5 form-control" name="message" rows="12"></textarea>
            <!--blockquote content for reply message, the inner html of reply_email_content_body element will be appended into wysiwyg body. Please refer Inbox.js loadReply() function. -->
            <div id="reply_email_content_body" class="hide">
                <input type="text">
                <br>
                <br>
                <blockquote> Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                    <br>
                    <br> Consectetuer adipiscing elit, sed diam nonummy nibh euismod exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                    <br>
                    <br> All the best,
                    <br> Lisa Nilson, CEO, Pixel Inc. </blockquote>
            </div>
        </div>
    </div>
    <div class="inbox-compose-attachment">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <span class="btn green btn-outline  fileinput-button">
            <i class="fa fa-plus"></i>
            <span> Add files... </span>
            <input type="file" name="files[]" multiple> </span>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped margin-top-10">
            <tbody class="files"> </tbody>
        </table>
    </div>
    <script id="template-upload" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td class="name" width="30%">
                <span>{%=file.name%}</span>
            </td>
            <td class="size" width="40%">
                <span>{%=o.formatFileSize(file.size)%}</span>
            </td> {% if (file.error) { %}
            <td class="error" width="20%" colspan="2">
                <span class="label label-danger">Error</span> {%=file.error%}</td> {% } else if (o.files.valid && !i) { %}
            <td>
                <p class="size">{%=o.formatFileSize(file.size)%}</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
            </td> {% } else { %}
            <td colspan="2"></td> {% } %}
            <td class="cancel" width="10%" align="right">{% if (!i) { %}
                <button class="btn btn-sm red cancel">
                    <i class="fa fa-ban"></i>
                    <span>Cancel</span>
                </button> {% } %}</td>
        </tr> {% } %} </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade"> {% if (file.error) { %}
            <td class="name" width="30%">
                <span>{%=file.name%}</span>
            </td>
            <td class="size" width="40%">
                <span>{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td class="error" width="30%" colspan="2">
                <span class="label label-danger">Error</span> {%=file.error%}</td> {% } else { %}
            <td class="name" width="30%">
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size" width="40%">
                <span>{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td colspan="2"></td> {% } %}
            <td class="delete" width="10%" align="right">
                <button class="btn default btn-sm" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}" {% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}' {% } %}>
                    <i class="fa fa-times"></i>
                </button>
            </td>
        </tr> {% } %} </script>
    <div class="inbox-compose-btn">
        <button class="btn green">
            <i class="fa fa-check"></i>Send</button>
        <button class="btn default">Discard</button>
        <button class="btn default">Draft</button>
    </div>
</form>