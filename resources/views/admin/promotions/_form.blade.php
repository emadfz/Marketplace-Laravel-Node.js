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
    <div class="form-group required {!! $errors->has('discount_type') ? 'has-error' : '' !!}">
        {!! Form::label('discount_type', trans("form.promotions.lbl_discount_type"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">            
            {!! Form::radio('discount_type','percentage', true) !!} Percentage              
            {!! Form::radio('discount_type','fix',(@$promotions->discount_type=='fix')?true:false ) !!} Fixed Price  
            {!! $errors->first('discount_type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('discount') ? 'has-error' : '' !!}">
        {!! Form::label('discount', trans("form.promotions.discount"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::text('discount', @$promotions->discount, ['class'=>'form-control', 'placeholder'=>"Enter Discount"]) !!}
            {!! $errors->first('discount', '<span class="help-block">:message</span>') !!}
        </div>
    </div>  
    <div class="form-group required {!! $errors->has('validity') ? 'has-error' : '' !!}">
        {!! Form::label('validity', trans("form.promotions.validity"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">            
            <div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
                <span class="input-group-addon"> From </span>
                {!! Form::text('start_date', @convertToDateFormat($promotions->start_date,'d-m-Y'), ['class'=>'form-control', 'placeholder'=>"Start Date",'readonly']) !!}
                <span class="input-group-addon"> to </span>
                {!! Form::text('end_date', @convertToDateFormat($promotions->end_date,'d-m-Y'), ['class'=>'form-control', 'placeholder'=>"End Date",'readonly']) !!}
            </div>
            {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('promo_code') ? 'has-error' : '' !!}">
        {!! Form::label('promo_code', trans("form.promotions.promo_code"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::text('promo_code', @$promotions->promo_code, ['class'=>'form-control', 'placeholder'=>"Enter Promo Code"]) !!}
            {!! $errors->first('promo_code', '<span class="help-block">:message</span>') !!}
        </div>
    </div>        
    
    
    <div class="form-group required {!! $errors->has('select_users') ? 'has-error' : '' !!}">
        {!! Form::label('select_users', trans("form.promotions.select_users"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::radio('users','all', true) !!} All  
            {!! Form::radio('users','select', (@$promotions->selected_users!='all' && !empty($promotions->selected_users))?true:false) !!} Select User  
        

        <div <?php echo (isset($promotions->selected_users) && @$promotions->selected_users!='all')?'':'class="hidden"'; ?>   id="selectuser_container">
            {!! Form::select('selected_users[]', isset($users)?$users:array(''),isset($users)? $users->keys()->toArray():null, ['class'=>'form-control input-lg  select2','multiple','id'=>'selected_users']) !!}            
            {!! $errors->first('selected_users', '<span class="help-block">:message</span>') !!}
        </div>
        </div>
    </div>

    <div class="form-group required {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('status', trans("form.promotions.status"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">                        
            {!! Form::checkbox('status', 'Active', (@$promotions->status=='Active')?true:false,['class'=>'form-control make-switch']) !!}            
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>



<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">            
            {!! Form::submit(trans("form.promotions.btn_save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'promotions.index')}}">{{trans("form.promotions.btn_cancel")}}</a>
        </div>
    </div>
</div>
<!-- END FORM-->

@push('styles') 
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>

<script>
$(document).ready(function () {
    
     $('.select2').select2({
		formatInputTooShort : function() {return false;},
		minimumInputLength : 3,    
                width: '100%',    
                ajax: {               
                    type: 'get',                    
                    url: function (params) {	        	                              
		      return '<?php echo URL('/admin/getAllUser'); ?>';
		    },
                    dataType: 'json',
                    cache: true,
                    processResults: function (data) {
	            return {
                        
	                results: $.map(data, function(obj) {                            
	                    return obj;
	                })
	            };
	        },
	    }
	});


    $("input[name='users']").click(function(){    
        if($(this).val()=='select'){
            $('#selectuser_container').removeClass('hidden');            
        }
        else{
            $('#selectuser_container').addClass('hidden');
        }
    });
    

});

</script>
@endpush