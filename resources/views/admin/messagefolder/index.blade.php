@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold">{{trans("message.messagefolder.all_folders")}}</span>
                </div>                
            </div>

            <div class="portlet-body">
                <div class="table-toolbar">
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="attribute-table">
                    <thead>
                        <tr>                            
                            <th></th>
                            <th>Action</th>
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
                <h4 class="modal-title">{{trans("message.messagefolder.delete_folder")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.messagefolder.are_you_sure_delete_folder')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('employee.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAttribute">{{trans('employee.delete')}}</button>
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
            url: '{{ route("messagefolderListing") }}',
        },        
        columns: [            
            {data: 'folder_name', name: 'folder_name','className': 'dt-center',orderable: true, searchable: true,
                    render: function (data, type, full, meta){
                    return '<input type="textbox" class="fld_name_txt" style="display:none;border:none;" name="folder_name" value="' + $('<div/>').text(data).html() + '">'+'<div class="fld">'+data+'</div>';
                   }},
            {data: 'action', name: 'action', orderable: false, searchable: false,className: 'dt-center','width': '10%'}
        ],
        //buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print", "reset", "reload"]
    });
        
    $("#attribute-table").on("click", ".fld", function (e) {
        e.preventDefault(); 
        //  $(this).closest("tr").removeClass("unread");
        $(this).closest('tr').find('.fld_name_txt').show();        
        $(this).hide(); 
        $(this).closest('tr').find('.fld_name_txt').select();        
    });
    
    $("#attribute-table").on("focusout", ".fld_name_txt", function (e) {
        e.preventDefault(); 
        //  $(this).closest("tr").removeClass("unread");
        $(this).closest('tr').find('.fld').show();        
        $(this).closest('tr').find('.fld').html($(this).val());
        $(this).hide();       
        var updateurl = $(this).closest('tr').find('.edit_path').val();   
        
        $.ajax({
                type: "GET",
                url: updateurl,
                data: { folder_name : $(this).val() },
                success: function (r) {
                    if (r.status == "success") {
                        toastr.success(r.msg);
                    } else if (r.status == "error") {
                        toastr.error(r.msg, "{{ trans('message.failure') }}", {timeOut: 10000});                        
                    }
                },
                error: function (data) {
                    if (data.status === 422) {
                        toastr.error("{{ trans('message.failure') }}");
                    }
                },
                async:false
            });
    });

    $("#attribute-table").on("focusout", function (e) {
        $('.fld').show();        
        $('.fld_name_txt').hide();
    });
    
    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

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
   
</script>
@endpush
