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
    <div class="form-group required {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('status', trans("form.giftcards.status"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::select('status', array(''=>'select','Draft'=>'Draft','Active'=>'Active'),@$giftcard->status, ['class'=>'form-control']) !!}
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('title') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.giftcards.title"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::text('title', @$giftcard->title, ['class'=>'form-control', 'placeholder'=>"Enter Giftcard Title"]) !!}
            {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required  {!! $errors->has('code') ? 'has-error' : '' !!}">
        {!! Form::label('code', trans("form.giftcards.code"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            @if(isset($giftcard->code) && !empty($giftcard->code))
                {!! Form::text('code', decrypt(@$giftcard->code), ['class'=>'form-control', 'placeholder'=>"Enter Giftcard Title","readonly"]) !!}                
            @else   
                {!! Form::text('code', @$giftcard->code, ['class'=>'form-control', 'placeholder'=>"Enter Giftcard Code"]) !!}
            @endif    

            {!! $errors->first('code', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('price') ? 'has-error' : '' !!}">
        {!! Form::label('price', trans("form.giftcards.price"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('price', @$giftcard->price, ['class'=>'form-control', 'placeholder'=>"Enter Giftcard Price"]) !!}
            {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
        </div>
    </div>    
    <div class="form-group  {!! $errors->has('image') ? 'has-error' : '' !!}">        
        {!! Form::label('image', trans("form.giftcards.image"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">            
            {!! Form::file('image[]', null, ['class'=>'form-control']) !!}            
            {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
            <br/>                        
            @if(isset($giftcard->Files[0]) && !empty($giftcard->Files[0]))
            {!! getImageByPath($giftcard->Files[0]->path,'thumbnail') !!}                
            {!! Form::hidden('old_image', $giftcard->Files[0]->path, ['class'=>'form-control']) !!}
            @endif
        </div>
    </div> 

    <div class="form-group required {!! $errors->has('description') ? 'has-error' : '' !!}">
        {!! Form::label('description', trans("form.giftcards.description"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::textarea('description', @$giftcard->description,['class' => 'form-control']) !!}
            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>        
    <div class="form-group required {!! $errors->has('quantity') ? 'has-error' : '' !!}">
        {!! Form::label('quantity', trans("form.giftcards.quantity"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('quantity', @$giftcard->quantity, ['class'=>'form-control']) !!}
            {!! $errors->first('quantity', '<span class="help-block">:message</span>') !!}
        </div>
    </div> 
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">            
            {!! Form::submit($btntxt, ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'giftcards.index')}}">{{trans("form.giftcards.btn_cancel")}}</a>
        </div>
    </div>
</div>
<!-- END FORM--> 
