@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_attributeset') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold" style="float: left; max-width: 87% !important; word-wrap: break-word;">{{ trans("attributeset.edit_attributeset")." ".$input['attributeset']->attribute_set_name }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($input['attributeset'], ['route' => ['admin.attributeset.update', encrypt($input['attributeset']->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}
                    @include('admin.attributeset._form', ['model' => $input['attributeset']])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
