<div class="form-body">

    <div class="form-group">
        {!! Form::label('template_key', trans("form.email_templates.template_key"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::text('template_key', null, ['class'=>'form-control', 'disabled'=>'disabled', 'readonly'=>'readonly' ]) !!}
            @if (isset($model) && $model['updated_at'] != null)
            <span class="help-inline">{{trans("form.updated_at")}} <?php $dt = \Carbon\Carbon::parse($model['updated_at']); ?>{{ $dt->format("d M Y, h:i A") }}</span>
            @endif
        </div>
    </div>

    <div class="form-group required">
        {!! Form::label('template_title', trans("form.email_templates.template_title"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">{!! Form::text('template_title', null, ['class'=>'form-control maxlength-handler', 'maxlength'=>'255']) !!}</div>
    </div>

    <div class="form-group">
        {!! Form::label('template_tags', trans("form.email_templates.template_tags"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            <input type="text" value="<?php echo '{#TO_NAME#} '; ?>" readonly onClick="this.select();" class="template-tag-margin"/>
            @foreach($templateData['template_field'] AS $field)
            <input type="text" value="<?php echo '{#' . $field['field_name'] . '#} '; ?>" readonly onClick="this.select();" class="template-tag-margin"/>
            @endforeach
            <br/>
            <span class="help-inline">Use these tags in following templates:</span>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-1 col-md-11">
            <div class="tabbable-custom ">
                <ul class="nav nav-tabs ">
                    <li class="active"><a href="#tab_email" data-toggle="tab">Email</a></li>
<!--                    <li><a href="#tab_notification" data-toggle="tab">Notification</a></li>
                    <li><a href="#tab_sms" data-toggle="tab">SMS</a></li>-->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_email">
                        <div class="form-group">
                            {!! Form::label('email_subject', trans("form.email_templates.email_subject"), ['class' => 'col-md-1 control-label']) !!}
                            <div class="col-md-11">{!! Form::text('email_subject', null, ['class'=>'form-control maxlength-handler', 'maxlength'=>'255']) !!}</div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('email_content', trans("form.email_templates.email_content"), ['class' => 'col-md-1 control-label']) !!}
                            <div class="col-md-11">
                                {!! Form::textarea('email_content', null, ['class'=>'ckeditor form-control', 'rows' => '10']) !!}
                            </div>
                        </div>
                    </div>
<!--                    <div class="tab-pane" id="tab_notification">
                        <div class="form-group">
                            {!! Form::label('notification_content', trans("form.email_templates.notification_content"), ['class' => 'col-md-1 control-label']) !!}
                            <div class="col-md-11">
                                {!! Form::textarea('notification_content', null, ['class'=>'form-control', 'rows' => '10']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_sms">
                        <div class="form-group">
                            {!! Form::label('sms_content', trans("form.email_templates.sms_content"), ['class' => 'col-md-1 control-label']) !!}
                            <div class="col-md-11">
                                {!! Form::textarea('sms_content', null, ['class'=>'form-control', 'rows' => '10']) !!}
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-1 col-md-11">
            {!! Form::submit(isset($model) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'email_templates.index')}}">{{ trans("form.cancel") }}</a>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>
<script>$(".maxlength-handler").maxlength({limitReachedClass: "label label-danger", alwaysShow: !0, threshold: 5});</script>
@endpush
@push('styles')
<style>.template-tag-margin{margin: 2px;text-align: center;}</style>
@endpush
