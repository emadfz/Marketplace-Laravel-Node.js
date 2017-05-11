@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_module') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold">{{ trans("form.module.edit_module_title")." - ".$module->module_name }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">

                {!! Form::model('Edit', ['route' => ['admin.module.update', encrypt($module->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}                
                    <div class="form-group {{ $errors->has('ModuleName') ? 'has-error' : ''}}">
                        {!! Form::label('ModuleName', trans('module.ModuleName'), ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('module_name', $module->module_name, ['class' => 'form-control']) !!}
                            {!! $errors->first('module_name', '<p class="help-block">:message</p>') !!}
                        </div>                
                    </div>
                 <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">
                        {!! Form::submit(trans("form.save"), ['class'=>'btn btn-primary']) !!}
                        <a class="btn default" href="{{route(config('project.admin_route').'module.index')}}">{{trans("form.level.btn_cancel")}}</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection