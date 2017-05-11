@extends('admin.layouts.app_without_menu')

@section('content')
{!! Form::open(['route' => 'postForgotPassword', 'class' => 'forgot-form'])!!}<!--forget-form-->
<h3 class="form-title">{{trans('form.forgot_password')}} ?</h3>
{{--<p> {{trans('form.enter_email_to_reset_password')}} </p>--}}
    
<div class="form-group{{ $errors->has('personal_email') ? ' has-error' : '' }}">
    
    <label class="control-label">{{trans('form.emp_personal_email')}}</label>
    <div class="input-icon bn">
        <i class="fa fa-envelope"></i>
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="{{trans('form.emp_personal_email')}}" name="personal_email" value="{{ old('personal_email') }}" autofocus="true" />
    </div>
    @if ($errors->has('personal_email'))
        <span class="help-block">{{ $errors->first('personal_email') }}</span>
    @endif
</div>

<div class="form-actions" style="border-bottom: none;">
    <a href="{{route('adminLogin')}}" class="btn grey-salsa btn-outline" id="forget-password"> {{trans('form.back')}}</a>
    {!! Form::submit(trans('form.submit'), ['class'=>'btn green pull-right']) !!}
</div>
{!! Form::close() !!}
@endsection

@push('styles')
<link href="{{ asset('assets/admin/pages/css/login-3.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script>
    var ForgotPassword = function() {
    
    var handleForgetPassword = function() {
        $('.forgot-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "",
            rules: {
                personal_email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                personal_email: {
                    required: "{{trans('validation_custom.personal_email_required')}}"
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        $('.forgot-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });
    }
    
    return {
        //main function to initiate the module
        init: function() {
            handleForgetPassword();
        }
    };

}();
jQuery(document).ready(function() {
    ForgotPassword.init();
});
</script>
@endpush