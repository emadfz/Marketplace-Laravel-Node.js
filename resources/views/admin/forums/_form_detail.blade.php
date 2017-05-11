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
        {!! Form::label('title', trans("form.forums.department"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::select('topic_department_id', ($department['all_departmentsnames']),null,['class' => 'form-control select2','disabled']) !!}
        </div>
    </div>

</div>
   
<div class="form-body">
    <div class="form-group {!! $errors->has('topic_name') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.forums.topic_name"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('topic_name', null, ['class'=>'form-control', 'placeholder'=>"Enter title",'disabled']) !!}
            {!! $errors->first('topic_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.forums.status"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('status', null, ['class'=>'form-control', 'placeholder'=>"Enter title",'disabled']) !!}
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('total_likes') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.forums.total_likes"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('total_likes', null, ['class'=>'form-control', 'placeholder'=>"Enter title",'disabled']) !!}
            {!! $errors->first('total_likes', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('total_dislikes') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.forums.total_dislikes"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('total_dislikes', null, ['class'=>'form-control', 'placeholder'=>"Enter title",'disabled']) !!}
            {!! $errors->first('total_dislikes', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('total_comments') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.forums.total_comments"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('total_comments', null, ['class'=>'form-control', 'placeholder'=>"Enter title",'disabled']) !!}
            {!! $errors->first('topic_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('total_views') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.forums.total_views"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('total_views', null, ['class'=>'form-control', 'placeholder'=>"Enter title",'disabled']) !!}
            {!! $errors->first('total_views', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <?php /*{!! Form::submit(isset($model) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!} */ ?>
            <a class="btn default" href="{{route(config('project.admin_route').'forums.index')}}">Cancel</a>
        </div>
    </div>
</div>
<!-- END FORM-->