<!-- BEGIN FORM-->
<div class="form-body">
    <div class="form-group required {!! $errors->has('page_title') ? 'has-error' : '' !!}">
        {!! Form::label('page_title', trans("form.content_pages.page_title"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::text('page_title', null, ['class'=>'form-control']) !!}
            {!! $errors->first('page_title', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group required">
        <label class="col-md-2 control-label">{{ trans("form.content_pages.page_position") }}</label>
        <div class="col-md-10">

            <div class="mt-checkbox-inline form-inline">

                <div class="col-md-2">
                    <label class="mt-checkbox mt-checkbox-outline" />
                    <?php 
                        $isHeaderChecked = '';
                        $frontHeaderPageId = 0;
                    ?>
                    
                    @if (isset($model) && $model['header_front_menu_id'] != 0)
                        <?php 
                            $isHeaderChecked = 'checked=checked';
                            $frontHeaderPageId = $model['header_front_page_id'];
                        ?>
                    @endif

                    
                    <input type="checkbox" id="position_header" class="position" name="position_header" {{ $isHeaderChecked }}  
                    <?php if(!isset($model['status']))  echo"checked"; ?> /> Header <span></span>

                    </label>
                </div>
                <div class="form-group {!! $errors->has('header_front_menu_id') ? 'has-error' : '' !!}">
                    <div class="col-md-8">
                        {!! Form::select('header_front_menu_id', $headerMenu, null, ['class'=>'form-control input-medium']) !!}
                        {!! $errors->first('header_front_menu_id', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <input type="hidden"   name="header_front_page_id" value="{{ $frontHeaderPageId }}" />
            </div>

            <div class="mt-checkbox-inline form-inline">
                <div class="col-md-2 form-position-error">
                    <label class="mt-checkbox mt-checkbox-outline" />
                    <?php 
                        $isFooterChecked = '';
                        $frontFooterPageId = 0;
                    ?>
                    @if (isset($model) && $model['footer_front_menu_id'] != 0)
                        <?php 
                            $isFooterChecked = 'checked=checked';
                            $frontFooterPageId = $model['footer_front_page_id'];
                        ?>
                    @endif
                    <input type="checkbox" id="position_footer" class="position"  name="position_footer" {{ $isFooterChecked }}/> Footer <span></span>

                    </label>
                    {!! $errors->first('position_footer', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {!! $errors->has('footer_front_menu_id') ? 'has-error' : '' !!}">
                    <div class="col-md-8">
                        {!! Form::select('footer_front_menu_id', $footerMenu, null, ['class'=>'form-control input-medium']) !!}
                        {!! $errors->first('footer_front_menu_id', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <input type="hidden" name="footer_front_page_id" value="{{ $frontFooterPageId }}" />
            </div>
        </div>
    </div>

    <div class="form-group required {!! $errors->has('description') ? 'has-error' : '' !!}">
        {!! Form::label('description', trans("form.content_pages.content_description"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::textarea('description', null, ['class'=>'ckeditor form-control', 'rows' => '10']) !!}
            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group required {!! $errors->has('meta_title') ? 'has-error' : '' !!}">
        {!! Form::label('meta_title', trans("form.meta_title"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::text('meta_title', null, ['class'=>'form-control maxlength-handler', 'maxlength'=>'50']) !!}
            {!! $errors->first('meta_title', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group required {!! $errors->has('meta_keywords') ? 'has-error' : '' !!}">
        {!! Form::label('meta_keywords', trans("form.meta_keywords"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::textarea('meta_keywords', null, ['class'=>'form-control maxlength-handler', 'rows' => 2, 'maxlength'=>'200']) !!}
            {!! $errors->first('meta_keywords', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group required {!! $errors->has('meta_description') ? 'has-error' : '' !!}">
        {!! Form::label('meta_description', trans("form.meta_description"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::text('meta_description', null, ['class'=>'form-control maxlength-handler', 'maxlength'=>'160','id'=>'meta_description']) !!}
            {!! $errors->first('meta_description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group required {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('status', trans("form.status"), ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-2">
            {!! Form::select('status', $status, @isset($model['status']) ? $model['status'] : 'Published', ['class'=>'form-control']) !!}
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-2 col-md-10">
            {!! Form::button('Preview',['class'=>'btn btn-primary','id'=>'preview','data-url'=>route('content_pages_preview')]) !!}
            {!! Form::submit(isset($model) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'content_pages.index')}}">{{ trans("form.cancel") }}</a>
        </div>
    </div>
</div>
<!-- END FORM-->


<div class="modal fade" id="preview_content_page" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" style="width:1000px!important;height:1000px!important;overflow:auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">       
               
                
            </div>
            <div class="modal-footer">                
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>
<script>
$('input[name="position_header"]').click(function(e){
if(!$('input[name="position_footer"]').prop("checked"))
{
  var checkbox = $(this);
    
    e.preventDefault();
    return false;
    
}
});

$('input[name="position_footer"]').click(function(e){
if(!$('input[name="position_header"]').prop("checked"))
{
 var checkbox = $(this);
    
        e.preventDefault();
        return false;
    
}});

$(".maxlength-handler").maxlength({limitReachedClass: "label label-danger", alwaysShow: !0, threshold: 5});

var ContentPages = function () {

    var handleContentPage = function () {
        $('.content-page-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: [],
            rules: {
                page_title: {required: true},
                meta_title: {required: true},
                meta_description: {required: true},
                meta_keywords: {required: true},
                status: {required: true},
                description: {
                    required: function (){
                        CKEDITOR.instances.description.updateElement();
                    },
                },
            },
            messages: {
                page_title: {required: "{{trans('validation_custom.content_page.page_title_required')}}"},
                position_footer: {required: "{{trans('validation_custom.common.position_footer')}}"},
                description: {required: "{{trans('validation_custom.common.description_required')}}"},
                meta_title: {required: "{{trans('validation_custom.common.meta_title_required')}}"},
                meta_description: {required: "{{trans('validation_custom.common.meta_description_required')}}"},
                meta_keywords: {required: "{{trans('validation_custom.common.meta_keyword_required')}}"},
                status: {required: "{{trans('validation_custom.common.status_required')}}"},
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                //$('.alert-danger', $('.content-page-form')).show();
                /*if($('#position_header').is(":checked")){
                    $("#position_footer-error").remove();
                    $("#position_footer").rules("remove", "required");
                }*/
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
                if (element.is('textarea') && element.attr("name") == "description"){
                    error.insertAfter(element.closest('.form-control').next("div"));
                } else if(element.attr("name") == 'position_footer'){
                    /*if($('#position_header').is(":checked")){
                        $(element.closest('.help-block')).remove();
                        $("#position_footer").rules("remove", "required");
                    }else{*/
                        error.insertAfter(element.closest('.form-position-error'));
                    //}
                }else{
                    error.insertAfter(element.closest('.form-control'));
                }
            },
            submitHandler: function (form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });
        
        $('.content-page-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.content-page-form').validate().form()) {
                    $('.content-page-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            handleContentPage();
        }
    };
}();
jQuery(document).ready(function () {
    ContentPages.init();
});

$('#preview').click(function(){
    $('#preview_content_page').modal('show');
    $('#preview_content_page .modal-title').html($('input[name="page_title"]').val());
    $('#preview_content_page .modal-body').load($(this).data('url'));    
    setTimeout(
            function(){
                $('#preview_continer').html(CKEDITOR.instances['description'].getData());
            },1000
        );            
});

$('#preview_content_page').on('hidden.bs.modal', function () {    
  $('#preview_content_page .modal-body').html('');
});




</script>
@endpush