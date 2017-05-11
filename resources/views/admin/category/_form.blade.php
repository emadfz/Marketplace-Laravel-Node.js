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
     <div class="form-group required {!! $errors->has('text') ? 'has-error' : '' !!}">
        {!! Form::label('text', trans("form.category.text"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::text('text', @$category->text, ['class'=>'form-control', 'placeholder'=>"Enter Category Title"]) !!}
            {!! $errors->first('text', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('status', trans("form.category.status"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::select('status', array(''=>'select','Active'=>'Active','Inactive'=>'Inactive'),@$category->status, ['class'=>'form-control']) !!}
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('description') ? 'has-error' : '' !!}">
        {!! Form::label('description', trans("form.category.description"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::textarea('description', @$category->description,['class' => 'form-control']) !!}
            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>    
    <div class="form-group required {!! $errors->has('scope') ? 'has-error' : '' !!}">
        {!! Form::label('scope', trans("form.category.scope"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">                         
            @php $scopeArray=explode(',',$category->scope);@endphp            
              <input  type="checkbox" class="scope" name="scope[]" value="Products" {{ (in_array('Products',$scopeArray))?'checked':'' }} /> Products <br/> 
              <input  type="checkbox" class="scope" name="scope[]" value="Services" {{ (in_array('Services',$scopeArray))?'checked':'' }} /> Services <br/>          
            {!! $errors->first('scope', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('type') ? 'has-error' : '' !!}">
        {!! Form::label('type', trans("form.category.type"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::select('type', array(''=>'select','General'=>'General','Special'=>'Special'),@$category->type, ['class'=>'form-control']) !!}
            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    
    <div class="form-group required {!! $errors->has('product_conditions_id') ? 'has-error' : '' !!}">
        {!! Form::label('product_conditions_id', trans("form.category.product_conditions"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::select('product_conditions_id[]', $product_conditions,explode(',',@$category->product_conditions_id), ['class'=>'form-control','multiple']) !!}
            {!! $errors->first('product_conditions_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group  {!! $errors->has('image') ? 'has-error' : '' !!}">        
        {!! Form::label('image', trans("form.category.photo"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">            
            {!! Form::file('image[]', null, ['class'=>'form-control']) !!}            
            {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
            
            @if(isset($category->Files) && $category->Files->count()>0)
            {!! getImageByPath($category->Files[0]->path,'thumbnail') !!}                
            {!! Form::hidden('old_image', $category->Files[0]->path, ['class'=>'form-control']) !!}
            @endif
        </div>
    </div> 
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">            
            {!! Form::submit(trans("form.update"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'category.index')}}">{{trans("form.category.btn_cancel")}}</a>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function(){
    $('.scope').click(function(e){
        if($('.scope:checked').length<1){
            toastr.error('Atleast one checkbox has to be checked!!');
            e.preventDefault();
        }        
    });
});
</script>
@endpush
<!-- END FORM--> 
