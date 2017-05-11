@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('edit_level') !!}
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-equalizer font-blue"></i>
                    <span class="caption-subject font-blue bold">{{ trans("form.level_rights.edit_level") }}</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a href= "{{ route(config('project.admin_route').'levelmodule.create') }}" class="btn sbold default">{{ trans("form.level_rights.new_level") }} &nbsp;<i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($input['levelmodule'], ['route' => ['admin.levelmodule.update', $input['employee_level_id']], 'files' => true, 'class' => 'form-horizontal ajax', 'method' =>'patch'])!!}
                    @include('admin.levelmodule._form', ['model' => $input['levelmodule'],'button_text'=>trans("form.level_rights.update")])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
