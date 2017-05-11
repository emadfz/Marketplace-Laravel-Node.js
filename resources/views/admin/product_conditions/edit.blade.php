@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_productConditions') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>                    
                    <span class="caption-subject font-blue bold">{{ trans("message.product_conditions.edit")." - ".$productConditions->name }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model('Edit ', ['route' => ['admin.product_conditions.update', encrypt($productConditions->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}                
                    @include('admin.product_conditions._form', ['model' => $productConditions])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
