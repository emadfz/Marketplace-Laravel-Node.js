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
    <div class="form-group {!! $errors->has('user_type') ? 'has-error' : '' !!}">
        {!! Form::label('user_type', trans("message.messagelist.user_type"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-8">
            <div class="col-md-4">
                {{ Form::radio('user_type', 'employee', NULL , ['id'=>'emp', 'class'=>'form-control','style'=>'width:6%; float : left;'])}}
                {!! Form::label('emp', trans("message.messagelist.type_employee"), ['class' => 'col-md-3 control-label']) !!}    
            </div>
            <div class="col-md-4">
                {{ Form::radio('user_type', 'member', NULL , [ 'id'=>'member', 'class'=>'form-control','style'=>'width:6%; float : left;'])}}
                {!! Form::label('member', trans("message.messagelist.type_member"), ['class' => 'col-md-3 control-label']) !!}    
            </div>
            <div class="col-md-4">
                {{ Form::radio('user_type', 'other_users', NULL , [ 'id'=>'other_users', 'class'=>'form-control','style'=>'width:6%;float : left;'])}}
                {!! Form::label('other_users', trans("message.messagelist.type_other"), ['class' => 'col-md-3 control-label']) !!}    
            </div>
            {!! $errors->first('user_type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('msg_sentTo_id') ? 'has-error' : '' !!}">
        {!! Form::label('msg_sentTo_id', trans("message.messagelist.msg_sentto"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-8">                         
            {{ Form::text('to_emails', '', [ 'placeholder' => 'Select User','class'=>'user_email form-control'])}}            
            {{ Form::hidden('employee_emails', '', ['id' => 'employee_email', 'class'=>'form-control'])}}
            {{ Form::hidden('member_emails', '', ['id' => 'member_email', 'class'=>'form-control'])}}
            {{ Form::hidden('other_emails', '', ['id' => 'other_email', 'class'=>'form-control'])}}
            {!! $errors->first('msg_sentTo_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('title') ? 'has-error' : '' !!}">
        {!! Form::label('msg_subject', trans("message.messagelist.msg_subject"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-8">
            {!! Form::text('msg_subject', NULL , ['class'=>'form-control' ]) !!}
            {!! $errors->first('msg_subject', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    
    <div class="form-group required {!! $errors->has('price') ? 'has-error' : '' !!}">
        {!! Form::label('msg_content', trans("message.messagelist.msg_content"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-8">
            <div style="width: 100% !important;">
            {!! Form::textarea('msg_content', NULL , ['class'=>'form-control','id'=>'summernote_1']) !!}
            </div>
            {!! $errors->first('msg_content', '<span class="help-block">:message</span>') !!}
        </div>
    </div>         
</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">            
            {!! Form::submit(trans("message.messagelist.btn_save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'messagelist.index')}}">{{trans("message.messagelist.btn_cancel")}}</a>
        </div>
    </div>
</div>
<!-- END FORM-->
@push('styles') 
<link href="{{ asset('assets/admin/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/tag-it/css/jquery.tagit.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/tag-it/css/tagit.ui-zendesk.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/jquery-ui/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/jquery-ui/jquery-ui.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/tag-it/js/tag-it.js') }}" type="text/javascript"></script>

<script>
        var focusedTag   = null;
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) {
            return split( term ).pop();
        }
        
        function removeByValue(arr, val) {
           
            for(var i=0; i < arr.length; i++) {                
                if($.trim(arr[i]) == $.trim(val)) {                    
                    arr.splice(i, 1);                    
                }                
            }
            
            return arr;
        }
        
        $( ".user_email" ).tagit({            
            autocomplete : {
                minLength: 1,
                source: function( request, response ) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON("{{URL('admin/autocomplete')}}", { keyword :  extractLast(request.term )
                        , user_type : $('input[name=user_type]:checked', '#sendMessageForm').val() },function() {
                        $(arguments[0]).each(function(i, el) {
                          var obj = {};
                          obj[el.id] = el;                      
                          $(this).data(obj);
                        });
                        response.apply(null, arguments);
                      });
                },
                focus: function(event, ui) {
                    // prevent value inserted on focus
                    focusedTag = ui.item;
                },
            },                                     
            afterTagAdded: function (event, ui) {                
                var user_type = $('input[name=user_type]:checked', '#sendMessageForm').val();
                if(user_type == 'employee')
                {
                    $('#employee_email').val(function(i,val) { 
                        return val + (val ? ',' : '') + $.trim(ui.tagLabel);
                   });
                }
                else if(user_type == 'member')
                {
                    $('#member_email').val(function(i,val) { 
                        return val + (val ? ',' : '') + $.trim(ui.tagLabel);
                   });
                }
                else if(user_type == 'other_users')
                {
                    $('#other_email').val(function(i,val) { 
                        return val + (val ? ',' : '') + $.trim(ui.tagLabel);
                   });
                }
                if (focusedTag !== null &&
                        focusedTag.label === ui.tagLabel) {              
                }
                focusedTag   = null;
            },
            beforeTagRemoved: function(event, ui) {
                
                var employee_email_array = $('#employee_email').attr('value').split(',');
                employee_email_array = removeByValue(employee_email_array,ui.tagLabel);                
                $('#employee_email').attr('value',employee_email_array.toString());
                
                var member_email_array = $('#member_email').attr('value').split(',');
                member_email_array = removeByValue(member_email_array,ui.tagLabel);
                $('#member_email').attr('value',member_email_array.toString());
                
                var other_email_array = $('#other_email').attr('value').split(',');
                other_email_array = removeByValue(other_email_array,ui.tagLabel);
                $('#other_email').attr('value',other_email_array.toString());
                
            },
            allowSpaces: true        
    });
    
</script>    
@endpush