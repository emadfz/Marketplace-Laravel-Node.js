<!-- BEGIN FORM-->
<div class="form-body" id="userProfileForm">

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption"><i class="icon-road font-dark"></i><span class="caption-subject font-dark bold uppercase">Personal Information</span></div>
            <div class="tools"><a href="javascript:;" class="collapse"></a></div>
        </div>
        <div class="portlet-body">
            <!-- Personal Information -->
<!--            <h3 class="form-section">Personal Information</h3>-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('username', trans('form.users.username'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('username', null, ['class'=>'form-control', 'placeholder'=>'', 'id' => 'username', 'maxlength'=>25, 'autofocus'=>'autofocus']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('user_email', trans('form.email'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'', 'id' => 'user_email', 'maxlength'=>100]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('user_title', trans('form.title'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::select('title', $view['nameTitle'], null, ['class'=>'form-control', 'id' => 'user_title']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('gender', trans('form.users.gender'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::select('gender', $view['gender'], null, ['class'=>'form-control', 'id' => 'gender']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('first_name', trans('form.users.first_name'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('first_name', null, ['class'=>'form-control', 'placeholder'=>'', 'id' => 'first_name', 'maxlength'=>20]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('', trans('form.users.last_name'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('last_name', null, ['class'=>'form-control', 'placeholder'=>'', 'id' => 'last_name', 'maxlength'=>20]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('date_of_birth', trans('form.users.date_of_birth'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('date_of_birth', null, ['class'=>'form-control datepicker-ui', 'maxDate'=>0, 'id' => 'date_of_birth']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('phone_number', trans('form.users.phone_number'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('phone_number', null, ['class'=>'form-control', 'id' => 'phone_number', 'maxlength'=>16]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('secret_question', trans('form.users.secret_question'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            <p class="form-control-static">{{$view['userDetails']['secret_question']['secret_question']}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('secret_answer', trans('form.users.secret_answer'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            <p class="form-control-static">{{$view['userDetails']['secret_answer']}}</p>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('last_accessed_date', trans('form.users.last_accessed_date'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            <p class="form-control-static">{{$view['lastAccessedDate']}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('active_since', trans('form.users.active_since'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            <p class="form-control-static">{{$view['userDetails']['activation_datetime']}}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($view['userDetails']['user_type'] != 'Buyer')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('verified_seller', trans('form.users.verified_seller'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            <?php
                            $verifiedDisabled = ($view['userDetails']['status'] == 'Verified' || $view['userDetails']['status'] == 'Active') ? 'checked disabled' : '';
                            ?>
                            <input data-backdrop="static" data-keyboard="false" type="checkbox" class="make-switch" data-on-text="Yes" data-off-text="No" id="changeUserStatus" {{$verifiedDisabled}}/>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    @if($view['userDetails']['user_type'] != 'Buyer')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption"><i class="icon-road font-dark"></i><span class="caption-subject font-dark bold uppercase">Business Information</span></div>
            <div class="tools"><a href="javascript:;" class="collapse"></a></div>
        </div>
        <div class="portlet-body">
            
            <!-- Business Information -->
<!--            <h3 class="form-section">Business Information</h3>-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('business_name', trans('form.users.business_name'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('business_name', $view['sellerDetails']['business_name'], ['class'=>'form-control', 'placeholder'=>'', 'id' => 'business_name', 'maxlength'=>50]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('industry_type', trans('form.users.industry_type'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::select('industry_type', $view['industryTypes'], $view['sellerDetails']['industry_type_id'], ['class'=>'form-control', 'id' => 'industry_type']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('business_details', trans('form.users.business_details'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('business_details', $view['sellerDetails']['business_details'], ['class'=>'form-control', 'placeholder'=>'', 'id' => 'business_details', 'maxlength'=>500, 'rows'=>'4', 'cols'=>'50']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('tax_id_no', trans('form.users.tax_id_no'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('tax_id_number', $view['sellerDetails']['tax_id_number'], ['class'=>'form-control', 'placeholder'=>'', 'id' => 'tax_id_number', 'maxlength'=>50]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('business_reg_number', trans('form.users.business_reg_no'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('business_reg_number', $view['sellerDetails']['business_reg_number'], ['class'=>'form-control', 'placeholder'=>'', 'id' => 'business_reg_number', 'maxlength'=>50]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('business_phone_number', trans('form.users.business_phone'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('business_phone_number', $view['sellerDetails']['business_phone_number'], ['class'=>'form-control', 'placeholder'=>'', 'id' => 'business_phone_number', 'maxlength'=>20]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('website', trans('form.common.website'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">
                            {!! Form::text('website', $view['sellerDetails']['website'], ['class'=>'form-control', 'placeholder'=>'', 'id' => 'website', 'maxlength'=>100]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!---- START : Address Information ---->

    <!---- Billing Address ---->



    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption"><i class="icon-road font-dark"></i><span class="caption-subject font-dark bold uppercase">Address Information</span></div>
            <div class="tools"><a href="javascript:;" class="collapse"></a></div>
        </div>
        <div class="portlet-body">
            @forelse ($view['addressDetails'] as $address)
            @if ($address['address_type'] == 'Billing')
            <h3 class="form-section">{{trans('form.users.billing_address')}}</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('billing_address_1', trans('form.users.address_1'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::text('billing_address_1', $address['address_1'], ['class'=>'form-control', 'placeholder'=>'', 'id' => '', 'maxlength'=>100]) !!}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('billing_address_2', trans('form.users.address_2'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::text('billing_address_2', $address['address_2'], ['class'=>'form-control', 'placeholder'=>'', 'id' => 'billing_address_2', 'maxlength'=>100]) !!}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('billing_country', trans('form.common.country'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::select('billing_country', (['' => 'Select Country']+ $view['countries']),$address['country_id'],['class' => 'form-control select-country','id' => 'billing_country', 'data-targetState'=>'select-billing-state']) !!}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('billing_postal_code', trans('form.common.postal_code'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::text('billing_postal_code', $address['postal_code'], ['class'=>'form-control', 'placeholder'=>'', 'id' => 'billing_postal_code', 'maxlength'=>10]) !!}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('billing_state', trans('form.common.state'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::select('billing_state', getAllStates($address['country_id'], TRUE),$address['state_id'],['class' => 'form-control select-state select-billing-state','id' => 'billing_state', 'data-targetCity'=>'select-billing-city']) !!}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('billing_city', trans('form.common.city'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::select('billing_city', getAllCities($address['state_id'], TRUE),$address['city_id'],['class' => 'form-control select-billing-city','id'=>'billing_city']) !!}</div>
                    </div>
                </div>
            </div>
            @elseif ($address['address_type'] == 'Shipping')
            <h3 class="form-section">{{trans('form.users.shipping_address')}}</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('shipping_address_1', trans('form.users.address_1'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::text('shipping_address_1', $address['address_1'], ['class'=>'form-control', 'placeholder'=>'', 'id' => '', 'maxlength'=>100]) !!}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('shipping_address_2', trans('form.users.address_2'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::text('shipping_address_2', $address['address_2'], ['class'=>'form-control', 'placeholder'=>'', 'id' => 'shipping_address_2', 'maxlength'=>100]) !!}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('shipping_country', trans('form.common.country'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::select('shipping_country', (['' => 'Select Country']+ $view['countries']),$address['country_id'],['class' => 'form-control select-country','id' => 'shipping_country', 'data-targetState'=>'select-shipping-state']) !!}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('shipping_postal_code', trans('form.common.postal_code'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::text('shipping_postal_code', $address['postal_code'], ['class'=>'form-control', 'placeholder'=>'', 'id' => 'shipping_postal_code', 'maxlength'=>10]) !!}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('shipping_state', trans('form.common.state'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::select('shipping_state', getAllStates($address['country_id'], TRUE),$address['state_id'],['class' => 'form-control select-state select-shipping-state','id' => 'shipping_state', 'data-targetCity'=>'select-shipping-city']) !!}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('shipping_city', trans('form.common.city'), ['class' => 'control-label col-md-3']) !!}
                        <div class="col-md-9">{!! Form::select('shipping_city', getAllCities($address['state_id'], TRUE),$address['city_id'],['class' => 'form-control select-shipping-city','id'=>'shipping_city']) !!}</div>
                    </div>
                </div>
            </div>

            @endif
            @empty
            <p>No address found</p>
            @endforelse



        </div>
    </div>
</div>

<!--<div class="form-actions">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green">Submit</button>
                    <button type="button" class="btn default">Cancel</button>
                </div>
            </div>
        </div>
        <div class="col-md-6"> </div>
    </div>
</div>-->
<!-- END FORM-->

<div class="modal fade" id="confirmVerifyModal" role="dialog" aria-labelledby="confirmVerifyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{trans("form.confirm")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.users.confirm_verify_user')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmVerifyUser">Confirm</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    /*Bootstrap Switch to verify user*/
    $("input#changeUserStatus").bootstrapSwitch();
    $('input#changeUserStatus').on('switchChange.bootstrapSwitch', function (event, state) {
        $('input#changeUserStatus').bootstrapSwitch('state', !state, true);

        if (state === true) {
            $('#confirmVerifyModal').modal({backdrop: 'static', keyboard: false});
        }

    });

    $(".modal-footer #confirmVerifyUser").click(function () {
        $(".modal-body").append("Processing....");
        $(this).attr("disabled", "disabled");
        verifyUnverifyUser(true);
    })

    /*Verify User*/
    verifyUnverifyUser = function (changeType) {
        if (changeType === true) {
            $.ajax({
                url: '{{route("verifyUser",$view["userId"])}}',
                type: 'PATCH',
                dataType: 'json',
                data: {_method: 'PATCH', submit: true},
                success: function (r) {
                    if (r.success == 1) {
                        $('#confirmVerifyModal').modal('hide');
                        toastr.success(r.msg);
                        /*Change switch and disabled it*/
                        $('input#changeUserStatus').bootstrapSwitch('toggleState', true, true);
                        $('input#changeUserStatus').bootstrapSwitch('disabled', true);
                        return true;
                    } else if (r.success == 0) {
                        $('#confirmVerifyModal').modal('hide');
                        toastr.error(r.msg, {timeOut: 10000});
                        //location.reload();
                    }
                },
                error: function (data) {
                    if (data.status === 422) {
                        toastr.error("{{ trans('message.failure') }}");
                    }
                }
            });
        } else {
            toastr.error("{{ trans('message.action_not_allowed') }}");
        }
    }

    /*Disable profile detail page field*/
    $("div#userProfileForm").find('input, textarea, button, select').attr('disabled', 'disabled');
</script>
@endpush
@push('styles')
@endpush
