@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('create_giftcards') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold">{{ trans("message.giftcards.add") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            
            <div class="portlet-body form">
                {!! Form::open(['id'=>'testname','route' => 'admin.giftcards.store', 'class' => 'form-horizontal ajax', 'files' => true])!!}
                    @include('admin.giftcards._form',['btntxt'=>trans("form.giftcards.btn_save")])
                {!! Form::close() !!}                
            </div>
            
        </div>
    </div>
</div>
@endsection
