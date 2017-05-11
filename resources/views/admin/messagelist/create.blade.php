@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('compose_message') !!}
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
                            {!! Form::open(['route' => 'admin.messagelist.store', 'class' => 'inbox-compose form-horizontal ajax','id'=>'sendMessageForm', 'files' => true])!!}
                                @include('admin.messagelist._form')
                                
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

                                        <td>
                                            <p class="name">{%=file.name%}</p>
                                            <strong class="error text-danger"></strong>
                                        </td>
                                        <td>
                                            <p class="size">Processing...</p>
                                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                                        </td>
                                        <td>
                                            {% if (!i && !o.options.autoUpload) { %}
                                                <div class="start" ></div>
                                            {% } %}
                                            {% if (!i) { %}
                                                <button class="btn btn-warning cancel">Cancel</button>
                                            {% } %}
                                        </td>
                                    </tr>
                                {% } %}
                                </script>
                                <!-- The template to display files available for download -->
                                <script id="template-download" type="text/x-tmpl">
                                {% for (var i=0, file; file=o.files[i]; i++) { %}
                                    <tr class="template-download fade">        
                                        <td>
                                            <p class="name">
                                                {% if (file.url) { %}
                                                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                                                {% } else { %}
                                                    <span>{%=file.name%}</span>
                                                {% } %}
                                            </p>
                                            {% if (file.error) { %}
                                                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                                            {% } %}
                                        </td>

                                        <td>                                            
                                            {% if (file.deleteUrl) { %}
                                                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}&unique_code=11" {% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                                    <i class="glyphicon glyphicon-trash"></i>                   
                                                </button>

                                            {% } else { %}
                                                <button class="btn btn-warning cancel">
                                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                                </button>
                                            {% } %}
                                        </td>
                                    </tr>
                                {% } %}
                                </script> 
                                
                            {!! Form::close() !!}                
                        </div>                   
                    </div> 
                </div>
                
                
            </div>
        </div>
    </div>    
</div>
</div>
@endsection