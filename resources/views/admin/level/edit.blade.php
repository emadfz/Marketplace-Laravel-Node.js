@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_level') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold">{{ trans("message.level.edit_level_title")." - ".$level->level_name }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model('Edit ', ['route' => ['admin.level.update', encrypt($level->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}                
                     <div class="form-group {{ $errors->has('level_name') ? 'has-error' : ''}}">
                        {!! Form::label('level_name', trans('level.level_name'), ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('level_name', $level->level_name, ['class' => 'form-control']) !!}
                            {!! $errors->first('level_name', '<p class="help-block">:message</p>') !!}
                        </div>                
                    </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">            
                        {!! Form::submit(trans("form.level.btn_update"), ['class'=>'btn btn-primary']) !!}
                        <a class="btn default" href="{{route(config('project.admin_route').'level.index')}}">{{trans("form.level.btn_cancel")}}</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection




          


    
    

   