@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_products') !!}
@include('admin.products._partials.tabs')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.edit")." ".$product->title }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="tab-content">
                <div class=" tab-pane active" id="product">    
                    <div class="portlet-body form">
                        {!! Form::model($product, ['route' => ['admin.products.update', encrypt($product->id)], 'method' =>'patch', 'files' => true, 'class' => 'form-horizontal ajax' ])!!}
                            @include('admin.products._form', ['model' => $product])                    
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="tab-pane" id="images">
                        @include('admin.products._partials.images',['id'=>$id])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
