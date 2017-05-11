@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('create_attributeset') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold" >{{ trans("attributeset.add_attributeset") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>            
            <div class="portlet-body form">
                {!! Form::open(['route' => 'admin.attributeset.store', 'class' => 'form-horizontal ajax', 'files' => true])!!}
                    @include('admin.attributeset._form')
                {!! Form::close() !!}                
            </div>            
        </div>
    </div>
</div>
@endsection