{{--@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif--}}

<!-- BEGIN FORM-->
<div  class="form-body">
    <div class="form-group {!! $errors->has('attribute_set_id') ? 'has-error' : '' !!}">
        {!! Form::label('attribute_set_id', trans("attribute.attribute_set_id"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::select('attribute_set_id', (['0' => 'Select a AttributeSet']+$input['all_Attributeset']),null,['class' => 'form-control']) !!}
            {!! $errors->first('attribute_set_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('attribute_name') ? 'has-error' : '' !!}">
        {!! Form::label('attribute_name', trans("attribute.attribute_name"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('attribute_name', null, ['class'=>'form-control', 'placeholder'=>"Enter Attribute Name"]) !!}
            {!! $errors->first('attribute_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('attribute_set_description') ? 'has-error' : '' !!}">
        {!! Form::label('attribute_description', trans("attribute.attribute_description"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::textarea('attribute_description', null, ['class'=>'form-control']) !!}
            {!! $errors->first('attribute_description', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group {!! $errors->has('variation_allowed') ? 'has-error' : '' !!}">
        {!! Form::label('variation_allowed', trans("attribute.variation_allowed"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            <div class="mt-radio-inline">
                <label class="mt-radio">{!! Form::radio('variation_allowed', 1,false, ['class'=>'form-control' ]) !!}Yes<span></span></label>
                <label class="mt-radio">{!! Form::radio('variation_allowed', 0,true, ['class'=>'form-control']) !!}No<span></span></label>
                {!! $errors->first('variation_allowed', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="form-group {!! $errors->has('catelog_input_type') ? 'has-error' : '' !!}">
        {!! Form::label('catelog_input_type', trans("attribute.catelog_input_type"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::select('catelog_input_type', (['dropdown' => 'Drop Down']),null,['class' => 'form-control']) !!}
            {!! $errors->first('catelog_input_type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group {!! $errors->has('view_in_filter') ? 'has-error' : '' !!}">
        {!! Form::label('view_in_filter', trans("attribute.view_in_filter"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            <div class="mt-radio-inline">
                <label class="mt-radio">{!! Form::radio('view_in_filter', 1,true, ['class'=>'form-control' ]) !!}Yes<span></span></label>
                <label class="mt-radio">{!! Form::radio('view_in_filter', 0,false, ['class'=>'form-control']) !!}No<span></span></label>
                {!! $errors->first('view_in_filter', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="form-group {!! $errors->has('comparable') ? 'has-error' : '' !!}">
        {!! Form::label('comparable', trans("attribute.comparable"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            <div class="mt-radio-inline">
                <label class="mt-radio">{!! Form::radio('comparable', 1, true ,['class'=>'form-control']) !!}Yes<span></span></label>
                <label class="mt-radio">{!! Form::radio('comparable', 0, false,['class'=>'form-control']) !!}No<span></span></label>
                {!! $errors->first('comparable', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="form-group {!! $errors->has('mytext.*') ? 'has-error' : '' !!} required add_more_attrib">
        {!! Form::label('attribute_values', trans("attribute.attribute_values"), ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            <button class="add_field_button form-control" style="float:right; width:20%;">Add More</button>            
            <div class="input_fields_wrap">
                <?php
                if (!empty($input['attribute_values'])) {
                    $flag = 0;
                    foreach ($input['attribute_values'] as $values) {
                        if ($flag == 0) {
                            ?>
                            <div>
                                {!! Form::text('mytext['.$flag.']', $values->attribute_values, ['class'=>'form-control mytext.'.$flag ,'style'=> 'float: left;width:75%;']) !!}
                            </div>
                        <?php } else { ?>
                            <div style="float:left;width:100%;">
                                <a href="#" class="remove_field form-control btn btn-danger btn-xs fa fa-trash-o deleteAttribute" title="Delete" data-toggle="modal" data-placement="top" style="float:right; width:10%;margin-top: 5px;font-size: 18px;"></a>
                                {!! Form::text('mytext['.$flag.']', $values->attribute_values, ['class'=>'form-control mytext.'.$flag,'style'=> 'float: left;width:75% !important;margin-top: 5px;']) !!}                         
                            </div>   
                        <?php } ?>
                        <?php
                        $flag++;
                    }
                } else {
                    ?>
                    <div>
                        {!! Form::text('mytext[0]', null, ['class'=>'form-control mytext.0','style'=> 'float: left;width:75%;']) !!}
                    </div>
                <?php } ?>
            </div>

        </div>  
    </div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(isset($model) ? trans("attribute.update") : trans("attribute.save"), ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'attribute.index')}}">Cancel</a>
        </div>
    </div>
</div>
<style>
    .arraycls{ float: left !important; }
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>
//var max_fields      = 30; //maximum input boxes allowed
var wrapper = $(".input_fields_wrap"); //Fields wrapper
var add_button = $(".add_field_button"); //Add button ID

var counter = 2;

$(add_button).click(function (e) { //on add input button click
    counter++;
    e.preventDefault();
    $(wrapper).append('<div style="float:left;width:100%;"><a href="#" class="remove_field form-control btn btn-danger btn-xs fa fa-trash-o deleteAttribute" title="Delete" data-toggle="modal" data-placement="top" style="float:right; width:10%;margin-top: 5px;font-size: 18px;"></a>'+
            '<input type="text" name="mytext[a' + counter + ']" class="form-control mytext.a' + counter + '" style="float: left;width:75%;margin-top: 5px;"></div>'); //add input box        
});
var vallowed = "{{@isset($input['attribute']->variation_allowed) ? $input['attribute']->variation_allowed : ''}}";
var vallowedcondition = "{{@isset($input['attribute']->catelog_input_type) ? $input['attribute']->catelog_input_type : ''}}";

if (vallowed == 0) {
    $('#catelog_input_type').empty();
    $("#catelog_input_type").append(new Option("Drop Down", "dropdown"));
    $("#catelog_input_type").append(new Option("Radio Button", "radio"));
    $("#catelog_input_type").append(new Option("Text Box", "text"));
    $("#catelog_input_type").val("{{@$input['attribute']->catelog_input_type}}");

    if (vallowedcondition == 'text') {
        $(".add_more_attrib").css({display: "none"});
    }
}

$(document).ready(function () {

    $('input[type=radio][name=variation_allowed]').change(function () {
        if (this.value == '1') {
            $('#catelog_input_type').empty();
            $("#catelog_input_type").append(new Option("Drop Down", "dropdown"));
            $(".add_more_attrib").css({display: "block"});
        } else if (this.value == '0') {
            $('#catelog_input_type').empty();
            $("#catelog_input_type").append(new Option("Drop Down", "dropdown"));
            $("#catelog_input_type").append(new Option("Radio Button", "radio"));
            $("#catelog_input_type").append(new Option("Text Box", "text"));
        }
    });

    $("#catelog_input_type").change(function () {
        if ($("#catelog_input_type option:selected").val() == 'text') {
            $(".add_more_attrib").css({display: "none"});
        } else {
            $(".add_more_attrib").css({display: "block"});
        }
    });


});

$(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
    e.preventDefault();
    $(this).parent('div').remove();
})
</script>
<!-- END FORM-->