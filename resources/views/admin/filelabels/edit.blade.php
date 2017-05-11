@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('editlabels') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.file_labels.edit") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($labels, ['route' => ['admin.labels.update', encrypt($labels->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}
                    @include('admin.filelabels._form', ['model' => $labels])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
