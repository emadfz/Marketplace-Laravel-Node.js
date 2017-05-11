@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('countries') !!}
<div class="container">

    <h1>Countries <a href="{{ url('/admin/country/create') }}" class="btn btn-primary pull-right btn-sm">Add New Country</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>{{ trans('country.CountryCode') }}</th>
                    <th>{{ trans('country.CountryName') }}</th>                             
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($country as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $item->country_code }}</td>                    
                    <td>{{ $item->country_name }}</td>
                    <td>
                        <a href="{{ url('/admin/country/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs">Update</a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/admin/country', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $country->render() !!} </div>
    </div>

</div>
@endsection
