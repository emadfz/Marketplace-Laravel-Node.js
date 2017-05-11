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

    <div class="form-group  {!! $errors->has('image.*') ? 'has-error' : '' !!} required">        
        {!! Form::label('image', trans("message.file_uploads.image"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">            
            {!! Form::file('image[]', ['class'=>'form-control image.0']) !!}            
            {!! $errors->first('image', '<span class="help-block" >:message</span>') !!}
            <br/>                        
            @if(count(@$fileuploads->Files)>0)            
            {!! generateDocumentAnchor(@$fileuploads->Files[0]->path) !!}            
            {!! Form::hidden('old_image', @$giftcard->Files[0]->path, ['class'=>'form-control']) !!}
            @endif
        </div>
    </div>










<div class="form-body">
    <div class="form-group {!! $errors->has('file_labels_id') ? 'has-error' : '' !!} required">
        {!! Form::label('title', trans("form.file_uploads.select_label"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::select('file_labels_id', ($label['all_labels']),null,['class' => 'form-control select2']) !!}
        </div>
    </div>

</div>

<div class="form-body">
    <div class="form-group {!! $errors->has('category_id') ? 'has-error' : '' !!} required">
        {!! Form::label('title', trans("form.file_uploads.select_category"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::select('category_id', ($label['all_categories']),null,['class' => 'form-control select2']) !!}
        </div>
    </div>

</div>

<div class="form-body">
    <div class="form-group {!! $errors->has('file_name') ? 'has-error' : '' !!} required">
        {!! Form::label('title', trans("form.file_uploads.file_name"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('file_name', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('file_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(isset($model) ? trans("form.save") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'fileuploads.index')}}">Cancel</a>
        </div>
    </div>
</div>
<style>
            option:nth-child(1), option:nth-child(4) {
    font-weight:bold;
}
</style>
<!-- END FORM-->