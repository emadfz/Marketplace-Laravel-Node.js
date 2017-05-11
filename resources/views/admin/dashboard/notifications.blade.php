@extends('admin.layouts.app')

@section('content')
 <div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Notifications</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="notifications-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.notification.id")}}</th>
                            <th>{{trans("form.notification.text")}}</th>
                            <th>{{trans("form.notification.url")}}</th>
                            <th>{{trans("form.notification.created_at")}}</th>
                            <th>{{trans("form.notification.updated_at")}}</th>
                            
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Dialog -->
 
@endsection

@push('scripts')
<script>
    var oTable = $('#notifications-table').DataTable({
        /*dom: "lfrtip",*/
        dom:    "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
                "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
                "<'row'<'col-md-12'rt>>" +
                "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",
                 buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ],
        processing: true,
        serverSide: true,
        ajax: {
            //type: 'POST',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("notificationsListing") }}',
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'text', name: 'text'},
            {data: 'url', name: 'url'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},


        ],
        //buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print", "reset", "reload"]
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    //$(document).ready(function () {
    var faqTopicDeleteUrl = '';

    //});

</script>

 @endpush
