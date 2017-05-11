<!-- BEGIN FORM-->
<div class="form-body">
    <div class="form-group required {!! $errors->has('secret_question') ? 'has-error' : '' !!}">
        {!! Form::label('secret_question', trans("form.secret_questions.secret_question"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::text('secret_question', null, ['class'=>'form-control']) !!}
            {!! $errors->first('secret_question', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-2 col-md-10">
            {!! Form::submit(isset($model) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'secret_questions.index')}}">{{ trans("form.cancel") }}</a>
        </div>
    </div>
</div>
<!-- END FORM-->