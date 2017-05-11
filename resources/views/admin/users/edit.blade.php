@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('editUsers') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.users.profile_detail") }}</span>
                    <span class="label label-primary">{{$view['userDetails']['user_type']}}</span>
                    <span class="label label-info">{{$view['userDetails']['status']}}</span>
                </div>
<!--                <div class="tools"><a href="javascript:;" class="collapse"></a></div>-->
                <div class="actions">
                    <a class="btn btn-circle btn-icon-only btn-default" href="{{env('FRONT_APP_URL').'/signinFromAdmin/'.$view['userId']}}" title="SignIn to user account" target="_blank" ><i class="icon-cloud-upload"></i></a>
                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                </div>
            </div>

            <div class="portlet-body form">
                {!! Form::model($view['userDetails'], ['route' => [config('project.admin_route').'users.update', encrypt($view['userDetails']['id'])], 'class' => 'form-horizontal ajax users-form', 'method' =>'patch'])!!}
                @include('admin.users._form', ['model' => $view['userDetails']])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection