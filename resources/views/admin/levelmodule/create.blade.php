@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('create_level') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold">{{ trans("form.level_rights.add_level") }}</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a href= "{{URL::to('admin/levelmodule/47/edit')}}" class="btn sbold default">{{ trans("form.level_rights.edit_level") }} &nbsp;<i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
             <div class="portlet-body form">
                {!! Form::open(['route' => 'admin.levelmodule.store', 'class' => 'form-horizontal ajax', 'files' => true])!!}
                    @include('admin.levelmodule._form_create', ['model' => $input['modules'],'button_text'=>trans("form.level_rights.save")])
                {!! Form::close() !!}
                
            </div>
            
        </div>
    </div>
</div>
@endsection