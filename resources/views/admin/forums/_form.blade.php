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
   
   
   
   
<div class="form-body">
    <div class="form-group {!! $errors->has('topic_name') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.forums.select_department"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::select('topic_department_id', ($department['all_departmentsnames']),null,['class' => 'form-control select2']) !!}
        </div>
    </div>

</div>
   
<div class="form-body">
    <div class="form-group {!! $errors->has('topic_name') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.forums.topic_name"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('topic_name', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('topic_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>


<div class="form-body">
    <div class="form-group ckeditor-error {!! $errors->has('topic_description') ? 'has-error' : '' !!}">
            {!! Form::label('topic_description', trans("form.forums.topic_description"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-6">
            {!! Form::textarea('topic_description', null, ['class'=>'ckeditor','cols'=>'40','rows' => '5']) !!}
            {!! $errors->first('topic_description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>


<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(isset($model) ? trans("form.save") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'forums.index')}}">Cancel</a>
        </div>
    </div>
</div>

@push('scripts')

<script src="http://cdn.ckeditor.com/4.5.3/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace("topic_description", {
        uiColor: "#F5F5F5",
        toolbar: "standard",
        toolbarLocation: 'bottom',
        scayt_autoStartup: false,
        enterMode: CKEDITOR.ENTER_BR,
        resize_enabled: false,
        disableNativeSpellChecker: false,
        htmlEncodeOutput: false,
        height: 120,
        removePlugins: 'elementspath',
        editingBlock: false,
        toolbarGroups:
                [
                    {"name": "basicstyles", "groups": ["basicstyles", "cleanup"]},
                    {"name": "links", "groups": ["links"]},
                    {"name": "document", "groups": ["mode"]},

                ],
        // Remove the redundant buttons from toolbar groups defined above.
        removeButtons: 'Strike,Subscript,Source,RemoveFormat,Superscript,Anchor,Styles,Specialchar', toolbarLocation : 'bottom',
    });
</script>

@endpush

<!-- END FORM-->