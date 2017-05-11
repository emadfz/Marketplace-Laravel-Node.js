@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('countries') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("form.country.index_title")}}</span>
                </div>
                
                {!! getCreateButton() !!}
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="country-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.country.country_code")}}</th  >
                            <th>{{trans("form.country.country_name")}}</th>                            
                            <th>{{trans("form.country.actions")}}</th>                                                        
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
                <h4 class="modal-title">{{trans("message.country.delete_title")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.country.delete_confirmation')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.country.btn_cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCountry">{{trans('message.country.btn_delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>


    var oTable = $('#country-table').DataTable({
        dom: "Bfrtip",
//        dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
//                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
//                "<'row'<'col-md-12'rt>>" +
//                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
        autoWidth: false,
        processing: true,
        serverSide: false,
        data:<?php echo $countries; ?>,
        columns: [
            {data: 'country_code', name: 'country_code', 'width': '40%'},
            {data: 'country_name', name: 'country_name', 'width': '40%'},            
            {data: 'action', name: 'action', orderable: false, searchable: true, 'width': '20%'},
        ],        

        buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print"]
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    //$(document).ready(function () {
    var deleteUrl = '';
    $("#country-table").on("click", ".deleteCountry", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');
        deleteUrl = $(this).data('country_delete_remote');
    });

    $('#confirmDeleteCountry').on('click', function (e) {
        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true},
            success: function (r) {
                if (r.status == "success") {
                    $('#confirmDelete').modal('hide');                     
                    //oTable.draw(true);
                    window.location.reload();
                    toastr.success(r.msg);
                } else if (r.status == "error") {
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
