@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('create_attribute') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold">{{ trans("attribute.add_attribute") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            
            <div class="portlet-body form">
                {!! Form::open(['route' => 'admin.attribute.store', 'class' => 'form-horizontal ajax', 'files' => true])!!}
                    @include('admin.attribute._form')
                {!! Form::close() !!}
                
            </div>
            
        </div>
    </div>
</div>
@endsection