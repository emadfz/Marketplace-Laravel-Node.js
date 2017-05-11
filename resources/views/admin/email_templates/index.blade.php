@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('emailTemplates') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{trans("form.email_templates.manage_email_templates")}}</span>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="email-templates-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.id")}}</th>
                            <th>{{trans("form.email_templates.template_title")}}</th>
                            <th>{{trans("form.email_templates.template_key")}}</th>
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
<!--<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
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
</div>-->
@endsection

@push('scripts')
<script>
    var oTable = $('#email-templates-table').DataTable({
        //dom: "lfprtip",
        dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
                "<'row'<'col-md-12'rt>>" +
                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
        processing: true,
        serverSide: true,
        sorting: [[0, 'desc']],
        ajax: {
            //type: 'POST',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("emailTemplatesDatatableList") }}'
        },
        columns: [
            {data: 'id', name: 'email_templates.id'},
            {data: 'template_title', name: 'email_templates.template_title'},
            {data: 'template_key', name: 'email_templates.template_key'},
            {data: 'created_at', name: 'email_templates.created_at', searchable: false},
            {data: 'updated_at', name: 'email_templates.updated_at', searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    /*var newsletterDeleteUrl = '';
    $("#email-templates-table").on("click", ".deleteNewsletter", function (e) {
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
    });*/
</script>
@endpush
