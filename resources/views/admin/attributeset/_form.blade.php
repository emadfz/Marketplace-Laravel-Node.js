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
    <div class="form-group {!! $errors->has('attribute_set_categoryid') ? 'has-error' : '' !!}">
        {!! Form::label('attribute_set_categoryid', trans("attributeset.attribute_set_category"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-6">
            {!! Form::select('attribute_set_categoryid[]', ($input['all_categories']),($input['attribute_cat']),['class' => 'form-control bs-select','multiple'=>'multiple']) !!}
            {!! $errors->first('attribute_set_categoryid[]', '<span class="help-block">:message</span>') !!}
        </div>
    </div>    <br/>
    <div class="form-group {!! $errors->has('attribute_set_name') ? 'has-error' : '' !!} required">
        {!! Form::label('attribute_set_name', trans("attributeset.attribute_set_name"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('attribute_set_name', null, ['class'=>'form-control', 'placeholder'=>"Enter Attribute Set Name"]) !!}
            {!! $errors->first('attribute_set_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('attribute_set_description') ? 'has-error' : '' !!} required">
        {!! Form::label('attribute_set_description', trans("attributeset.attribute_set_description"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::textarea('attribute_set_description', null, ['class'=>'form-control']) !!}
            {!! $errors->first('attribute_set_description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(isset($model) ? trans("attributeset.update") : trans("attributeset.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'attributeset.index')}}">Cancel</a>
        </div>
    </div>
</div>

<!-- END FORM-->
@push('styles')
<link href="{{ asset('assets/admin/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/css/components.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>  
@endpush