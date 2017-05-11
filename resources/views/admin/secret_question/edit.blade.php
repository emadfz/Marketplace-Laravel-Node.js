@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('editSecretQuestion') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.secred_questions.edit_tc") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($secretQuestionData, ['route' => [config('project.admin_route').'secret_questions.update', encrypt($secretQuestionData['id'])], 'class' => 'form-horizontal', 'method' =>'patch'])!!}
                    @include('admin.term_condition._form', ['model' => $secretQuestionData])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
