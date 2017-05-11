@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('editforums') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.forums.edit_forum") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($forums, ['route' => ['admin.forums.update', encrypt($forums->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}
                    <?php /*@include('admin.forums._form', ['model' => $forums])*/ ?>
                    @include('admin.forums._form_detail', ['model' => $forums])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
