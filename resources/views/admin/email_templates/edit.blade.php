@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('editEmailTemplates') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.email_templates.edit") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($templateData, ['route' => [config('project.admin_route').'email_templates.update', encrypt($templateData['id'])], 'class' => 'form-horizontal ajax email-template-form', 'method' =>'patch'])!!}
                    @include('admin.email_templates._form', ['model' => $templateData])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection