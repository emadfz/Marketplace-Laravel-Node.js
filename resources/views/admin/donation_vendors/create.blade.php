@extends('admin.layouts.app')

@section('content')
{!! Breadcrumbs::render('createdonationvendors') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.donation_vendors.new_vendor") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            
            <div class="portlet-body form">
                {!! Form::open(['route' => 'admin.donationvendors.store', 'class' => 'form-horizontal ajax', 'files' => true])!!}
                    @include('admin.donation_vendors._form')
                {!! Form::close() !!}
                
            </div>
            
        </div>
    </div>
</div>
@endsection