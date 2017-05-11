{{--@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif--}}

<!-- BEGIN here FORM-->
{!! Form::open(['route' => 'admin.advertisements.store', 'class' => 'form-horizontal ajax','id'=>'postadv', 'files' => true ])!!}
<div  class="form-body">
    <div class="caption">
        <i class="icon-equalizer font-blue"></i>
        <span class="caption-subject font-blue bold">{!!trans('message.advertisements.advertisement')!!}</span>        
    </div>
    <hr>
    <div class="form-group {{ $errors->has('add_to_display') ? 'has-error' : ''}} required">
        {!! Form::label('add_to_display', trans('message.advertisements.where_to_display_add'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::select('add_to_display', array(''=>'Select to display','home_page' => 'Home Page','category_page' => 'Category Page','subcategory_page' => 'Sub-Category Page','mingle_page'=>'Mingle Page'), null , [ 'class' => 'form-control','tabindex' => '1','id' => 'add_to_display' ]) !!}
            {!! $errors->first('add_to_display', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('cat_id') ? 'has-error' : ''}} parent_div required" style="display:none;" id="catblock">
        {!! Form::label('cat_id', trans('message.advertisements.select_cat'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::select('cat_id[]', array('0' => 'Select Category')+$input['all_categories'], null , ['class' => 'form-control parent','id'=>'cat_id','tabindex' => '2']) !!}
            {!! $errors->first('cat_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
<!--    <div id="show_sub_categories"></div>-->
    
    <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}} required">
        {!! Form::label('type', trans('message.advertisements.adv_type'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            <div style="float:left;width:50%;">
                <label>
                    {!! Form::radio('type', 'Banner', 'Banner' ,['class' => 'form-control','style' => 'width : 18% !important;float:left;','tabindex' => '3']) !!}
                    <div style="float: left;margin-top: 12%;margin-left: 5px;">{!!trans('message.advertisements.banner_type')!!}</div>
                </label>
            </div>
            <div style="float:left;width:50%;">
                <label>
                    {!! Form::radio('type', 'Main_Box', 'Main_Box',['class' => 'form-control','style' => 'width : 18% !important;float:left;','tabindex' => '4']) !!}
                    <div style="float: left;margin-top: 12%;margin-left: 5px;">{!!trans('message.advertisements.main_type')!!}</div>
                </label>
            </div>
            {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}} required">
        {!! Form::label('start_date', trans('message.advertisements.start_date'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" style="width : 100% !important;">
                {!! Form::text('start_date', null, ['class' => 'form-control','tabindex' => '5','id'=>'val_start_date']) !!}
                <span class="input-group-btn" style="vertical-align:top !important;">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                </span>
            </div>
            {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('available_days') ? 'has-error' : ''}} required">
        {!! Form::label('available_days', trans('message.advertisements.available_days'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('available_days', null, ['class' => 'form-control','style'=>'','tabindex' => '6']) !!}
            {!! $errors->first('available_days', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-8">{!! trans('message.advertisements.available_days_note') !!}</div>
    </div>
    <br>
    
    <div class="caption">
        <i class="icon-equalizer font-blue"></i>
        <span class="caption-subject font-blue bold">{!! trans('message.advertisements.advr_details') !!}</span><hr>
    </div>
    
    <div class="form-group {{ $errors->has('advr_name') ? 'has-error' : ''}} required">
        {!! Form::label('advr_name', trans('message.advertisements.advr_name'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('advr_name', null, ['class' => 'form-control','tabindex' => '7']) !!}
            {!! $errors->first('advr_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('advr_url') ? 'has-error' : ''}} required">
        {!! Form::label('advr_url', trans('message.advertisements.advr_url'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('advr_url', null, ['class' => 'form-control','tabindex' => '8']) !!}
            {!! $errors->first('advr_url', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('upload_image') ? 'has-error' : ''}}">
        {!! Form::label('upload_image', trans('message.advertisements.upload_image'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::file('upload_image[]', ['tabindex' => '9','id'=>'imgInp']) !!}
            {!! $errors->first('upload_image', '<p class="help-block">:message</p>') !!}            
        </div>
    </div>
        
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-4 col-md-9">
                {!! Form::submit(isset($model) ? trans("message.update") : trans("message.save"), ['class'=>'btn btn-primary']) !!}
                <a class="btn default" href="{{route(config('project.admin_route').'advertisements.index')}}">Cancel</a>                
                <a id="id_preview" class="btn blue btn-outline sbold" data-toggle="modal" href="#large"> {!!trans("message.preview")!!} </a>
            </div>
        </div>
    </div>
    
</div>
{!! Form::close() !!}
<!-- END FORM-->
<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{!!trans("message.preview")!!}</h4>
            </div>
            <div class="">                 
               <div class="row">
                    <div class="col-lg-12">
                        <div class="slider-main">
                            <div class="slides">
                                <div id="owl-demo" class="owl-carousel owl-theme">
                                    <div class="item"><a href="#" id="main_box_a"><img src="{{ URL("/assets/admin/layouts/layout4/img/no-image-main.png" ) }}" id="main_box" alt="No Image" class="advrt_image " width="820" height="450"></a></div>
                                    <!--<div class="item"><img src="{{ URL("/assets/admin/layouts/layout4/img/no-image-main.png" ) }}" alt="No Image" class="advrt_image" width="820" height="450"></div>
                                    <div class="item"><img src="{{ URL("/assets/admin/layouts/layout4/img/no-image-main.png" ) }}" alt="No Image" class="advrt_image" width="820" height="450"></div> -->
                                </div>
                            </div>
                            <div class="small-banner">
                                <a href="#"><img src="{{ URL("/assets/admin/layouts/layout4/img/no-image-main.png" ) }}"  alt="No Image" class="advrt_image" height="143" width="340"></a>
                                <a href="#" id="banner_a"><img src="{{ URL("/assets/admin/layouts/layout4/img/no-image-main.png" ) }}" id="banner" alt="No Image" class="advrt_image" height="143" width="340"></a>
                                <a href="#"><img src="{{ URL("/assets/admin/layouts/layout4/img/no-image-main.png" ) }}" alt="No Image" class="advrt_image" height="143" width="340"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@push('styles')
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/pages/css/slider.css') }}" rel="stylesheet" type="text/css" />
<style>
 ::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.2);
	
	background-color: #F5F5F5;
}

::-webkit-scrollbar
{
	width: 6px;
	background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.2);
	background-color: #555;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/livequery/jquery.livequery.js') }}" type="text/javascript"></script>

<script>
$(document).ready(function() {
    
    inboxsidebarpath=location.protocol + '//' + location.host + location.pathname;    
    $('.adv_menu').each(function() {
            if($(this).find('a[href="'+inboxsidebarpath+'"]').attr('href')){
                $(this).addClass('active');
            }                
    }); 

    $("#owl-demo").owlCarousel({
          navigation : true, // Show next and prev buttons
          slideSpeed : 300,
          paginationSpeed : 400,
          singleItem:true     
    });
      
    $('input:radio[name=type]').change(function(){
            $('.advrt_image').attr('src', '{{ URL("/assets/admin/layouts/layout4/img/no-image-main.png" ) }}');
            $('input[type=file]').val('');
    });
    
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
                $('.advrt_image').attr('src', '{{ URL("/assets/admin/layouts/layout4/img/no-image-main.png" ) }}');
                var type = $('input:radio[name=type]:checked').val();                
                if(type == 'Main_Box')
                {
                    $('#main_box').attr('src', e.target.result);
                    $('#main_box_a').attr('href', $( "#advr_url" ).val());
                }
                else if(type == 'Banner')
                {
                    $('#banner').attr('src', e.target.result);
                    $('#banner_a').attr('href', $( "#advr_url" ).val());
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });
    
    $('#add_to_display').change(function() {
        var selvalue = $( "#add_to_display option:selected" ).val() ;
        if( selvalue == 'category_page' || selvalue == 'subcategory_page')
        {
            $('#catblock').show();
            $('#show_sub_categories').show();
        }
        else
        {
            $('#catblock').hide();
            $('#show_sub_categories').hide();
        }
    });        
    
    $('.parent').livequery('change', function() {
                $(this).closest('.parent_div').nextAll('.parent_div').remove();
                if(this.id == 'cat_id')
                {                    
                    $(this).closest('.parent_div').nextAll('#show_sub_categories').children().remove();                    
                }
                
                $.ajax({
                    url: '{{ route("getdynamicchilddropdown") }}',
                    type: 'GET',
                    data: {cat_id: $(this).val()},
                    success: function (response) {
                        setTimeout("finishAjax('show_sub_categories', '"+escape(response)+"')", 1);
                    }
                });
		
		return false;
	});
        
    $('#val_start_date').change(function() {
       var add_to_display = $( "#add_to_display option:selected" ).val();       
       if( add_to_display == 0 )
       {
           $( "#val_start_date" ).val('');           
           toastr.error('please select Where advertise need to be displayed ?')
       }
       else{
            $.ajax({
                    url: '{{ route("getavailabledate") }}',
                    type: 'GET',
                    data: { start_date: $(this).val() },
                    success: function (response) {
                        setTimeout("finishAjax('show_sub_categories', '"+escape(response)+"')", 1);
                    }
                });
       }
    });
    
});  

function finishAjax(id, response){
    $('#loader').remove();
    $('#'+id).append(unescape(response));
}

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL(this);
});
</script>

<script src="{{ asset('assets/admin/pages/scripts/owl.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
@endpush