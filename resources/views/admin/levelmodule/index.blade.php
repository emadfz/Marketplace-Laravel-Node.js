@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("levelmodule.set_access_level")}}</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a href= "{{ route(config('project.admin_route').'levelmodule.create') }}" class="btn sbold default">{{ trans("attribute_1.new_level") }} &nbsp;<i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="attribute-table">
                    <thead>
                        <tr>                             
                            <th>{{trans("attribute.attribute_name")}}</th>
                            <th>{{trans("attribute.view_in_filter")}}</th>
                            <th>{{trans("attribute.comparable")}}</th>
                            <th>{{trans("attribute.action")}}</th>
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
                <h4 class="modal-title">{{trans("attribute.delete_attribute")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('attribute.are_you_sure_delete_attribute')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('attribute.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAttribute">{{trans('attribute.delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var oTable = $('#attribute-table').DataTable({
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
            url: '{{ route("adminAttributeListing") }}',
        },
        columns: [            
            {data: 'attribute_name', name: 'attribute_name','width': '50%'},
            {data: 'view_in_filter', name: 'view_in_filter','width': '20%','className': 'dt-center'},
            {data: 'comparable', name: 'comparable','width': '20%','className': 'dt-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false,'width': '10%'}

        ],
        //buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print", "reset", "reload"]
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    //$(document).ready(function () {
    var deleteUrl = '';
    $("#attribute-table").on("click", ".deleteAttribute", function (e) {
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
    //});

</script>
@endpush
