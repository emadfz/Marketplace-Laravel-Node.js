@extends('admin.layouts.app')
@section('content')

<div class="row">    
    <div class="col-md-12">
                       
        
        <div class="portlet light bordered">      
            <div class="portlet-title" >
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>                    
                        <span class="caption-subject">Advertisements List</span>                                         
                    </div> 
            </div> 
            @include('admin.advertisements.advertisetab')

            <div class="portlet-body">
                <!-- BEGIN FORM-->
{!! Form::open(['route' => 'admin.advertisements.store', 'class' => 'form-horizontal ajax','id'=>'postadv', 'files' => true])!!}
<div  class="form-body">
    <div class="caption">
        <i class="icon-equalizer font-blue"></i>
        <span class="caption-subject font-blue bold">{!!trans('message.advertisements.advertisement')!!}</span>        
    </div>
    <hr>
    <div class="form-group {{ $errors->has('add_to_display') ? 'has-error' : ''}} required">
        {!! Form::label('add_to_display', trans('message.advertisements.where_to_display_add'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::select('add_to_display', array('0'=>'Select to display','home_page' => 'Home Page','category_page' => 'Category Page','subcategory_page' => 'Sub-Category Page','mingle_page'=>'Mingle Page'), null , ['class' => 'form-control','tabindex' => '1']) !!}
            {!! $errors->first('add_to_display', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('cat_id') ? 'has-error' : ''}} required">
        {!! Form::label('cat_id', trans('message.advertisements.select_cat'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::select('cat_id', array('0' => 'Select Category')+$input['all_categories'], null , ['class' => 'form-control','tabindex' => '1']) !!}
            {!! $errors->first('cat_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('adv_type') ? 'has-error' : ''}} required">
        {!! Form::label('adv_type', trans('message.advertisements.adv_type'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            <div style="float:left;width:50%;">
                <label>
                    {!! Form::radio('adv_type', 'banner', 'banner' ,['class' => 'form-control','style' => 'width : 18% !important;float:left;','tabindex' => '4']) !!}
                    <div style="float: left;margin-top: 12%;margin-left: 5px;">{!!trans('message.advertisements.banner_type')!!}</div>
                </label>
            </div>
            <div style="float:left;width:50%;">
                <label>
                    {!! Form::radio('adv_type', 'main', 'main',['class' => 'form-control','style' => 'width : 18% !important;float:left;','tabindex' => '4']) !!}
                    <div style="float: left;margin-top: 12%;margin-left: 5px;">{!!trans('message.advertisements.main_type')!!}</div>
                </label>
            </div>
            {!! $errors->first('adv_type', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}} required">
        {!! Form::label('start_date', trans('message.advertisements.start_date'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" style="width : 100% !important;">
                    {!! Form::text('start_date', null, ['class' => 'form-control','tabindex' => '5']) !!}
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
            {!! Form::text('available_days', null, ['class' => 'form-control','style'=>'border:none;','tabindex' => '6']) !!}
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
            {!! Form::text('advr_name', null, ['class' => 'form-control','tabindex' => '3']) !!}
            {!! $errors->first('advr_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('advr_url') ? 'has-error' : ''}} required">
        {!! Form::label('advr_url', trans('message.advertisements.advr_url'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('advr_url', null, ['class' => 'form-control','tabindex' => '3']) !!}
            {!! $errors->first('advr_url', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('upload_image') ? 'has-error' : ''}}">
        {!! Form::label('upload_image', trans('message.advertisements.upload_image'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::file('upload_image[]', null, ['class' => 'form-control','tabindex' => '3','id'=>'upload_image']) !!}
            {!! $errors->first('upload_image', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <!--<div class="form-group {{ $errors->has('upload_image') ? 'has-error' : ''}}">
        
        <div class="col-sm-3">
            <img src="" id="image_preview" height='100' width='100'/> 
        </div>
    </div> -->
    
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
            </div>
        </div>
    </div>
</div>

<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{trans("message.messagefolder.delete_folder")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.messagefolder.are_you_sure_delete_folder')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('employee.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAttribute">{{trans('employee.delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')

@endpush

@push('scripts')
<script>
    $(document).ready(function () {
    var oTable = $('#advertise-table').DataTable({
        //dom: "lfprtip",
        dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
                "<'row'<'col-md-12'rt>>" +
                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: {
            type: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("pendingadvadvertisementListing") }}',
        }, 
        columns: [
            {data: 'adv_type', name: 'adv_type', width : '10%', orderable : false ,searchable: false ,className: 'dt-center'},            
            {data: 'status', name: 'status', orderable: false, searchable: true, 'width': '10%',className: 'dt-center',
            render: function (data, type, full, meta){                    
                    if(data == 1){ 
                        return '<span class="label label-sm label-success">Approved</span>'; 
                    }
                    else { 
                        if(data == -1)
                        {
                            return '<span class="label label-sm label-danger">Rejected</span>'; 
                        }
                        else
                        {
                            return '<span class="label label-sm label-info">Pending</span>';
                        }
                    }}},
            {data: 'location', name: 'location', width : '15%', orderable : false ,searchable: false ,className: 'dt-center'},
            {data: 'advr_name', name: 'advr_name', orderable: false, searchable: true, 'width': '20%',className: 'dt-center'},            
            {data: 'start_date', name: 'start_date', width : '15%', orderable : false ,searchable: false ,className: 'dt-center'},
            {data: 'end_date', name: 'end_date', width : '15%', orderable : false ,searchable: false ,className: 'dt-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false,className: 'dt-center','width': '5%'}
        ],
    });
    
    inboxsidebarpath=location.protocol + '//' + location.host + location.pathname;    
    $('.adv_menu').each(function() {
            if($(this).find('a[href="'+inboxsidebarpath+'"]').attr('href')){
                $(this).addClass('active');
            }                
    }); 
    
    var deleteUrl = '';
    $("#advertise-table").on("click", ".deleteAttribute", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');        
        deleteUrl = $(this).data('attribute_delete_remote');
    });

    $('#confirmDeleteAttribute').on('click', function (e) {        
        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true},
            success: function (r) {
                if (r.success == 1) {
                    $('#confirmDelete').modal('hide');
                    oTable.draw(false);
                    toastr.success(r.msg);
                } else if (r.success == 0) {
                    toastr.error(r.msg, "{{ trans('message.failure') }}", {timeOut: 10000});
                    $('#confirmDelete').modal('hide');
                }
            },
            error: function (data) {
                if (data.status === 422) {
                    toastr.error("{{ trans('message.failure') }}");
                }
            }
        });
    });
});
</script>

<script src="{{ asset('assets/admin/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
@endpush
