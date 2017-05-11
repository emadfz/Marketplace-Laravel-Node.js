@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('contentPages') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{trans("form.content_pages.content_page_listing")}}</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
<!--                        <a href= "{{ route(config('project.admin_route').'content_pages.create') }}" class="btn sbold default">{{ trans("form.content_pages.new_content_page") }} &nbsp;<i class="fa fa-plus"></i></a>-->
                        {!! getCreateButton() !!}
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="contentpage-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.id")}}</th>
                            <th>{{trans("form.content_pages.page_title")}}</th>
                            <th>{{trans("form.content_pages.header_position")}}</th>
                            <th>{{trans("form.content_pages.footer_position")}}</th>
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



<div class="modal" id="large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
           <div class="modal-inner clearfix">
                <a href="#"  onclick="hide_preview()" class="close" data-dismiss="modal" aria-hidden="true"></a>
                <h6 class="modal-title">{!!trans("message.preview")!!}</h6>
              <div class="clearfix">
                  <div class="slides-outer">
                    <a href="#" id="main_box_a"><img src="{{ URL("/assets/front/img/no-image-main.png" ) }}" id="main_box" alt="No Image" class="advrt_image " width="820" height="450"></a>
                  </div>
                <div class="small-banner">
                    <a href="#"><img src="{{ URL("/assets/front/img/small-noimage.png" ) }}"  alt="No Image" class="advrt_image" height="143" width="340"></a>
                    <a href="#" id="banner_a"><img src="{{ URL("/assets/front/img/small-noimage.png" ) }}" id="banner" alt="No Image" class="advrt_image" height="143" width="340"></a>
                    <a href="#"><img src="{{ URL("/assets/front/img/small-noimage.png" ) }}" alt="No Image" class="advrt_image" height="143" width="340"></a>
                </div>
              </div>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{trans("form.content_pages.delete_content_page")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.content_page.are_you_sure_delete_content_page')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('form.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteContentPage">{{trans('form.delete')}}</button>
            </div>
        </div>
    </div>
</div>

   <div class="modal" id="advertisement_detail_modal" tabindex="-1">
        <div class="modal-dialog modal-m" role="document">
            <div class="modal-content">
                <div class="modal-inner clearfix">
                    <a href="#" class="close" data-dismiss="modal">close</a>                    
                            <div class="modal-body">
                                
                            </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$( "body" ).delegate( ".advertisement", "click", function(ev) {
 
        ev.preventDefault();
        var target = $(this).attr("href");
        var modalId = $(this).data("target");
        
        $(modalId+" .modal-body").html('<h3><img src="'+assetsPath+'assets/front/img/loading-spinner-grey.gif" /> Please Wait...</h3>');
        // load the url and show modal on success
        $(modalId+" .modal-body").load(target, function() { 
             $(modalId).modal("show"); 
             //$.unblockUI();
        });
    });

    var oTable = $('#contentpage-table').DataTable({
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
            url: '{{ route("adminContentPagesListing") }}',
        },
        columns: [
            {data: 'id', name: 'content_pages.id', visible: false},
            {data: 'page_title', name: 'content_pages.page_title', width: '25%'},
            {data: 'header_position', name: 'header_position', searchable: false},
            {data: 'footer_position', name: 'footer_position', searchable: false},
            {data: 'status', name: 'content_pages.status'},
            {data: 'created_at', name: 'content_pages.created_at', searchable: false},
            {data: 'updated_at', name: 'content_pages.updated_at', searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ],
        //buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print", "reset", "reload"]
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    //$(document).ready(function () {
    var contentPageDeleteUrl = '';
    $("#contentpage-table").on("click", ".deleteContentPage", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');
        contentPageDeleteUrl = $(this).data('contentpage_delete_remote');
    });

    $('#confirmDeleteContentPage').on('click', function (e) {
        $.ajax({
            url: contentPageDeleteUrl,
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
