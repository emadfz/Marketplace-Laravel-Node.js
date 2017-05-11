@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_occasions') !!}
@include('admin.occasions._partials.tabs')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>                    
                    <span class="caption-subject font-blue bold">{{ trans("message.occasions.edit")." - ".$occasion->name }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="tab-content">
            <div class="portlet-body form tab-pane active" id="giftcardform">
                {!! Form::model('Edit ', ['route' => ['admin.occasions.update', encrypt($occasion->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}                
                    @include('admin.occasions._form', ['model' => $occasion,'button_name'=>trans("form.update")])
                {!! Form::close() !!}
            </div>
                @include('admin.occasions._partials.imageuploader')                 
            </div>
        </div>
    </div>
</div>
@endsection
