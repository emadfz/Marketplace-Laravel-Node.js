@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_attribute') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold" style="float: left; max-width: 87% !important; word-wrap: break-word;">{{ trans("attribute.edit_attribute")." ".$input['attribute']->attribute_name }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($input['attribute'], ['route' => ['admin.attribute.update', encrypt($input['attribute']->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}
                    @include('admin.attribute._form', ['model' => $input['attribute']])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
