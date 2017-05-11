@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('forums') !!}

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> </span>
                </div>
                <div class="actions">
                    <div class="btn-group">
       {{--                  <a href= "{{ route(config('project.admin_route').'departments.index') }}" class="btn sbold default">{{ trans("form.topic_departments.all_departments") }} &nbsp;<i class="fa fa-list-alt"></i></a>
                        <a href= "{{ route(config('project.admin_route').'forums.create') }}" class="btn sbold default">{{ trans("form.forums.new_forum") }} &nbsp;<i class="fa fa-plus"></i></a> --}}
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
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="categories-table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>report_value</th>
                            <th>something_else</th>
                            <th>created_at</th>
                            
                            
                         
                           
                        </tr>
                    </thead>


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

@push('scripts')
<script>
    var oTable = $('#categories-table').DataTable({
        //dom: "lfprtip",
        dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
                "<'row'<'col-md-12'rt>>" +
                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
        processing: true,
        serverSide: true,
        ajax: {
            //type: 'POST',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("admin.ForumsCommentReportsDatatable", ['id'=>$id, 'comment'=>$comment]) }}',
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'report_value', name: 'report_value'},
            {data: 'something_else', name: 'something_else'},
            {data: 'created_at', name: 'created_at'} 
 

        ],
        //buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print", "reset", "reload"]
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    //$(document).ready(function () {
    var categorydeleteUrl = '';
    $("#categories-table").on("click", ".deleteCategory", function (e) {
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

</script>
@endpush
