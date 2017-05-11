@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('create_occasions') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold">{{ trans("message.occasions.add") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>

            <div class="tab-content">
                <div class="portlet-body form tab-pane active" id="giftcardform">
                    {!! Form::open(['route' => 'admin.occasions.store', 'class' => 'form-horizontal ajax', 'files' => true,'id'=>'occasions_form'])!!}
                    @include('admin.occasions._form',['button_name'=>trans("form.occasions.btn_save")])
                    {!! Form::close() !!}
                </div>                
                    @include('admin.occasions._partials.imageuploader')                 
            </div>
        </div>
    </div>
</div>


@endsection