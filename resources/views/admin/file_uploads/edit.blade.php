@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('editfileuploads') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.file_uploads.edit_file") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($fileuploads, ['route' => ['admin.fileuploads.update', encrypt($fileuploads->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}
                    @include('admin.file_uploads._form', ['model' => $label])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
