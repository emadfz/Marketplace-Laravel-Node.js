@extends('admin.layouts.app')

@section('content')
<div class="container">

    <h1>Post</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>{{ trans('employee.title') }}</th><th>{{ trans('employee.body') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $employee->id }}</td> <td> {{ $employee->title }} </td><td> {{ $employee->body }} </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
