@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('create_transaction') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">{{ trans("form.transactions.add_transaction") }}</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            
            <div class="portlet-body form">
                {!! Form::open(['route' => 'admin.transactions.store', 'class' => 'form-horizontal ajax', 'files' => true])!!}
                    @include('admin.transactions._form', ['model' => $vendors])
                {!! Form::close() !!}
                
            </div>
            
        </div>
    </div>
</div>
@endsection