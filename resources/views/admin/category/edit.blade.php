@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_category') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold">{{ trans("form.category.title")." - ".$category->text }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model('Edit ', ['route' => ['admin.category.update', $category->id], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}                
                    @include('admin.category._form', ['model' => $category])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
