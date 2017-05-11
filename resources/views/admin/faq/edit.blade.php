@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('editFaq') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.faq.edit_faq_topic") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>

            <div class="portlet-body form">
                <div class="portlet light">
                    {!! Form::model($faqTopicData, ['route' => [config('project.admin_route').'faq.update', encrypt($id)], 'class' => 'ajax', 'method' =>'patch'])!!}
                        @include('admin.faq._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection