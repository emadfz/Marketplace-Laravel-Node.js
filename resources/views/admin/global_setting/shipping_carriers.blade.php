<div class="tab-pane" id="manage_shipping_carrier">
    <h3>{{ trans("form.global_setting.manage_ship_carrier") }}</h3>
    <hr>

    <div class="form-body">
        <?php $i = 1; ?>
        @foreach($shippingCarrierSetting AS $shipper)

        <?php
        $update = FALSE;
        $checkedNo = $checkedYes = "";

        if (!empty($shipper['shipping_carrier_settings'])) {
            $update = TRUE;
            if ($shipper['shipping_carrier_settings'][0]['active_in_system'] == 'Yes') {
                $checkedYes = 'checked="checked"';
            } else {
                $checkedNo = 'checked="checked"';
            }
        }else{
            $checkedNo = 'checked="checked"';
        }
        ?>

        {!! Form::open(['url' => route('postShippingCarrierSetting', encrypt($shipper['id'])), 'class' => 'form-horizontal form-row-seperated ajax']) !!}
        <h4>{{ $i++ }}. {{ $shipper['vendor_name'] }}</h4>
        <div class="form-group">
            <label class="col-md-3 control-label">{{ trans("form.global_setting.active_in_system") }} :
                <span class="required"> * </span>
            </label>
            <div class="col-md-9">
                <div class="mt-radio-inline">
                    <label class="mt-radio">
                        <input type="radio" name="active_in_system" id="" value="Yes" {{$checkedYes}} /> {{ trans("form.yes") }} <span></span>
                    </label>
                    <label class="mt-radio">
                        <input type="radio" name="active_in_system" id="" value="No" {{$checkedNo}} /> {{ trans("form.no") }} <span></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">{{ trans("form.global_setting.additional_profit_margin") }}:
                <span class="required"> * </span>
            </label>
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa">%</i></span>
                    <input value="{{ ($update) ? $shipper['shipping_carrier_settings'][0]['additional_profit_margin'] : 0 }}" type="text" class="form-control input-large" name="additional_profit_margin" placeholder="" maxlength="6" /> 
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">{{ trans("form.global_setting.effective_from_date") }}:
                <span class="required"> * </span>
            </label>
            <div class="col-md-9">
                <div class="input-group date date-picker margin-bottom-5 input-large" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                    <input value="{{ ($update) ? Carbon\Carbon::parse($shipper['shipping_carrier_settings'][0]['effective_from_date'])->format('Y-m-d') : '' }}" type="text" class="form-control input-large" readonly="" name="effective_from_date" placeholder="" />
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-primary">{{ trans("form.save") }}</button>
<!--                    <img src="{{ asset('assets/admin/global/img/loading-spinner-grey.gif') }}" alt="{{ trans('form.loading') }}" class="loading" />-->
                    <a class=" btn yellow btn-outline sbold" href="{{ route("getShippingCarrierSettingLogPopup", encrypt($shipper['id'])) }}" data-target="#shipping_ajax_modal_popup" data-toggle="modal"> {{ trans('form.global_setting.view_history') }} </a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <hr>
        @endforeach
    </div>
</div>

<div class="modal fade" id="shipping_ajax_modal_popup" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content" style="padding: 25px;">
            <div class="modal-body">
                <img src="{{ asset('assets/admin/global/img/loading-spinner-grey.gif') }}" alt="{{ trans('form.loading') }}" class="loading">
                <span> &nbsp;&nbsp;{{ trans('form.loading') }} </span>
            </div>
        </div>
    </div>
</div>


