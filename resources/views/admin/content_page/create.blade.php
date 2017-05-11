@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('createContentPage') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.content_pages.add_content_page") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            
            <div class="portlet-body form">
                {!! Form::open(['route' => config('project.admin_route').'content_pages.store', 'class' => 'form-horizontal content-page-form'])!!}
                    @include('admin.content_page._form')
                {!! Form::close() !!}
            </div>
            
        </div>
    </div>
</div>
@endsection