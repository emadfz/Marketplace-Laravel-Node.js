@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_country') !!}

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold">Edit Country - {{$country->country_name}}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model('Edit ', ['route' => ['admin.country.update', encrypt($country->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}                
                        <div class="form-group {{ $errors->has('CountryCode') ? 'has-error' : ''}}">
                            {!! Form::label('country_code', trans('form.country.country_code'), ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('country_code', $country->country_code, ['class' => 'form-control']) !!}
                                {!! $errors->first('country_code', '<p class="help-block">:message</p>') !!}
                            </div>                
                        </div>                       
                        <div class="form-group {{ $errors->has('CountryName') ? 'has-error' : ''}}">
                            {!! Form::label('country_name', trans('form.country.country_name'), ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('country_name', $country->country_name, ['class' => 'form-control']) !!}
                                {!! $errors->first('country_name', '<p class="help-block">:message</p>') !!}
                            </div>                
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                {!! Form::submit(trans("form.country.btn_update"), ['class'=>'btn btn-primary']) !!}
                                <a class="btn default" href="{{route(config('project.admin_route').'country.index')}}">{{trans("form.country.btn_cancel")}}</a>            
                            </div>
                        </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
