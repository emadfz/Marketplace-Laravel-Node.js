@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('editdepartments') !!}

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("departments.edit") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($departments, ['route' => ['admin.departments.update', encrypt($departments->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}
                    @include('admin.departments._form', ['model' => $departments])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
