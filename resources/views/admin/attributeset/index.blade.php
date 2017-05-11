@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('attributeset') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("attributeset.all_attributset")}}</span>
                </div>
                {!! getCreateButton() !!}
            </div>
            
            <div class="portlet-body">
                <div class="table-toolbar">
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="attributeset-table" >
                    <thead>
                        <tr>
                                                    
                            <th>{{trans("attributeset.attribute_set_name")}}</th>
                            <th>{{trans("attributeset.attribute_set_description")}}</th>                            
                            <th>{{trans("attributeset.action")}}</th>
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
                <h4 class="modal-title">{{trans("attributeset.delete_attributeset")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('attributeset.are_you_sure_delete_attributeset')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('attributeset.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAttributeSet">{{trans('attributeset.delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
    .wordwrapcol{
        max-width:120px !important;
        word-wrap: break-word;
    }
</style>
@endpush
@push('scripts')
<script>
    var oTable = $('#attributeset-table').DataTable({
        dom: "Bfrtip lrtip",        
        fixedHeader: true,
        autoWidth: false,
        processing: true,
        serverSide: true,
        "order": [[ 3, "desc" ]],
        ajax: {
            type: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("adminAttributeSetListing") }}',
        },
        columns: [            
            {data: 'attribute_set_name', name: 'attribute_set_name','className': 'dt-center wordwrapcol',width:'30%'},
            {data: 'attribute_set_description', name: 'attribute_set_description',width:'60%',className:'wordwrapcol'},
            {data: 'action', name: 'action', orderable: false, searchable: false,'className': 'dt-center',width:'10%'},
            {data: 'id', name: 'id', visible : false , searchable: false},
        ],
        buttons: [
        {"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print"]
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    //$(document).ready(function () {
    var deleteUrl = '';
    $("#attributeset-table").on("click", ".deleteAttributeSet", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');
        deleteUrl = $(this).data('attributeset_delete_remote');
    });

    $('#confirmDeleteAttributeSet').on('click', function (e) {
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
