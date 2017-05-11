@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('createSecretQuestion') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.secret_questions.create_secret_question") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            
            <div class="portlet-body form">
                {!! Form::open(['route' => config('project.admin_route').'secret_questions.store', 'class' => 'form-horizontal ajax'])!!}
                    @include('admin.secret_question._form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection