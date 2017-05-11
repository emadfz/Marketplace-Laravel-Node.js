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
    <div class="form-group required {!! $errors->has('label_name') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.file_labels.title"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('label_name', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('label_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('label_description') ? 'has-error' : '' !!}">
        {!! Form::label('label_description', trans("form.file_labels.description"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::textarea('label_description', null, ['class'=>'form-control']) !!}
            {!! $errors->first('label_description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>


</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(isset($model) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'labels.index')}}">Cancel</a>
        </div>
    </div>
</div>

<!-- END FORM-->