@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('products') !!}
<div class="row">
    <div class="col-md-12">

        <div class="portlet light bordered">

            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{trans("form.all_products")}}</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a href= "{{ route(config('project.admin_route').'products.create') }}" class="btn sbold default">{{ trans("form.new_product") }} &nbsp;<i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <div class="table-toolbar margin-bottom-10">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="POST" id="search-form" class="form-inline" role="form">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="search name">
                                </div>&nbsp;&nbsp;
                                <div class="form-group">
                                    <label for="manufacturer">Manufacturer</label>
                                    <input type="text" class="form-control" name="manufacturer" id="manufacturer" placeholder="search manufacturer">
                                </div>

                                <button type="submit" class="btn btn-default">Search</button>
                            </form>
                        </div>
                    </div>
                </div>


                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="products-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Category Title</th>
                            <th>Description</th>
                            <th>Manufacturer</th>
                            <th>Price</th>
                            <th>Return Applicable</th>
                            <th>Warranty Application</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{trans("message.products.delete_title")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.products.delete_confirmation')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('message.products.btn_cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteProducts">{{trans('message.products.btn_delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var oTable = $('#products-table').DataTable({
        dom: "lprtip",
        /*dom: "<'row'<'col-md-12'<'col-md-6'><'col-md-6'>>>" +
         "<'row'<'col-md-12'<'col-md-6'l><'col-md-6'p>>>" +
         "<'row'<'col-md-12'rt>>" +
         "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'p>>>",*/
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            type: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            
            url: "{{route(config('project.admin_route').'products.datatableList')}}",
            data: function (d) {
                d.name = $('input[name=name]').val();
                d.manufacturer = $('input[name=manufacturer]').val();
            }
        },
        columns: [            
            {data: 'id', name: 'id', searchable: false},
            {data: 'name', name: 'name'},
            {data: 'categories.text', name: 'text', searchable: true},
            {data: 'description', name: 'description', searchable: false},
            {data: 'manufacturer', name: 'manufacturer'},
            {data: 'price', name: 'price'},
            {data: 'is_return_applicable', name: 'is_return_applicable'},
            {data: 'is_warranty_applicable', name: 'is_warranty_applicable'},
            {data: 'status', name: 'status', searchable: true},
            {data: 'created_at', name: 'created_at', searchable: true},
            {data: 'updated_at', name: 'updated_at', "orderable": false, searchable: true},
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ],
        //buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print", "reset", "reload"]
    });

    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });
    
     var deleteUrl = '';
    $("#products-table").on("click", ".deleteProducts", function (e) {        
        e.preventDefault();
        $('#confirmDelete').modal('show');
        deleteUrl = $(this).data('products_delete_remote');
    });

    $('#confirmDeleteProducts').on('click', function (e) {
        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true},
            success: function (r) {
                if (r.status == "success") {
                    $('#confirmDelete').modal('hide');                     
                    oTable.draw(false);
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
</script>
@endpush