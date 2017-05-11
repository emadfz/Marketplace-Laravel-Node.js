@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('create_products') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">Add Product</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            
            <div class="portlet-body form">
                {!! Form::open(['route' => 'admin.products.store', 'files' => true, 'class' => 'form-horizontal ajax'])!!}
                    @include('admin.products._form')
                {!! Form::close() !!}
            </div>
            
        </div>
    </div>
</div>
@endsection
