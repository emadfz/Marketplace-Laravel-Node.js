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
 <style type="text/css">
            .template-upload td{padding-left:15px;}
        </style>
<div class="form-body">
    <div style="width: 100%;float:left;margin-top:5px;">
        <div style="width: 50%;float:left;">
            <div class="form-group {{ $errors->has('employee_code') ? 'has-error' : ''}}">                
                {!! Form::label('employee_code', trans('employee.employee_code'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('employee_code', $input['employee_code'], ['class' => 'form-control','readonly'=>'readonly','id'=>'emp_code']) !!}
                    {!! $errors->first('employee_code', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
    <div style="width: 50%;float:left;">
        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
            {!! Form::label('first_name', trans('employee.first_name'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('first_name', null, ['class' => 'form-control','tabindex' => '1']) !!}
                {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
                {!! Form::label('gender', trans('employee.gender'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">                
                {!! Form::select('gender', array('female' => 'Female','male' => 'Male','prefer_not_to_say'=>'Prefer not to say'),null ,['class' => 'form-control','tabindex' => '3']) !!}
                {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('personal_email') ? 'has-error' : ''}} required">
            {!! Form::label('personal_email', trans('employee.personal_email'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                <div class="input-icon">
                <i class="fa fa-envelope"></i>
                {!! Form::email('personal_email', null, ['class' => 'form-control','id'=>'exampleInputEmail22','tabindex' => '5']) !!}
                </div>
                {!! $errors->first('personal_email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
        <div class="form-group {{ $errors->has('contact_number') ? 'has-error' : ''}}">
            {!! Form::label('contact_number', trans('employee.contact_number'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('contact_number', null, ['class' => 'form-control','tabindex' => '7','maxlength'=>"12"]) !!}
                {!! $errors->first('contact_number', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <?php
        if(!isset($input['action_type']) || $input['action_type'] != 'edit')
        {?>
        <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}} required">
            {!! Form::label('password', trans('employee.password'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                <div class="input-icon">
                        <i class="fa fa-user"></i>
                        {!! Form::password('password', ['class' => 'form-control','tabindex' => '9']) !!}                                       
                </div>            
                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
            </div>
        </div> 
        <?php } ?>
    </div>
    
    <div style="width: 50%;float:right;">  
        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
            {!! Form::label('last_name', trans('employee.last_name'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('last_name', null, ['class' => 'form-control','tabindex' => '2']) !!}
                {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
            {!! Form::label('designation', trans('employee.designation'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::select('designation', array('0' => 'Select Designation')+$input['designations'], null , ['class' => 'form-control','tabindex' => '4']) !!}
                {!! $errors->first('designation', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('professional_email') ? 'has-error' : ''}} required">
            {!! Form::label('professional_email', trans('employee.professional_email'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                <div class="input-icon">
                <i class="fa fa-envelope"></i>
                {!! Form::email('professional_email', null, ['class' => 'form-control','tabindex' => '6']) !!}
                </div>
                {!! $errors->first('professional_email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
        <div class="form-group {{ $errors->has('dob') ? 'has-error' : ''}} required">
            {!! Form::label('dob', trans('employee.dob'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('dob', null, ['class' => 'form-control', 'id' => 'mask_date2','tabindex' => '8']) !!}                
                {!! $errors->first('dob', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <?php if(!isset($input['action_type']) || $input['action_type'] != 'edit')
        { ?>
        <div class="form-group {{ $errors->has('confirm_password') ? 'has-error' : ''}} required">
            {!! Form::label('confirm_password', trans('employee.confirm_password'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                <div class="input-icon">
                        <i class="fa fa-user"></i>
                            {!! Form::password('confirm_password', ['class' => 'form-control','tabindex' => '10']) !!}
                </div>
                {!! $errors->first('confirm_password', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <?php } ?>
    </div>
    <div style="width: 100%; float:left;">
        <div class="form-group {{ $errors->has('address_line1') ? 'has-error' : ''}}">
            {!! Form::label('address_line1', trans('employee.address_line1'), ['class' => 'col-sm-3 control-label','style' => 'width : 18% !important']) !!}
            <div class="col-sm-6" style="width : 82% !important;">
                {!! Form::text('address_line1', null , ['class' => 'form-control','tabindex' => '11']) !!}
                {!! $errors->first('address_line1', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('address_line2') ? 'has-error' : ''}}">
            {!! Form::label('address_line2', trans('employee.address_line2'), ['class' => 'col-sm-3 control-label','style' => 'width : 18% !important']) !!}
            <div class="col-sm-6" style="width : 82% !important;">
                {!! Form::text('address_line2', null , ['class' => 'form-control','tabindex' => '12']) !!}
                {!! $errors->first('address_line2', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    
    <div style="width: 50%;float:left;">  
        <div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
            {!! Form::label('country', trans('employee.country'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">            
                {!! Form::select('country_id', (['0' => 'Select Country']+ $input['countries']),null,['class' => 'form-control select2','id' => 'country','tabindex' => '13']) !!}
                {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
        <div class="form-group {{ $errors->has('city') ? 'has-error' : ''}}">
            {!! Form::label('city', trans('employee.city'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::select('city_id', (['0' => 'Select City']+ $input['cities']),null,['class' => 'form-control select2','id'=>'city','tabindex' => '15']) !!}                                
                {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
        <div class="form-group {{ $errors->has('role_id') ? 'has-error' : ''}} required">
            {!! Form::label('role_id', trans('employee.role'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::select('role_id', (['0' => 'Select Level']+ $input['levels']),null,['class' => 'form-control select2','tabindex' => '17']) !!}                
                {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
        <div class="form-group {{ $errors->has('type_of_hire') ? 'has-error' : ''}}">
            {!! Form::label('type_of_hire', trans('employee.type_of_hire'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::select('type_of_hire', array('0'=> 'Select Type of Hire','fulltime' => 'Full Time','parttime' => 'Part Time','contractual' => 'Contractual'),null ,['class' => 'form-control ','id'=>'type_of_hire','tabindex' => '19']) !!}            
                {!! $errors->first('type_of_hire', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
        <div class="form-group contract_duration_cls {{ $errors->has('contract_duration') ? 'has-error' : ''}}"
             <?php
            if(isset($input['employee']) && $input['employee']->type_of_hire != 'contractual')
            { ?>style="display:none;" <?php } ?> >
            {!! Form::label('contract_duration', trans('employee.contract_duration'), ['class' => 'col-sm-3 control-label']) !!}                                                                    
            <div class="col-sm-6">
                <div class="input-group input-large date-picker input-daterange" data-date="11-10-2012" data-date-format="mm-dd-yyyy" style="width : 100% !important;">
                {!! Form::text('contract_start_date', null , ['class' => 'form-control','placeholder'=> 'Start Date','tabindex' => '21']) !!}                                
                <span class="input-group-addon"> to </span> 
                {!! Form::text('contract_end_date', null , ['class' => 'form-control','placeholder'=> 'End Date','tabindex' => '22']) !!}                
                </div>
            </div>
        </div>
        
        <div class="form-group {{ $errors->has('date_of_hire') ? 'has-error' : ''}}">
            {!! Form::label('date_of_hire', trans('employee.date_of_hire'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6" >
                <div class="input-group input-medium date date-picker" data-date-format="mm-dd-yyyy" data-date-start-date="+0d" style="width : 100% !important;">
                    {!! Form::text('date_of_hire', null , ['class' => 'form-control','tabindex' => '25']) !!}
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>
                {!! $errors->first('date_of_hire', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
        <div class="form-group {{ $errors->has('days_of_week') ? 'has-error' : ''}}">
            {!! Form::label('days_of_week', trans('employee.days_of_week'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::select('days_of_week[]', (['mon' => 'Monday','tue' => 'Tuesday','wed' => 'Wednesday','thur' => 'Thursday','fri'=>'Friday','sat'=>'Saturday','sun'=>'Sunday']),null,['class' => 'bs-select form-control','multiple' => 'multiple','tabindex' => '27']) !!}
                {!! $errors->first('days_of_week', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    
    <div style="width: 50%;float:left;">         
        <div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
            {!! Form::label('state', trans('employee.state'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::select('state_id', (['0' => 'Select State']+ $input['states']),null,['class' => 'form-control select2','id' => 'state','tabindex' => '14']) !!}                
                {!! $errors->first('state', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
        <div class="form-group {{ $errors->has('zipcode') ? 'has-error' : ''}}">
            {!! Form::label('zipcode', trans('employee.zipcode'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('zipcode', null , ['class' => 'form-control','tabindex' => '16']) !!}
                {!! $errors->first('zipcode', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
        <div class="form-group {{ $errors->has('department_id') ? 'has-error' : ''}}">
            {!! Form::label('department_id', trans('employee.department'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::select('department_id', (['0' => 'Select Department']+ $input['departments']),null,['class' => 'form-control select2','tabindex' => '18']) !!}
                {!! $errors->first('department_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
        <div class="form-group {{ $errors->has('service_location') ? 'has-error' : ''}}">
            {!! Form::label('service_location', trans('employee.service_location'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">                
                {!! Form::select('service_location', (['0' => 'Select Job location']+ $input['joblocation']),null,['class' => 'form-control select2','id' => 'state','tabindex' => '20']) !!}
                {!! $errors->first('service_location', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        
         <div class="form-group {{ $errors->has('working_hours') ? 'has-error' : ''}}">
            {!! Form::label('working_hours', trans('employee.working_hours'), ['class' => 'col-sm-3 control-label ']) !!}
            <div class="col-sm-6" style="width: 65% !important;float: left;">
                <div class="input-group"  style="width : 54% !important;float: left;">
                {!! Form::text('working_hours_from', null , ['class' => 'form-control timepicker-no-seconds','placeholder'=>'From','tabindex' => '23']) !!}
                <span class="input-group-btn" >
                    <button class="btn default" type="button">
                        <i class="fa fa-clock-o"></i>
                    </button>
                </span>
                </div>
                <div class="input-group" >
                {!! Form::text('working_hours_to', null , ['class' => 'form-control timepicker-no-seconds','placeholder'=>'To','tabindex' => '24']) !!}
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-clock-o"></i>
                    </button>
                </span>
                </div>
                {!! $errors->first('working_hours', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('deductibles') ? 'has-error' : ''}}">
            {!! Form::label('deductibles', trans('employee.deductibles'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('deductibles', null , ['class' => 'form-control','tabindex' => '26']) !!}
                {!! $errors->first('deductibles', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('wages') ? 'has-error' : ''}}">
            {!! Form::label('wages', trans('employee.wages'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('wages', null , ['class' => 'form-control','tabindex' => '28']) !!}
                {!! $errors->first('wages', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
                
    </div>    
    <div class="col-md-12 paddnone">        
        <div class="col-md-6 paddnone"> 
        
        <div class="form-group {{ $errors->has('secret_question_id') ? 'has-error' : ''}} required">
            {!! Form::label('secret_question', trans('employee.secret_question'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::select('secret_question_id', (['0' => 'Select Security Question']+$input['secretquestions']),null,['class' => 'form-control','tabindex' => '29']) !!}
                {!! $errors->first('secret_question_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
       
    </div>
        <div class="col-md-6 paddnone" id='secret_answer_div' style="display:none"> 
        <div class="form-group {{ $errors->has('secret_answer') ? 'has-error' : ''}} required">
            {!! Form::label('secret_answer', trans('employee.secret_answer'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">            
                {!! Form::text('secret_answer', null , ['class' => 'form-control','tabindex' => '30']) !!}
                {!! $errors->first('secret_answer', '<p class="help-block">:message</p>') !!}
            </div>
        </div>        
    </div>  
     
        
    </div>
    <div class="col-md-12"> 
        <div class="col-md-6"> 
         <div class="form-group {{ $errors->has('photo') ? 'has-error' : ''}}">
            {!! Form::label('admin_photo', trans('employee.admin_photo'), ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6"> 
                <div class="form-group">
                {!! Form::file('photo', ['class' => 'form-control','tabindex' => '32','style'=>'padding:0px;']) !!}                
                </div>
            </div>
            <?php           
            if(isset($input['employee']) && $input['employee']->photo_relative_path != '')
            { ?>
            <div class="col-sm-6 col-md-offset-4" >
                <a href= "{{ asset('images/employee/'.$input['employee']->photo_relative_path) }}" target="_blank" id="oldimage">
                <img src="{{ asset('images/employee/'.$input['employee']->photo_relative_path) }}" style="width: 45px; height: 45px;" alt="Profile Photo" /></a>
            </div>
            <?php } ?>
        </div>            
        </div>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9" style="position:absolute; bottom:10px;">
                {!! Form::submit(isset($model) ? trans("employee.update") : trans("employee.save"), ['class'=>'btn btn-primary']) !!}
                <a class="btn default" href="{{route(config('project.admin_route').'employee.index')}}">Cancel</a>
            </div>
        </div>    
    </div>
    <input type="hidden" value="<?php echo url('/uploads/documents/php/').'/';?>" id="document_path" >
</div><!-- END FORM-->

<style>
    .col-sm-6{ width: 65% !important;}.col-sm-3{ width: 35% !important;}
    .paddnone{ padding: 0 !important;}
    .photocls{ position: absolute; background-color: #fff; position: absolute; z-index: 1;}
</style>
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
<script src="{{ asset('assets/admin/pages/scripts/form-input-mask.min.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>  
<script>
      $('#type_of_hire').change(function(){
        var type_of_hire =  $( "#type_of_hire option:selected" ).text();
            if(type_of_hire == 'Contractual'){ $('.contract_duration_cls').show(); }else{ $('.contract_duration_cls').hide(); }
      })
          
    $('#country').on('change', function(e){                
        var country_id = e.target.value;        
        $.get('{{ url('information') }}/create/ajax-state?country_id=' + country_id, function(data) {            
            $('#state').empty();
            $('#state').append('<option value="0">Select State</option>');
            $('#city').html('<option value="0">Select City</option>');
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
        
    $(function () {
        'use strict';
        // Initialize the jQuery File Upload widget:
        $('#fileupload').fileupload({        
            url: $('#document_path').val()
        });

        $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0],
            data:{emp_code : $('#emp_code').attr('value')}
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });

    });
    
    $('select[name="secret_question_id"]').change(function(){
        $('#secret_answer_div').hide();
        $('#secret_answer').attr('disabled','disabled');
        if($(this).val()!=0){
            $('#secret_answer').removeAttr('disabled');
            $('#secret_answer_div').show();
        }
    });
    $('select[name="secret_question_id"]').trigger('change');
    
    $(document).ready(function() {
        $('#confirm_password,#password').bind('copy paste', function(e) {
            e.preventDefault();
        });
    });
</script>

<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js') }}"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/jquery.fileupload.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js') }}" type="text/javascript"></script>
@endpush
