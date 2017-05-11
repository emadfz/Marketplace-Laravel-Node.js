@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('forums') !!}

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{trans("form.forums.all_forums")}}</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a href= "{{ route(config('project.admin_route').'departments.index') }}" class="btn sbold default">{{ trans("form.topic_departments.all_departments") }} &nbsp;<i class="fa fa-list-alt"></i></a>
                        <a href= "{{ route(config('project.admin_route').'forums.create') }}" class="btn sbold default">{{ trans("form.forums.new_forum") }} &nbsp;<i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
<!--                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <button class="btn blue btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-print"></i> Print </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>-->
                </div>
                <div class="table-scrollable">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="forum-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.forums.id")}}</th>
                            <th>{{trans("form.forums.topic_name")}}</th>
                            <th>{{trans("form.forums.department")}}</th>
                            <th>{{trans("form.forums.posted_date")}}</th>
                            <th>{{trans("form.forums.status")}}</th>
                            <th>{{trans("form.forums.report_abuse")}}</th>
                            <th>{{trans("form.forums.total_likes")}}</th>   
                            <th>{{trans("form.forums.total_dislikes")}}</th>   
                            <th>{{trans("form.forums.comments")}}</th>   
                            <th>{{trans("form.forums.views")}}</th>   
                            <th>{{trans("form.forums.last_activity_date")}}</th>
                            <th>{{trans("form.forums.action")}}</th>
                        </tr>
                    </thead>
 <tbody>
                    <br/>
                    <div class="actions">
                      <div class="btn-group  pull-right">
                                <label>Topics Type : </label><br/>
                                {!! Form::select('topics_type', ['all'=>'All','popular'=>'Popular','featured'=>'Featured'] ,['all'], ['class' => 'form-control','tabindex' => '25']) !!}
                      </div>
                    </div>
                    <div class='col-md-4' id="date_range_div"> 
                            
                        
                            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd"  style="width : 100% !important;">
                                {!! Form::text('filter_from', null , ['class' => 'form-control','tabindex' => '25','placeholder'=>'From','style'=>'float:right;','readonly']) !!}
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>                                                
                            
                            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd"  style="width : 100% !important;">
                                    {!! Form::text('filter_to', null , ['class' => 'form-control','tabindex' => '25','placeholder'=>'To','style'=>'float:right;','readonly']) !!}
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>                                    
                            </div>
                            <br/>                               
                            <button id='search_daterange' class="btn">    
                                Search
                            </button>
                            <button id='reset_daterange' class="btn">    
                                Reset
                            </button>
                            
                    </div>
                    
                    </tbody>

                </table>
                </div>    
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
                <h4 class="modal-title">{{trans("form.forums.delete_topic")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.forums.are_you_sure_delete_topic')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('form.forums.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCategory">{{trans('form.forums.delete_topic')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles') 
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

@endpush
@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>        
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script>
    var oTable = $('#forum-table').DataTable({
        //dom: "lfprtip",
        dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
                "<'row'<'col-md-12'rt>>" +
                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
        processing: true,
        serverSide: true,
        lengthMenu: [[10,20, 25, 50, -1], [10,20, 25, 50, "All"]],
        ajax: {
            //type: 'POST',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("adminForumsListing") }}',
            data:  function ( d ) {                
                d.filter_from = $('input[name="filter_from"]').val();
                d.filter_to = $('input[name="filter_to"]').val();
                d.topics_type = $('select[name="topics_type"]').val();
            },
        },
        columns: [
            {data: 'id', name: 'forums.id'},
            {data: 'topic_name', name: 'forums.topic_name'},
            {data: 'employee_departments.department_name', name: 'employee_departments.department_name'},
            {data: 'created_at', name: 'forums.created_at'},
            {data: 'status', name: 'forums.status'},
            {data: 'report_abuse', name: 'report_abuse', orderable: false, searchable: false},
            {data: 'total_likes', name: 'forums.total_likes'},
            {data: 'total_dislikes', name: 'forums.total_dislikes'},
            {data: 'total_comments', name: 'forums.total_comments'},
            {data: 'total_views', name: 'forums.total_views'},
            {data: 'updated_at', name: 'forums.updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ],
        //buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print", "reset", "reload"]
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    //$(document).ready(function () {
    var categorydeleteUrl = '';
    $("#forum-table").on("click", ".deleteCategory", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');
        categorydeleteUrl = $(this).data('category_delete_remote');
    });

    $('#confirmDeleteCategory').on('click', function (e) {
        $.ajax({
            url: categorydeleteUrl,
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
    //});


$('#search_daterange').click(function(){   
    $('#forum-table').DataTable().draw();
});

$('select[name="topics_type"]').change(function(){    
    if($(this).val()=='popular'){
        $('select[name="forum-table_length"]').val('20').trigger('change');
    }
    else{
        $('select[name="forum-table_length"]').val('10').trigger('change');
    }
    
    $('#forum-table').DataTable().draw();
});   

$('#reset_daterange').click(function(){
    $('input[name="filter_from"]').val('');
    $('input[name="filter_to"]').val('');    
    $('#search_daterange').trigger('click');
});

</script>
@endpush
