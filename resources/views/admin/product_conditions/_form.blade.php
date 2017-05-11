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
    <div class="form-group required{!! $errors->has('category_id') ? 'has-error' : '' !!}">
        {!! Form::label('category_id', 'Categories', ['class' => 'col-md-3 control-label']) !!}        
        <div class="col-md-4">
            {!! Form::select('category_id', @$categories, @$productConditions->category_id, ['class'=>'form-control select2']) !!}
            {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('name') ? 'has-error' : '' !!}">
        {!! Form::label('name', trans("form.product_conditions.lbl_name"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::text('name', @$productConditions->name, ['class'=>'form-control', 'placeholder'=>"Enter Product Condition Name"]) !!}
            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>    
    <div class="form-group required {!! $errors->has('description') ? 'has-error' : '' !!}">
        {!! Form::label('description', trans("form.product_conditions.lbl_description"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">            
            {!! Form::textarea('description', @$productConditions->description, ['class'=>'form-control', 'placeholder'=>"Enter Product Condition Description"]) !!}            
            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>


</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">            
            {!! Form::submit(trans("form.product_conditions.btn_save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'product_conditions.index')}}">{{trans("form.product_conditions.btn_cancel")}}</a>
        </div>
    </div>
</div>
<!-- END FORM-->