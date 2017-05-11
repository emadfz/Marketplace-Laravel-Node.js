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
    <div class="form-group required {!! $errors->has('title') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.topic_departments.title"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('department_name', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('department_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group required  {!! $errors->has('department_description') ? 'has-error' : '' !!}">
        {!! Form::label('department_description', trans("form.topic_departments.description"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::textarea('department_description', null, ['class'=>'form-control']) !!}
            {!! $errors->first('department_description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-body">
        <div class="form-group required {!! $errors->has('color') ? 'has-error' : '' !!}">
            {!! Form::label('color', trans("form.forums.color"), ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-4">
                {!! Form::text('color', isset($departments['color'])?$departments['color']:NULL, ['class'=>'form-control demo', 'data-control'=>"hue"]) !!}
                {!! $errors->first('color', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="form-body">
        <div class="form-group  required  {!! $errors->has('image.*') ? 'has-error' : '' !!}">
            {!! Form::label('image', trans("form.forums.image"), ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-4">
                {!! Form::file('image[]', null, ['class'=>'form-control image.0']) !!}
                {!! $errors->first('image.*', '<span class="help-block">:message</span>') !!}
                <br/>
                @if(isset($departments->Files[0]) && !empty($departments->Files[0]))
                    {!! getImageByPath($departments->Files[0]->path,'thumbnail') !!}
                    {!! Form::hidden('old_image', $departments->Files[0]->path, ['class'=>'form-control']) !!}
                @endif
            </div>
        </div>
    </div>


</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(isset($model) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'departments.index')}}">Cancel</a>
        </div>
    </div>
</div>

<!-- END FORM-->

@push('styles')
<link href="{{ asset('assets/admin/global/plugins/jquery-minicolors/jquery.minicolors.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/jquery-minicolors/jquery.minicolors.min.js') }}"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-color-pickers.min.js') }}"></script>
<!--[if lt IE 9]>
<script src="{{ asset('assets/admin/global/plugins/respond.min.js') }}"></script>
<script src="{{ asset('assets/admin/global/plugins/excanvas.min.js') }}"></script>
<![endif]-->
@endpush