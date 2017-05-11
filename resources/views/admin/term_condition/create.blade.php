@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('createTermAndCondition') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.terms_and_conditions.add_tc") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            
            <div class="portlet-body form">
                {!! Form::open(['route' => config('project.admin_route').'terms_and_conditions.store', 'class' => 'form-horizontal ajax'])!!}
                    @include('admin.term_condition._form')
                {!! Form::close() !!}
                
            </div>
            
        </div>
    </div>
</div>
@endsection