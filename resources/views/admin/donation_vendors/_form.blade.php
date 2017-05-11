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
    <div class="form-group {!! $errors->has('vendor_name') ? 'has-error' : '' !!}">
        {!! Form::label('vendor_name', trans("form.donation_vendors.vendor_name"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('vendor_name', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('vendor_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('status', trans("form.donation_vendors.status"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::select('status', ['select'=>'select','Active'=>'Active','Inactive'=>'Inactive'],null, ['class'=>'form-control col-md-3 control-label']) !!}
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group {!! $errors->has('vendor_description') ? 'has-error' : '' !!}">
        {!! Form::label('vendor_description', trans("form.donation_vendors.description"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::textarea('vendor_description', null, ['class'=>'form-control']) !!}
            {!! $errors->first('vendor_description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group {!! $errors->has('website_link') ? 'has-error' : '' !!}">
        {!! Form::label('website_link', trans("form.donation_vendors.website_link"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('website_link', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('website_link', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group {!! $errors->has('admin_fees') ? 'has-error' : '' !!}">
        {!! Form::label('admin_fees', trans("form.donation_vendors.admin_fees"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('admin_fees', null, ['class'=>'form-control', 'placeholder'=>"Enter title"]) !!}
            {!! $errors->first('admin_fees', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group contract_duration_cls {{ $errors->has('contract_duration') ? 'has-error' : ''}}">
            {!! Form::label('contract_duration', trans('form.donation_vendors.contract_duration'), ['class' => 'col-sm-3 control-label']) !!}                                                                    
            <div class="col-sm-6">
                <div class="input-group input-large date-picker input-daterange" data-date="11-10-2012" data-date-format="yyyy-mm-dd" style="width : 100% !important;">
                {!! Form::text('start_date', null , ['class' => 'form-control','placeholder'=> 'Start Date','tabindex' => '21']) !!}                                
                <span class="input-group-addon"> to </span> 
                {!! Form::text('end_date', null , ['class' => 'form-control','placeholder'=> 'End Date','tabindex' => '22']) !!}                
                </div>
            </div>    
        </div>

</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(isset($model) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'donationvendors.index')}}">Cancel</a>
        </div>
    </div>
</div>

<!-- END FORM-->
@push('styles') 
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')

<script src="{{ asset('assets/admin/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>        
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
@endpush