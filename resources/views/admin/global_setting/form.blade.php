@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('manageGlobalSetting') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.global_setting.gbl_setting") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-bordered">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#make_an_offer_tab" data-toggle="tab"> {{ trans("form.global_setting.make_an_offer") }} </a>
                        </li>
                        <li>
                            <a href="#reward_point_tab" data-toggle="tab"> {{ trans("form.global_setting.reward_points") }} </a>
                        </li>
                        <li>
                            <a href="#manage_shipping_carrier" data-toggle="tab"> {{ trans("form.global_setting.manage_ship_carrier") }} </a>
                        </li>
                        <li>
                            <a href="#manage_product_settings" data-toggle="tab"> {{ trans("form.global_setting.manage_product_settings") }} </a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        @include('admin.global_setting.make_an_offer')
                        @include('admin.global_setting.reward_points')
                        @include('admin.global_setting.shipping_carriers')
                        @include('admin.global_setting.product_settings')

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
    <!-- END PAGE BASE CONTENT -->
    @endsection

    @push('styles')
    <link href="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/global/css/components.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
    <script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
    @endpush