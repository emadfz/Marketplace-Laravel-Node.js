@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('fileuploads') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div style="width: 100% !important;" class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">{{trans("form.file_uploads.all_file_storage")}}</span>
                                                
                </div>
                    <div class="tabbable tabbable-tabdrop">
                                        <ul class="nav nav-tabs">
                                            <li >
                                                <a href="{{ route(config('project.admin_route').'labels.index') }}">Manage Labels</a>
                                            </li>
                                            <li class="active">
                                                <a href="{{ route(config('project.admin_route').'fileuploads.create') }}">Manage Files</a>
                                            </li>
                                        </ul>
                    </div>
                    <div class="tabbable tabbable-tabdrop filedescription">
                    <select onchange="getsearch(this);" id="searchval" class="form-control">
                    <option value="">
                    <a href= "javascript:getsearch('');" class="btn sbold default">All</i></a>                            
                     </option>
                    
                    @foreach($label['all_labels'] as $id=>$labelname)
                        <option value="{!! $labelname !!}">
                            <a href= "javascript:getsearch('{!! $labelname !!}');" class="btn sbold default">{!! $labelname !!}</i></a>                            
                        </option>
                    @endforeach  
                    </select>
                       <a href= "{{ route(config('project.admin_route').'fileuploads.create') }}" class="btn sbold default">Upload File</a>
                    </div>   
            </div>
            

            <div class="portlet-body">
                <div class="table-toolbar">
                </div>

                <table class="table table-striped table-bordered table-hover table-checkable order-column table-scrollable" id="categories-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.file_uploads.id")}}</th>
                            <th>{{trans("form.file_uploads.file_name")}}</th>      
                            <th>{{trans("form.file_labels.label_name")}}</th>
                            <th>{{trans("form.file_uploads.file_preview")}}</th>
                            <th>{{trans("form.file_uploads.category")}}</th>
                            <th>{{trans("form.forums.action")}}</th>
                        </tr>
                    </thead>


                </table>

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
                <h4 class="modal-title">{{trans("form.file_uploads.delete_file")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.file_uploads.are_you_sure_delete_file')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('form.forums.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCategory">{{trans('form.forums.delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    .portlet.light .dataTables_wrapper .dt-buttons{ margin: 0 0 0 10px !important;}
    .filedescription{ float: right; margin-bottom: 10px;}
    .filedescription select{ width:180px; float: left;}
    .filedescription .btn{ margin-left: 10px;}
</style>
@push('scripts')
<script>
    var oTable = $('#categories-table').DataTable({
        dom: "Bfrtip",
//        dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
//                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
//                "<'row'<'col-md-12'rt>>" +
//                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
        processing: true,
        serverSide: true,
        ajax: {
            //type: 'POST',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("admin.fileuploads.datatableList") }}',
        },
        columns: [
            {data: 'id', name: 'file_uploads.id'},
            {data: 'file_name', name: 'file_uploads.file_name'},
            {data: 'file_labels.label_name', name: 'file_labels.label_name'},
            {data: 'file_preview', name: 'file_uploads.file_preview',  searchable: false},            
            {data: 'categories.text', name: 'categories.text'},
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ],
        buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print"]
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
function getsearch(text){
    text=$("#searchval").val();
    oTable
        .columns( 2 )
        .search( text )
        .draw();
}

</script>
@endpush
