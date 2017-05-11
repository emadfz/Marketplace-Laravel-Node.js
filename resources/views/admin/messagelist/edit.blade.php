@extends('admin.layouts.app')
@section('content')
<div class="inbox">
<div class="row">
    <div class="col-md-2" style="padding-right: 0px;">
         @include('admin.messagelist.message_sidebar')
    </div>
    
    <div class="col-md-10">    
        <div class="portlet light bordered">            
            <div class="portlet-title" >
                <div class="caption font-dark" style="width: 100% !important;">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("message.messagelist.compose")}}</span>
                </div>
                
                <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                    <div class="inbox-body" style="padding:0px;">
                        <div class="portlet-body form">   
                            {!! Form::model($view_msg, ['route' => ['admin.messagelist.store', 'msg_replyto_messageid'=>encrypt($res['reply_message_id'])],'class' => 'inbox-compose form-horizontal ajax','id'=>'sendMessageForm', 'files' => true])!!}
                                @include('admin.messagelist._form',['model' => $view_msg])
                            {!! Form::close() !!}
                         </div>                   
                    </div> 
                </div>
                <form class="inbox-compose form-horizontal" action="admin.messagelist.create" id="fileupload1" action="#" method="POST" enctype="multipart/form-data">
                        <div class="inbox-compose-attachment">
                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                            <span class="btn green btn-outline fileinput-button">
                                <i class="fa fa-plus"></i>
                                <span> Add files... </span>
                                <input type="text" name="userid" value="{{ \Auth::guard('admin')->user()->id }}" id="userid">
                                <input type="file" name="files[]" multiple> </span>
                            <!-- The table listing the files available for upload/download -->
                            <table role="presentation" class="table table-striped margin-top-10">
                                <tbody class="files"> </tbody>
                            </table>
                        </div>
                        <script id="template-upload" type="text/x-tmpl"> 
                            {% for (var i=0, file; file=o.files[i]; i++) { %}
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
                            </tr> {% } %} 
                        </script>
                        <!-- The template to display files available for download -->
                        <script id="template-download" type="text/x-tmpl"> 
                            {% for (var i=0, file; file=o.files[i]; i++) { %}
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
                                    <button class="btn default btn-sm" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}&userid={{ \Auth::guard('admin')->user()->id }}" {% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}' {% } %}>
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr> {% } %}
                        </script>
                        </form>
             
            </div>
        </div>
    </div>    
</div>
</div>
@endsection
