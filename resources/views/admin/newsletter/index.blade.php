@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('newsletters') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{trans("form.newsletters.manage_newsletter")}}</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        {!! getCreateButton() !!}
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
                            <button id="filterDateReset" class="btn btn-sm red btn-outline filter-cancel"><i class="fa fa-times"></i> Reset</button>
                            
                        </div>
                        
                    </div>
                </div>


                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="newsletter-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.id")}}</th>
                            <th>{{trans("form.newsletters.newsletter_title")}}</th>
                            <th>{{trans("form.newsletters.newsletter_date")}}</th>
                            <th>{{trans("form.status")}}</th>
                            <th>{{trans("form.created_at")}}</th>
                            <th>{{trans("form.updated_at")}}</th>
                            <th>{{trans("form.action")}}</th>
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
                <h4 class="modal-title">{{trans("form.newsletters.delete_newsletter")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.newsletters.are_you_sure_delete_newsletter')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('form.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteNewsletter">{{trans('form.delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script>
$('#filterDateSearch').on('click', function () {
    oTable.draw();
});

var oTable = $('#newsletter-table').DataTable({
    //dom: "lfprtip",
    dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
            "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
            "<'row'<'col-md-12'rt>>" +
            "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
    processing: true,
    serverSide: true,
    sorting:[[0,'desc']],
    ajax: {
        //type: 'POST',
        method: 'POST',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
        },
        url: '{{ route("adminNewslettersListing") }}',
        data: function (d) {
            d.fromDate = $('input[name=fromDate]').val();
            d.toDate = $('input[name=toDate]').val();
        }
    },
    columns: [
        {data: 'id', name: 'newsletters.id'},
        {data: 'newsletter_title', name: 'newsletters.newsletter_title'},
        {data: 'newsletter_date', name: 'newsletters.newsletter_date'},
        {data: 'status', name: 'newsletters.status'},
        {data: 'created_at', name: 'newsletters.created_at', searchable: false},
        {data: 'updated_at', name: 'newsletters.updated_at', searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ],
    //buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print", "reset", "reload"]
});

$('#filterDateReset').on('click',function(e){
    $('input[name="fromDate"]').val('');
    $('input[name="toDate"]').val('');
    
    oTable.draw();
    e.preventDefault();
});



$('#search-form').on('submit', function (e) {
    oTable.draw();
    e.preventDefault();
});

var newsletterDeleteUrl = '';
$("#newsletter-table").on("click", ".deleteNewsletter", function (e) {
    e.preventDefault();
    $('#confirmDelete').modal('show');
    newsletterDeleteUrl = $(this).data('newsletter_delete_remote');
});

$('#confirmDeleteNewsletter').on('click', function (e) {
    $.ajax({
        url: newsletterDeleteUrl,
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
</script>
@endpush
