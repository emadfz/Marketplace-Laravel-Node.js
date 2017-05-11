@extends('admin.layouts.app')

@section('content')
<div class="container">

    <h1>States <a href="{{ url('/admin/state/create') }}" class="btn btn-primary pull-right btn-sm">Add New State</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>{{ trans('state.StateCode') }}</th>
                    <th>{{ trans('state.StateName') }}</th>                             
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($state as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $item->state_code }}</td>                    
                    <td>{{ $item->state_name }}</td>
                    <td>
                        <a href="{{ url('/admin/state/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs">Update</a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/admin/state', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $state->render() !!} </div>
    </div>

</div>
@endsection
