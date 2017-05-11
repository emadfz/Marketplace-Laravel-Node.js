@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('create_module') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold">{{ trans("form.module.add") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            
            <div class="portlet-body form">                
                {!! Form::open(['route' => 'admin.module.store', 'class' => 'form-horizontal ajax'])!!}
                     <div class="form-group {{ $errors->has('module_name') ? 'has-error' : ''}}">
                        {!! Form::label('ModuleName', trans('form.module.ModuleName'), ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('module_name', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('module_name', '<p class="help-block">:message</p>') !!}
                        </div>                
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-3">
                            {!! Form::submit(trans("form.save"), ['class' => 'btn btn-primary']) !!}
                            <a class="btn default" href="{{route(config('project.admin_route').'module.index')}}">{{trans("form.cancel")}}</a>
                        </div>
                    </div>
                {!! Form::close() !!}                
            </div>
            
        </div>
    </div>
</div>
@endsection
