@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('donationvendors') !!}
<a href="#" class="btn btn-danger" onclick="pdf()">PDF</a>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{trans("form.donation_vendors.all_vendors")}}</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                       <li> <a href= "{{ route(config('project.admin_route').'donationvendors.create') }}" class="btn sbold default">{{ trans("form.donation_vendors.new_vendor") }} &nbsp;<i class="fa fa-plus"></i></a></li>
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-xs-4 form-inline">
                            {!! Form::label('newsletter_content', trans("form.newsletters.newsletter_date"), ['class' => 'control-label']) !!}
                            <div class="input-daterange input-group date-picker" id="datepicker" data-date-format="yyyy-mm-dd">
                                <input type="text" class="input-sm form-control" name="fromDate" value="" placeholder="{{ trans("form.from_date") }}"/>
                                <span class="input-group-addon">to</span>
                                <input type="text" class="input-sm form-control" name="toDate" value="" placeholder="{{ trans("form.to_date") }}"/>
                            </div>
                            <button type="button" id="filterDateSearch" class="btn btn-sm btn-default">{{ trans("form.search") }}</button>
                        </div>
                    </div>
                </div>
                <table class="pdf-selector table table-striped table-bordered table-hover table-checkable order-column" id="categories-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.donation_vendors.id")}}</th>
                            <th>{{trans("form.donation_vendors.vendor_name")}}</th>
                            <th>{{trans("form.donation_vendors.start_date")}}</th>
                            <th>{{trans("form.donation_vendors.end_date")}}</th> 
                            <th>{{trans("form.donation_vendors.website_link")}}</th>                             
                            <th>{{trans("form.donation_vendors.status")}}</th>                             	
                            <th>{{trans("form.donation_vendors.admin_fees")}}</th>                             	
                            <th>{{trans("form.donation_vendors.action")}}</th>
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
                <h4 class="modal-title">{{trans("form.donation_vendors.delete_vendor")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.donation_vendors.are_you_sure_delete_vendor')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('departments.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCategory">{{trans('departments.delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    .portlet.light .dataTables_wrapper .dt-buttons{ margin: 0 0 0 10px !important;}
    
</style>

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>

<script>
    $('#filterDateSearch').on('click', function () {
    oTable.draw();
});
    var oTable = $('#categories-table').DataTable({
        //dom: "lfprtip",
        dom: "Bfrtip",
        processing: true,
        serverSide: true,
        ajax: {
            //type: 'POST',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("adminDonationVendorListing") }}',
            data: function (d) {
            d.fromDate = $('input[name=fromDate]').val();
            d.toDate = $('input[name=toDate]').val();
        }
        },
        columns: [
            {data: 'id', name: 'donation_vendors.id'},
            {data: 'vendor_name', name: 'donation_vendors.vendor_name'},
            {data: 'start_date', name: 'donation_vendors.start_date'},
            {data: 'end_date', name: 'donation_vendors.end_date'},
            {data: 'website_link', name: 'donation_vendors.website_link'},
            {data: 'status', name: 'donation_vendors.status'},
            {data: 'admin_fees', name: 'donation_vendors.admin_fees'},
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
 
    function pdf()
    {
        
        var divContent = $('.pdf-selector').html();
        // console.log(divContent);
        $.ajax({
            type: "POST",
            url: {{route('file.pdf')}},
            data: {divContent: divContent},
            success: function( msg ) {
               console.log(msg);
            }
        });
    }
 
</script>
@endpush
