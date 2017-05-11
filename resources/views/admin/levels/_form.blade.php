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
    <div class="form-group {!! $errors->has('title') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.title"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
        {!! Form::label('description', trans("form.description"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('parent_id') ? 'has-error' : '' !!}">
        {!! Form::label('parent_id', trans("form.parent"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::select('parent_id', [''=> trans("form.select_parent_category") ]+$all_categories, null, ['class'=>'form-control']) !!}
            {!! $errors->first('parent_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('status', trans("form.status"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::select('status', [''=>trans("form.select_status"), 'Active'=>'Active', 'Inactive'=>'Inactive'], null, ['class'=>'form-control']) !!}
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('photo') ? 'has-error' : '' !!}">
        {!! Form::label('photo', trans("form.category_photo"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::file('photo', ['id'=>'input-photo']) !!}
            {!! $errors->first('photo', '<p class="help-block">:message</p>') !!}

            @if (isset($model) && $model->photo !== '')
            <div class="row">
                <div class="col-md-6"><br/>
                    <p>{{trans("form.current_photo")}}:</p>
                    <div class="thumbnail">
                        <img src="{{ url(config('project.category_images_path') . $model->photo) }}" class="img-rounded">
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(isset($model) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'categories.index')}}">Cancel</a>
        </div>
    </div>
</div>

<!-- END FORM-->