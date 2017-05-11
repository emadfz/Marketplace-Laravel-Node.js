<div class="form-body">
    <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
        {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    @if( isset($product->product_slug) && !empty($product->product_slug))
    <div class="form-group">
        {!! Form::label('','Product Slug', ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-8">
            {!! Form::label('', @$product->product_slug) !!}            
        </div>
    </div>
    @endif

    <div class="form-group {!! $errors->has('manufacturer') ? 'has-error' : '' !!}">
        {!! Form::label('manufacturer', 'Manufacturer', ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('manufacturer', null, ['class'=>'form-control']) !!}
            {!! $errors->first('manufacturer', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('price') ? 'has-error' : '' !!}">
        {!! Form::label('price', 'Price', ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('price', null, ['class'=>'form-control']) !!}
            {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('category_id') ? 'has-error' : '' !!}">
        {!! Form::label('category_id', 'Categories', ['class' => 'col-md-3 control-label']) !!}        
        <div class="col-md-4">
            {!! Form::select('category_id', @$categories, null, ['class'=>'form-control select2']) !!}
            {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('is_return_applicable') ? 'has-error' : '' !!}">
        {!! Form::label('is_return_applicable', 'Return applicable', ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">                                
            {!! Form::radio('is_return_applicable','yes', @$product->is_return_applicable, ['class'=>'field']) !!}Yes
            {!! Form::radio('is_return_applicable','no', @$product->is_return_applicable, ['class'=>'field']) !!}No
            {!! $errors->first('is_return_applicable', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('is_warranty_applicable') ? 'has-error' : '' !!}">
        {!! Form::label('is_warranty_applicable', 'Warranty applicable', ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::radio('is_warranty_applicable','yes', @$product->is_warranty_applicable) !!}Yes
            {!! Form::radio('is_warranty_applicable','no', @$product->is_warranty_applicable) !!}No
            {!! $errors->first('is_warranty_applicable', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
        {!! Form::label('description', 'Description', ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('status', 'Status', ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::select('status', [''=>'Select status', 'Active'=>'Active', 'Inactive'=>'Inactive'], null, ['class'=>'form-control']) !!}
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>



</div>







<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(isset($model) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'products.index')}}">Cancel</a>
        </div>
    </div>
</div>
@push('scripts')
<script>

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {

                $('.img-holder').attr('src', e.target.result).attr('width', '100').attr('height', '100');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#photo").change(function () {
        readURL(this);
    });
</script>

@endpush