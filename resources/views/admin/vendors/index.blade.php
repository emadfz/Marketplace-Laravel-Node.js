@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('vendors') !!}

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{trans("form.vendors.manage_vendors")}}</span>
                </div>
                <div class="actions">
                    
                </div>
            </div>
            <br>

                
            <ul class="nav nav-tabs">
                        @foreach($vendor_types['all_vendor_types'] as $id=>$vendor_type_name)
                        <li class="active">
                            <a href= "javascript:getvendor('{!! $id !!}');" class="btn sbold default">{!! $vendor_type_name !!}</i></a>                            
                        </li>    
                        @endforeach 
            </ul>            

            <ul class="btn-group1 nav nav-tabs">
            
            </ul> 
            
            
            
            
<div class="row accinfo">
                                            <div class="col-md-6">
                                                <h3>Account Number</h3>
                                                <div class="well">
                                                    <address>
                                                        <strong>Loop, Inc.</strong>
                                                        <br> 795 Park Ave, Suite 120
                                                        <br> San Francisco, CA 94107
                                                        <br>
                                                        <abbr title="Phone">P:</abbr> <a href="tel:(234) 145-1810">(234) 145-1810</a> </address>
                                                    <address>
                                                        <strong>Full Name</strong>
                                                        <br>
                                                        <a href="mailto:#"> first.last@email.com </a>
                                                    </address>
                                                </div>
                                            </div>
                                            
</div>            
            <div class="portlet-body">
                <div class="table-toolbar">
<!--                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <button class="btn blue btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-print"></i> Print </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>-->
                </div>
                <div class="table-toolbar">
                </div>
                <div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="categories-table">
                    <thead>
                        <tr>
                            <th>{{trans("form.transactions.id")}}</th>
                            <th>{{trans("form.transactions.transaction_id")}}</th>
                            <th>{{trans("form.transactions.created_at")}}</th>
                            <th>{{trans("form.transactions.amount_received")}}</th>
                            <th>{{trans("form.transactions.amount_paid")}}</th>
                            <th>{{trans("form.transactions.transaction_date")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                              
                    <div class='col-md-8' id="date_range_div" style="display:none"> 
                        
                            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd"  style="width : 100% !important;">
                                {!! Form::text('filter_from', null , ['class' => 'form-control','tabindex' => '25','placeholder'=>'From','style'=>'float:right;','readonly']) !!}
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>                                                
                            
                            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd"  style="width : 100% !important;">
                                    {!! Form::text('filter_to', null , ['class' => 'form-control','tabindex' => '25','placeholder'=>'To','style'=>'float:right;','readonly']) !!}
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>                                    
                                </div>
                                <button id='search_daterange' class="btn">    
                                    Search
                                </button>
                                <button id='reset_daterange' class="btn">    
                                    Reset
                                </button>
                            
                    </div>
                    
                    </tbody>

                </table>
                </div>    
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
                <h4 class="modal-title">{{trans("form.forums.delete_topic")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.forums.are_you_sure_delete_topic')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('form.forums.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCategory">{{trans('form.forums.delete')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles') 
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

@endpush
@push('scripts')
<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>

<script src="{{ asset('assets/admin/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>        
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>

<script>
    
    window.from = '';
    window.to = '';
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
function getvendor(vendor_types_id){

        $.get('{{ url('information') }}/getvendors/ajax-state?vendor_types_id=' + vendor_types_id, function(data) {            
            $('.btn-group1').empty();
            $.each(data, function(index,subCatObj){ 
                $('.btn-group1').append('<li><a href="javascript: getaccountinfo('+subCatObj.id+');" data-id='+subCatObj.id+' class="btn sbold default">'+subCatObj.vendor_name+'</i></a></li>');
            });
            
                $('.btn-group1').append('<li><a href="{{route(config('project.admin_route').'transactions.create')}}/'+vendor_types_id+'" class="btn sbold default">Add New Transaction &nbsp;<i class="fa fa-plus"></i></a></li>');
                $('.btn-group1').append('<li><a href="{{route(config('project.admin_route').'vendors.create')}}" class="btn sbold default">Add New Vendor &nbsp;<i class="fa fa-plus"></i></a></li>');
        });
     
}
function getaccountinfo(id){
        $('#date_range_div').show();
        $.get('{{ url('information') }}/getvendorsacccount/ajax-state?id=' + id, function(data) {            
            $('.accinfo').empty();
            $.each(data, function(index,subCatObj){ 
            $('.accinfo').append('<div class="col-md-6"><h3>Account Number : '+subCatObj.account_number+'</h3><div class="well"><address><strong>'+subCatObj.vendor_name+'</strong><br> '+subCatObj.contact_person+'<br> '+subCatObj.address_line1+', '+subCatObj.zipcode+'<br><abbr title="Phone">Tel:</abbr> <a href="tel:'+subCatObj.contact_number+'">'+subCatObj.contact_number+'</a> <a id="SkypeButton_Call_Inspree_1"></a></address><address><strong>Full Name</strong><br><a href="mailto:'+subCatObj.contact_email+'"> '+subCatObj.contact_email+' </a></address></div></div>');
 Skype.ui({
 "name": "call",
 "element": "SkypeButton_Call_Inspree_1",
 "participants": [subCatObj.skype_id]
 });
             
// Datatable starts here   
    $('#categories-table').DataTable().clear().destroy();
    var oTable = $('#categories-table').DataTable({
         dom: "Bfrtip lrtip",
         retrieve: true,
        
        processing: true,
        serverSide: true,
        ajax: {
            //type: 'POST',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
            },
            url: '{{ route("adminTransactionsListing") }}',
            data:  function ( d ) {
                d.vendor_id = id;
                d.filter_from = $('input[name="filter_from"]').val();
                d.filter_to = $('input[name="filter_to"]').val();
            },
        },
        columns: [
            {data: 'id', name: 'transactions.id'},
            {data: 'transaction_id', name: 'transaction_id'},
            {data: 'created_at', name: 'transactions.created_at'},
            {data: 'amount_received', name: 'transactions.amount_received'},
            {data: 'amount_paid', name: 'transactions.amount_paid'},
            {data: 'transaction_date', name: 'transactions.transaction_date'}
        ],
        buttons: [
            {"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print"]
    });                
      // Datatable Ends here          
        });
        });
     
}

window.onload = function(){
    getvendor('1');    
    $('.nav.nav-tabs li:eq(0) a').css('backgroundColor','darkgray').css('borderColor','darkgray');        
    
    setTimeout(function(){
        getaccountinfo($('.btn-group1 li:eq(0) a').data('id'));
        $('.btn-group1 li:eq(0) a').css('backgroundColor','darkgray').css('borderColor','darkgray');    
    },3000);
    

};


$('.nav.nav-tabs li a').click(function(){
   $('.nav.nav-tabs li a').css('backgroundColor','').css('borderColor','');
   $(this).css('backgroundColor','darkgray').css('borderColor','darkgray');
   
   
});

$('#search_daterange').click(function(){   
    $('#categories-table').DataTable().draw();
});
$('#reset_daterange').click(function(){
    $('input[name="filter_from"]').val('');
    $('input[name="filter_to"]').val('');    
    $('#search_daterange').trigger('click');
});

</script>
@endpush
<style>
#SkypeButton_Call_Inspree_1_paraElement{
    margin: -13px -17px !important;
}
</style>
