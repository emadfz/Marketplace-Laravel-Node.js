@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('editdonationvendors') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.donation_vendors.edit") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($vendors, ['route' => ['admin.donationvendors.update', encrypt($vendors->id)], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}
                    @include('admin.donation_vendors._form', ['model' => $vendors])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
