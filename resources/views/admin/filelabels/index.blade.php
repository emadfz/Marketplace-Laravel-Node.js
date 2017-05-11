@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('labels') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                
                
                <div style="width: 100% !important;" class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">{{trans("form.file_labels.all_labels")}}</span>
                                                
                </div>
                    <div class="tabbable tabbable-tabdrop">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="{{ route(config('project.admin_route').'labels.index') }}">Manage Labels</a>
                                            </li>
                                            <li>
                                                <a href="{{ route(config('project.admin_route').'fileuploads.index') }}">Manage Files</a>
                                            </li>
                                        </ul>
                    </div>
                </div>
                <div class="actions ">
                    <div class="btn-group  pull-right">
                        <a href= "{{ route(config('project.admin_route').'labels.create') }}" class="btn sbold default">{{ trans("form.file_labels.new_label") }} &nbsp;<i class="fa fa-plus"></i></a>
                    </div>
                </div>
            
            <div class="portlet-body">
                <div class="table-toolbar">

                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="categories-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.file_labels.id")}}</th>
                            <th>{{trans("form.file_labels.label_name")}}</th>
                            <th>{{trans("form.file_labels.label_description")}}</th>
                            <th>{{trans("form.file_labels.created_at")}}</th>
                            <th>{{trans("form.file_labels.action")}}</th>
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
                <h4 class="modal-title">{{trans("form.file_labels.delete_label")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.file_labels.are_you_sure_delete_label')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('departments.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCategory">{{trans('departments.delete')}}</button>
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
            url: '{{ route("adminLabelsListing") }}',
        },
        columns: [
            {data: 'id', name: 'file_labels.id'},
            {data: 'label_name', name: 'file_labels.label_name'},
            {data: 'label_description', name: 'file_labels.label_description'},
            {data: 'created_at', name: 'file_labels.created_at'},
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
