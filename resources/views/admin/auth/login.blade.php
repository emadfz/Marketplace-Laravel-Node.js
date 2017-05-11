@extends('admin.layouts.app_without_menu')

@section('content')
<!-- BEGIN LOGIN FORM -->
{!! Form::open(['route' => 'adminLogin', 'class' => 'login-form', 'id' => 'signInForm'])!!}
<h3 class="form-title">{{trans('form.login_form_title')}}</h3>

<!--<div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
    <span> Enter email and password. </span>
</div>-->

<div class="form-group{{ $errors->has('professional_email') ? ' has-error' : '' }}">
    <label class="control-label">{{trans('form.emp_professional_email')}}</label>
    <div class="input-icon">
        <i class="fa fa-user"></i>
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="{{trans('form.emp_professional_email')}}" name="professional_email" value="{{ old('professional_email') }}" maxlength="100" autofocus="true"/>
    </div>
    @if ($errors->has('professional_email'))
    <span class="help-block">{{ $errors->first('professional_email') }}</span>
    @endif
</div>

<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label class="control-label">{{trans('form.password')}}</label>
    <div class="input-icon">
        <i class="fa fa-lock"></i>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{trans('form.password')}}" name="password" /> 
    </div>
    @if ($errors->has('password'))
    <span class="help-block">{{ $errors->first('password') }}</span>
    @endif
</div>

@if(session('loginFailedLimitExceed') === TRUE )
<div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
    <label class="control-label col-md-12" style="padding: 0;">{{trans('form.captcha')}}</label>
    <span class='refereshrecapcha'>{!! captcha_img('flat') !!}</span>
    <a href="javascript:;" onclick="refreshCaptcha()"><i class="fa fa-refresh"></i></a>
    <input class="form-control placeholder-no-fix" style="margin-top: 5px;" type="text" autocomplete="off" placeholder="{{trans('form.captcha')}}" name="captcha" id="captcha" /> 
    <input type="hidden" value="1" name="captcha_hdn" />
    @if ($errors->has('captcha'))
    <span class="help-block">{{ $errors->first('captcha') }}</span>
    @endif
</div>
@endif


<div class="form-actions"  style="border-bottom: none;">

    {!! Form::submit(trans("form.login"), ['class'=>'btn green pull-right']) !!}
</div>
<hr/>

<div class="form-group">
    <div class="forget-password">
        <p><a href="{{route("forgotPassword")}}" id="forget-password"> {{trans('form.forgot_password')}} ? </a></p>
    </div>
</div>

<div class="form-group">
    <div class="btn-group">
        <a class="btn-mini dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="false"> {{trans("form.contact_site_admin")}}
            <i class="fa fa-angle-down"></i>
        </a>
        <ul class="dropdown-menu pull-right">
            <li><a href="javascript:;" class="popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="{{config('project.contact_phone_number')}}" data-original-title="{{trans("form.contact_number")}}"><i class="fa fa-phone"></i> {{trans("form.contact_by_phone")}} </a></li>
            <li><a href="skype:{{config('project.contact_skype_username')}}?call"><i class="fa fa-skype"></i> {{trans("form.contact_by_skype")}}</a></li>
            <li><a href="mailto:{{config('project.contact_email')}}"><i class="fa fa-at"></i> {{trans("form.contact_by_email")}} </a></li>
        </ul>
    </div>
</div>
{!! Form::close() !!}
<!-- END LOGIN FORM -->

@endsection

@push('styles')
<link href="{{ asset('assets/admin/pages/css/login-3.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script>
    function refreshCaptcha() {
        $.ajax({
            url: "{{route('refereshCaptcha')}}",
            type: 'get',
            dataType: 'html',
            success: function (json) {
                $('.refereshrecapcha').html(json);
            },
            error: function (data) {
                toastr.error("{{ trans('message.failure') }}");//alert('Try Again.');
            }
        });
    }

    var Login = function () {
        var handleLogin = function () {
            $('.login-form').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    professional_email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    professional_email: {
                        required: "{{trans('validation_custom.professional_email_required')}}",
                        email: "{{trans('validation_custom.valid_email')}}"
                    },
                    password: {
                        required: "{{trans('validation_custom.password_required')}}"
                    }
                },
                invalidHandler: function (event, validator) { //display error alert on form submit   
                    //$('.alert-danger', $('.login-form')).show();
                },
                highlight: function (element) { // hightlight error inputs
                    $(element)
                            .closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                success: function (label) {
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element.closest('.input-icon'));
                },
                submitHandler: function (form) {
                    form.submit(); // form validation success, call ajax form submit
                }
            });

            $('.login-form input').keypress(function (e) {
                if (e.which == 13) {
                    if ($('.login-form').validate().form()) {
                        $('.login-form').submit(); //form validation success, call ajax form submit
                    }
                    return false;
                }
            });
        }
        return {
            //main function to initiate the module
            init: function () {
                handleLogin();
            }
        };

    }();
    jQuery(document).ready(function () {
        Login.init();
    });
</script>
@endpush


