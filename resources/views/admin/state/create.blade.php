@extends('admin.layouts.app')

@section('content')
<div class="container">

    <h2>Create New State</h2>
    <hr/>
    
    {!! Form::open(['url' => '/admin/state', 'class' => 'form-horizontal']) !!}
            
            <div class="form-group {{ $errors->has('StateCode') ? 'has-error' : ''}}">
                {!! Form::label('CountryCode', trans('state.StateCode'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('state_code', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('state_code', '<p class="help-block">:message</p>') !!}
                </div>                
            </div>                       
            <div class="form-group {{ $errors->has('state_name') ? 'has-error' : ''}}">
                {!! Form::label('StateName', trans('state.StateName'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('state_name', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('state_name', '<p class="help-block">:message</p>') !!}
                </div>                
            </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

</div>
@endsection
