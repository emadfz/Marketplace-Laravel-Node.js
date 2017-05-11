@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_giftcards') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold">{{ trans("message.giftcards.edit_giftcard_title")." - ".$giftcard->title }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model('Edit ', ['route' => ['admin.giftcards.update', $id], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}                
                    @include('admin.giftcards._form', ['model' => $giftcard,'btntxt'=>trans("form.update")])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
