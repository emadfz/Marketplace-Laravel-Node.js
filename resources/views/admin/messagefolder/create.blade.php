@extends('admin.layouts.app')

@section('content')
<div class="container">

    <h2>Create New State</h2>
    <hr/>
    
    {!! Form::open(['url' => '/admin/state', 'class' => 'form-horizontal']) !!}
            
            <div class="form-group {{ $errors->has('folder_name') ? 'has-error' : ''}}">
                {!! Form::label('folder_name', trans('state.folder_name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('folder_name', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('state_code', '<p class="help-block">:message</p>') !!}
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
