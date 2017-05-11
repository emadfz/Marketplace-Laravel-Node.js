<!-- BEGIN FORM-->
<div class="form-body">
    @if(isset($resend) && $resend==1)
    <div class="alert alert-warning"> {{trans("message.newsletters.resend_note")}} </div>
    @endif
    <div class="form-group required {!! $errors->has('newsletter_title') ? 'has-error' : '' !!}">
        {!! Form::label('newsletter_title', trans("form.newsletters.newsletter_title"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::text('newsletter_title', null, ['class'=>'form-control maxlength-handler', 'maxlength'=>'100']) !!}
            {!! $errors->first('newsletter_title', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group required {!! $errors->has('newsletter_date') ? 'has-error' : '' !!}">
        {!! Form::label('newsletter_date', trans("form.newsletters.newsletter_date"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            <div class="input-group date date-picker margin-bottom-5 input-large" data-date-format="yyyy-mm-dd" data-date-start-date="+1d">
                {!! Form::text('newsletter_date', null, ['class'=>'form-control']) !!}
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-calendar"></i>
                    </button>
                </span>
            </div>
            {!! $errors->first('newsletter_date', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group required {!! $errors->has('newsletter_content') ? 'has-error' : '' !!}">
        {!! Form::label('newsletter_content', trans("form.newsletters.newsletter_content"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::textarea('newsletter_content', null, ['class'=>'ckeditor form-control', 'rows' => '10']) !!}
            {!! $errors->first('newsletter_content', '<span class="help-block">:message</span>') !!}
            <span class="help-inline">Newsletter Tag: </span>
            {#USERNAME#} | {#UNSUBSCRIBE_LINK#}
        </div>
    </div>

    <div class="form-group required {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('status', trans("form.status"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-2">
            {!! Form::select('status', $status, null, ['class'=>'form-control']) !!}
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    
    @if (isset($model) && $model['updated_at'] != null)
    <div class="form-group">
        
            {!! Form::label('updated_at', trans("form.updated_at"), ['class' => 'col-md-2 control-label']) !!}
        
        <div class="col-md-10">
            <?php $dt = \Carbon\Carbon::parse($model['updated_at']); ?>
            <span class="help-inline">{{ $dt->format("d M Y, h:i A") }}</span>
        </div>
    </div>
    @endif
</div>

<input type="hidden" value="{{isset($resend) && $resend==1 ? 1 : 0}}" name="resend" />

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-2 col-md-10">
            {!! Form::submit(isset($model) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'newsletters.index')}}">{{ trans("form.cancel") }}</a>
        </div>
    </div>
</div>
<!-- END FORM-->

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>

<script>
$(".maxlength-handler").maxlength({limitReachedClass: "label label-danger", alwaysShow: !0, threshold: 5});

var Newsletters = function () {
    var handleNewsletters = function () {
        $('.newsletters-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: [],
            rules: {
                newsletter_title: {required: true},
                newsletter_date: {required: true},
                status: {required: true},
                newsletter_content: {
                    required: function () {
                        CKEDITOR.instances.newsletter_content.updateElement();
                    },
                },
            },
            messages: {
                newsletter_title: {required: "{{trans('validation_custom.newsletters.newsletter_title_required')}}"},
                newsletter_date: {required: "{{trans('validation_custom.newsletters.newsletter_date_required')}}"},
                newsletter_content: {required: "{{trans('validation_custom.newsletters.newsletter_content_required')}}"},
                status: {required: "{{trans('validation_custom.common.status_required')}}"},
            },
            invalidHandler: function (event, validator) { //display error alert on form submit   
                //$('.alert-danger', $('.content-page-form')).show();
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                if (element.is('textarea') && element.attr("name") == "newsletter_content") {
                    error.insertAfter(element.closest('.form-control').next("div"));
                } else if (element.attr("name") == "newsletter_date") {
                    error.insertAfter(element.closest('.form-control').closest("div"));
                } else {
                    error.insertAfter(element.closest('.form-control'));
                }
            },
            submitHandler: function (form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.newsletters-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.newsletters-form').validate().form()) {
                    $('.newsletters-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            handleNewsletters();
        }
    };

}();
jQuery(document).ready(function () {
    Newsletters.init();
});
        @if (isset($model) && $model['status'] == 'Sent' && isset($resend) && $resend==0)
        $('form.newsletters-form').find('input, textarea, button, select').attr('disabled', true);
        @endif
</script>
@endpush

@push('styles')
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/css/components.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
