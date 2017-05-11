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
    <div class="form-group required {!! $errors->has('transaction_id') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.transactions.transaction_id"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">            
            {!! Form::text('transaction_id', 'TRAN'.strtotime(\Carbon\Carbon::now()->toDateTimeString()), ['class'=>'form-control', 'placeholder'=>"Transaction Id",'readonly']) !!}
            {!! $errors->first('transaction_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>   
<div class="form-body">
    <div class="form-group required {!! $errors->has('vendors_id') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.transactions.select_vendor"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::select('vendors_id', ($vendors['all_vendor_by_types']),null,['class' => 'form-control select2']) !!}
        </div>
    </div>

</div>
   
<div class="form-body">
    <div class="form-group required {!! $errors->has('amount_received') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.transactions.amount_received"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-2">
            {!! Form::text('amount_received', null, ['class'=>'form-control', 'placeholder'=>""]) !!}
            {!! $errors->first('amount_received', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="form-body">
    <div class="form-group required{!! $errors->has('amount_paid') ? 'has-error' : '' !!}">
        {!! Form::label('title', trans("form.transactions.amount_paid"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-2">
            {!! Form::text('amount_paid', null, ['class'=>'form-control', 'placeholder'=>""]) !!}
            {!! $errors->first('amount_paid', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>

<div class="form-group required {{ $errors->has('transaction_date') ? 'has-error' : ''}}">
            {!! Form::label('transaction_date', trans('form.transactions.transaction_date'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-4" >
                <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" style="width : 100% !important;">
                    {!! Form::text('transaction_date', null , ['class' => 'form-control','tabindex' => '25']) !!}
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>            
                {!! $errors->first('transaction_date', '<p class="help-block">:message</p>') !!}
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
@push('styles') 
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/css/components.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/admin/global/css/jquery.fileupload.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/css/jquery.fileupload-ui.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>        
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
@endpush
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