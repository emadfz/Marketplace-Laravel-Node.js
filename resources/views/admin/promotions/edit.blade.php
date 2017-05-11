@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_promotions') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>                    
                    <span class="caption-subject font-blue bold">{{ trans("form.promotions.edit_title")." - ".$promotions->promo_code }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model('Edit ', ['route' => ['admin.promotions.update', encrypt($promotions->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}
                    @include('admin.promotions._form', ['model' => $promotions])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
