@extends('admin.layouts.app_without_menu')

@section('content')

{!! Form::open(['route' => 'postResetPassword', 'class' => 'login-form ajax custom-wo-public', 'id' => 'resetPasswordFormID'])!!}
<h3 class="form-title">{{ trans('form.reset_password') }}</h3>
<div class="form-group">
    <label class="control-label">{{trans('form.birth_date')}}</label>
    <div class="input-icon">
        <i class="fa fa-calendar"></i>
        <input class="form-control placeholder-no-fix date-picker" data-date-format="yyyy-mm-dd" type="text" autocomplete="off" placeholder="{{trans('form.birth_date')}}" name="date_of_birth" value=""/>
    </div>
</div>
<label class="control-label">{{trans('form.question_selected_during_registration')}}</label>
<div class="form-group">
    @if(isset($secretQuestion) && $secretQuestion->secret_question != "")
        <label class="control-label">{{ $secretQuestion->secret_question }} </label>
    @endif    
    <div class="input-icon">
        <i class="fa fa-question-circle"></i>
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="{{trans('form.secret_questions.secret_answer')}}" name="secret_answer" value=""/>
    </div>
</div>
<div class="form-group">
    <label class="control-label">{{trans('form.password')}}</label>
    <div class="input-icon">
        <i class="fa fa-lock"></i>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{trans('form.password')}}" name="password" /> 
    </div>
</div>
<div class="form-group">
    <label class="control-label">{{trans('form.confirm_password')}}</label>
    <div class="input-icon">
        <i class="fa fa-lock"></i>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{trans('form.confirm_password')}}" name="confirm_password" /> 
    </div>
</div>
<input type="hidden" value="{{ encrypt($token) }}" name="reset_token" />

<div class="form-actions" style="border-bottom: none;">
    <a href="{{route('adminLogin')}}" class="btn grey-salsa btn-outline" id="forget-password"> {{trans('form.back')}}</a>
    {!! Form::submit(trans('form.submit'), ['class'=>'btn green pull-right']) !!}
</div>

{!! Form::close() !!}

@endsection

@push('styles')
<link href="{{ asset('assets/admin/pages/css/login-3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/css/components.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
@endpush