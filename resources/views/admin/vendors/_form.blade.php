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
    <div class="form-group {!! $errors->has('vendor_types_id') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.vendors.vendor_types"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::select('vendor_types_id', ($vendor_types['all_vendor_types']),null,['class' => 'form-control select2']) !!}
        </div>
    </div>

</div>
   
<div class="form-body">
    <div class="form-group {!! $errors->has('vendor_name') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.vendors.vendor_name"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('vendor_name', null, ['class'=>'form-control', 'placeholder'=>"Vendor Name"]) !!}
            {!! $errors->first('vendor_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('contact_person') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.vendors.contact_person"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('contact_person', null, ['class'=>'form-control', 'placeholder'=>"Contact Person Name"]) !!}
            {!! $errors->first('contact_person', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('skype_id') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.vendors.skype_id"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('skype_id', null, ['class'=>'form-control', 'placeholder'=>"Skype Id"]) !!}
            {!! $errors->first('skype_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
            {!! Form::label('country', trans('employee.country'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">            
                {!! Form::select('country_id', (['0' => 'Select Country']+ $input['countries']),null,['class' => 'form-control select2','id' => 'country']) !!}
                {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
            </div>
</div>  
<div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
            {!! Form::label('state', trans('employee.state'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::select('state_id', (['0' => 'Select State']+ $input['states']),null,['class' => 'form-control select2','id' => 'state']) !!}                
                {!! $errors->first('state', '<p class="help-block">:message</p>') !!}
            </div>
</div>
<div class="form-group {{ $errors->has('city') ? 'has-error' : ''}}">
            {!! Form::label('city', trans('employee.city'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::select('city_id', (['0' => 'Select City']+ $input['cities']),null,['class' => 'form-control select2','id'=>'city']) !!}
                {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
            </div>
</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('address_line1') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.vendors.address_line1"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('address_line1', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('address_line1', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('zipcode') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.vendors.zipcode"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('zipcode', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('zipcode', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('contact_number') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.vendors.contact_number"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('contact_number', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('contact_number', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('contact_email') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.vendors.contact_email"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('contact_email', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('contact_email', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
<div class="form-body">
    <div class="form-group {!! $errors->has('account_number') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.vendors.account_number"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('account_number', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('account_number', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>

<div class="form-actions">
    <div class="row"> 
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(isset($model) ? trans("form.save") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'vendors.index')}}">Cancel</a>
        </div>
    </div>
</div>
@push('scripts')
<script language="javascript">
$('#country').on('change', function(e){                
        var country_id = e.target.value;        
        $.get('{{ url('information') }}/create/ajax-state?country_id=' + country_id, function(data) {            
            $('#state').empty();
            $('#state').append('<option value="0">Select State</option>');
            $.each(data, function(index,subCatObj){ 
                
                $('#state').append('<option value='+subCatObj.id+'>'+subCatObj.state_name+'</option>');
            });
        });
    });
    
    $('#state').on('change', function(e){                
        var state_id = e.target.value;   
        
        $.get('{{ url('information') }}/create/ajax-city?state_id=' + state_id, function(data) {                        
            
            $('#city').empty();
            $('#city').append('<option value="0">Select City</option>');
            $.each(data, function(index,subCatObj){             
                $('#city').append('<option value="'+subCatObj.id+'">'+subCatObj.city_name+'</option>');
            });
        });
    });            
</script>  
@endpush
<!-- END FORM-->