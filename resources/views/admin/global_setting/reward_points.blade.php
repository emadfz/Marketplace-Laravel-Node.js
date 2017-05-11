<div class="tab-pane" id="reward_point_tab">
    <h3>{{ trans("form.global_setting.reward_points_setting") }}</h3>
    <hr>

    <?php
    $update = FALSE;
    if (isset($rewardPointSetting) && !empty($rewardPointSetting)) {
        $update = TRUE;
    }
    ?>

    {!! Form::open(['route' => 'postRewardPointSetting', 'class' => 'form-horizontal form-row-seperated reward_point-form ajax']) !!}
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label">{{ trans("form.global_setting.buyer_earns_reward_point_on_purchase_of_every") }}:
                <span class="required"> * </span>
            </label>
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                    <input value="{{ ($update) ? $rewardPointSetting['buyer_earns_reward_point_on_purchase_of_every'] : 0 }}" type="text" class="form-control input-large" name="buyer_earns_reward_point_on_purchase_of_every" placeholder="" maxlength="7" /> 
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">{{ trans("form.global_setting.one_reward_point") }}:
                <span class="required"> * </span>
            </label>
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                    <input value="{{ ($update) ? $rewardPointSetting['reward_point_value'] : 0 }}" type="text" class="form-control input-large" name="reward_point_value" placeholder="" maxlength="7" /> 
                </div>
                <span class="help-block">{{ trans("form.global_setting.for_payment") }}</span>
            </div>

        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">{{ trans("form.global_setting.effective_from_date") }}:
                <span class="required"> * </span>
            </label>
            <div class="col-md-9">
                <div class="input-group date date-picker margin-bottom-5 input-large" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                    <input value="{{ ($update) ? Carbon\Carbon::parse($rewardPointSetting['effective_from_date'])->format('Y-m-d') : '' }}" type="text" class="form-control input-large" readonly="" name="effective_from_date" placeholder="">
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn btn-primary">{{ trans("form.save") }}</button>
                <a class="btn default" href="{{route(config('project.admin_route').'home.index')}}">{{ trans("form.cancel") }}</a>
                <a class=" btn yellow btn-outline sbold" href="{{ route("getRewardPointSettingLogPopup") }}" data-target="#reward_point_ajax_modal_popup" data-toggle="modal"> {{ trans('form.global_setting.view_history') }} </a>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<div class="modal fade" id="reward_point_ajax_modal_popup" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content" style="padding: 25px;">
            <div class="modal-body">
                <img src="{{ asset('assets/admin/global/img/loading-spinner-grey.gif') }}" alt="{{ trans('form.loading') }}" class="loading">
                <span> &nbsp;&nbsp;{{ trans('form.loading') }} </span>
            </div>
        </div>
    </div>
</div>