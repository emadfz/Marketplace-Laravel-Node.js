@extends('admin.layouts.app')
@section('content')
@if($scope == 'Products')
{!! Breadcrumbs::render('manageCommissionFeesProducts') !!}
@else
{!! Breadcrumbs::render('manageCommissionFeesServices') !!}
@endif
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{trans("form.commissionfees.commission_fees")}}</span>
                    - <span class="caption-subject font-green bold uppercase">{{$scope}}</span>
                </div>
            </div>

            <div class="portlet-body">
                <div class="table-toolbar"></div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column scrollable" id="commissionfees-table">
                    <thead>
                        <tr>
                            <th>Left</th>
                            <th>{{trans("form.commissionfees.category_name")}}</th>
                            @if($scope == 'Products')
                            <th>{{trans("form.commissionfees.commission")}} %</th>
                            <th>{{trans("form.commissionfees.buy_it_now_fees")}} <span class="fa fa-dollar"></span></th>
                            <th>{{trans("form.commissionfees.make_an_offer_fees")}} <span class="fa fa-dollar"></span></th>
                            <th>{{trans("form.commissionfees.auction_fees")}} <span class="fa fa-dollar"></span></th>
                            <th>{{trans("form.commissionfees.set_a_preview_fees")}} <span class="fa fa-dollar"></span></th>
                            <th>{{trans("form.commissionfees.seller_preview_charges")}} <span class="fa fa-dollar"></span></th>
                            <th>{{trans("form.commissionfees.buyer_preview_charges")}} <span class="fa fa-dollar"></span></th>
                            @endif

                            @if($scope == 'Services')
                            <th>{{trans("form.commissionfees.listing_fees")}} <span class="fa fa-dollar"></span></th>
                            @endif
                            <th>{{trans("form.action")}}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="commissionfees_ajax_modal_popup" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="padding: 25px;">
            <div class="modal-body">
                <img src="{{ asset('assets/admin/global/img/loading-spinner-grey.gif') }}" alt="{{ trans('form.loading') }}" class="loading">
                <span> &nbsp;&nbsp;{{ trans('form.loading') }} </span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .cat-commission-pad-cls{padding-left: 20px;}
    table#commissionfees-table th,table#commissionfees-table td{ text-align:right;}
    table#commissionfees-table th:nth-child(2),table#commissionfees-table td:nth-child(2){ text-align:left;}
    table#commissionfees-table th:last-child,table#commissionfees-table td:last-child{ text-align: center;}
    table#commissionfees-table thead tr th:first-child,table#commissionfees-table tbody tr td:first-child{ display: none;}
</style>
@endpush('styles')
@push('scripts')
<script>
    var oTable = $('#commissionfees-table').DataTable({
    dom: "<'row'<'col-md-12'<'col-md-6'><'col-xs-6'f>>>" +
            "<'row'<'col-md-12'<'col-md-6'><'col-md-6'>>>" +
            "<'row'<'col-md-12'rt>>" +
            "<'row'<'col-md-12'<'col-md-6'i><'col-md-6'>>>",
            processing: true,
            serverSide: true,
            paging: false,
            columnDefs: [{ "width": "20%", "targets": 1 }],
            autoWidth: true,
            lengthChange: false,
            sorting:[[0, 'asc']],
            ajax: {
            method: 'POST',
                    beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
                    },
                    url: '{{ route("datatableCommissionFeesList", $scope) }}',
            },
            columns: [
            {data: 'lft', name: 'lft', searchable: false, orderable: false, visible:true},
            {data: 'name', name: 'name', orderable: false, sClass:'text-left'},
                    @if ($scope == 'Products')
            {data: 'commission', name: 'commission', orderable: false},
            {data: 'buy_it_now_fees', name: 'buy_it_now_fees', searchable: false, orderable: false},
            {data: 'make_an_offer_fees', name: 'make_an_offer_fees', searchable: false, orderable: false},
            {data: 'auction_fees', name: 'auction_fees', searchable: false, orderable: false},
            {data: 'set_preview_fees', name: 'set_preview_fees', searchable: false, orderable: false},
            {data: 'seller_preview_charges', name: 'seller_preview_charges', searchable: false, orderable: false},
            {data: 'buyer_preview_charges', name: 'buyer_preview_charges', searchable: false, orderable: false},
                    @endif
                    @if ($scope == 'Services')
            {data: 'listing_fees', name: 'listing_fees', searchable: false, orderable: false},
                    @endif
            {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            //buttons: [{"extend": "collection", "text": "<i class=\"fa fa-download\"><\/i> Export", "buttons": ["csv", "excel", "pdf"]}, "print", "reset", "reload"]
    });
</script>
@endpush
