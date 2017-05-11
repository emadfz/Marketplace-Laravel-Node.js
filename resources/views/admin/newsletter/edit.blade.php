@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('editNewsletter') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.newsletters.edit_newsletter") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($newsletterData, ['route' => [config('project.admin_route').'newsletters.update', encrypt($newsletterData['id'])], 'class' => 'form-horizontal ajax newsletters-form', 'method' =>'patch'])!!}
                    @include('admin.newsletter._form', ['model' => $newsletterData])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection