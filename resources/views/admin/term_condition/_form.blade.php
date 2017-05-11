<!-- BEGIN FORM-->
<div class="form-body">
    <div class="form-group required {!! $errors->has('topic_name') ? 'has-error' : '' !!}">
        {!! Form::label('topic_name', trans("form.terms_and_conditions.tc_topic_name"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::text('topic_name', null, ['class'=>'form-control']) !!}
            {!! $errors->first('topic_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    
    <div class="form-group required {!! $errors->has('terms_conditions') ? 'has-error' : '' !!}">
        {!! Form::label('terms_conditions', trans("form.terms_and_conditions.terms_conditions"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::textarea('terms_conditions', null, ['class'=>'ckeditor form-control', 'rows' => '10']) !!}
            {!! $errors->first('terms_conditions', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    
    <div class="form-group {!! $errors->has('meta_title') ? 'has-error' : '' !!}">
        {!! Form::label('meta_title', trans("form.meta_title"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::text('meta_title', null, ['class'=>'form-control maxlength-handler', 'maxlength'=>'50']) !!}
            {!! $errors->first('meta_title', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    
    <div class="form-group {!! $errors->has('meta_keywords') ? 'has-error' : '' !!}">
        {!! Form::label('meta_keywords', trans("form.meta_keywords"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::textarea('meta_keywords', null, ['class'=>'form-control maxlength-handler', 'rows' => 2, 'maxlength'=>'200']) !!}
            {!! $errors->first('meta_keywords', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    
    <div class="form-group {!! $errors->has('meta_description') ? 'has-error' : '' !!}">
        {!! Form::label('meta_description', trans("form.meta_description"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::text('meta_description', null, ['class'=>'form-control maxlength-handler', 'maxlength'=>'160']) !!}
            {!! $errors->first('meta_description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    
    <div class="form-group required {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('status', trans("form.status"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-2">
            {!! Form::select('status', $status, null, ['class'=>'form-control']) !!}
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-2 col-md-10">
            {!! Form::button('Preview',['class'=>'btn btn-primary','id'=>'preview','data-url'=>route('content_pages_preview')]) !!}
            {!! Form::submit(isset($model) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'terms_and_conditions.index')}}">{{ trans("form.cancel") }}</a>
        </div>
    </div>
</div>
<!-- END FORM-->
<div class="modal fade" id="preview_content_page" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" style="width:1000px!important;height:1000px!important;overflow:auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">       
               
                
            </div>
            <div class="modal-footer">                
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>
<script>
    $(".maxlength-handler").maxlength({limitReachedClass:"label label-danger",alwaysShow:!0,threshold:5});


$('#preview').click(function(){
    $('#preview_content_page').modal('show');
    $('#preview_content_page .modal-title').html($('input[name="topic_name"]').val());
    $('#preview_content_page .modal-body').load($(this).data('url'));    
    setTimeout(
            function(){
                $('#preview_continer').html(CKEDITOR.instances['terms_conditions'].getData());
            },1000
        );            
});

$('#preview_content_page').on('hidden.bs.modal', function () {    
  $('#preview_content_page .modal-body').html('');
});
</script>

@endpush