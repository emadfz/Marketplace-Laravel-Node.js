@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('editContentPage') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.content_pages.edit_content_page") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($contentPageData, ['route' => [config('project.admin_route').'content_pages.update', encrypt($contentPageData['id'])], 'class' => 'form-horizontal content-page-form', 'method' =>'patch'])!!}
                    @include('admin.content_page._form', ['model' => $contentPageData])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
