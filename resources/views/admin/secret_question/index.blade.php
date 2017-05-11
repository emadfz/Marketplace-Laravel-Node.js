@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('secretQuestions') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{trans("form.secret_questions.manage_secret_question")}}</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        {!! getCreateButton() !!}
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="secretquestions-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.secret_questions.secret_question")}}</th>
                            <th>{{trans("form.status")}}</th>
                            <th>{{trans("form.created_at")}}</th>
                            <th>{{trans("form.deleted_at")}}</th>
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
                <h4 class="modal-title">{{trans("form.secret_questions.delete_secret_question")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.secret_questions.are_you_sure_delete_secret_question')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('form.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteSQ">{{trans('form.delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var oTable = $('#secretquestions-table').DataTable({
        //dom: "lfrtip",
        dom: "<'row'<'col-md-12'<'col-md-6'><'col-md-6'f>>>" +
                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
                "<'row'<'col-md-12'rt>>" +
                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
        processing: true,
        serverSide: true,
        sorting:[[1,'asc'],[3,'desc']],
        ajax: {
            //type: 'POST',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("adminSecretQuestionsListing") }}',
        },
        columns: [
            {data: 'secret_question', name: 'secret_questions.secret_question', width: '40%'},
            {data: 'status', name: 'secret_questions.status'},
            {data: 'created_at', name: 'secret_questions.created_at', searchable: false},
            {data: 'deleted_at', name: 'secret_questions.deleted_at', searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ],
        //buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print", "reset", "reload"]
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    //$(document).ready(function () {
    var secretQuestionDeleteUrl = '';
    $("#secretquestions-table").on("click", ".deleteSQ", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');
        secretQuestionDeleteUrl = $(this).data('secretquestion_delete_remote');
    });

    $('#confirmDeleteSQ').on('click', function (e) {
        $.ajax({
            url: secretQuestionDeleteUrl,
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
