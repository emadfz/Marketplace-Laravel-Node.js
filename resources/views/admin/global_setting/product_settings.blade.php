<div class="tab-pane" id="manage_product_settings">
    <h3>{{ trans("form.global_setting.manage_product_settings") }}</h3>
    <hr>
    <?php
    $update             = FALSE;
    $allow_no_of_images = 0;
    if(isset($productSetting) && !empty($productSetting)){
        $update             = TRUE;
        $allow_no_of_images = $productSetting['allow_no_of_images'];
    }
    ?>
    {!! Form::open(['route' => 'postProductSetting', 'class' => 'form-horizontal form-row-seperated product-setting-form ajax']) !!}
    <div class="form-body">
        <div class="form-group required">
            {!! Form::label('allow_no_of_images', trans("form.global_setting.allow_no_of_images"), ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-9">
                {!! Form::text('allow_no_of_images', $allow_no_of_images , ['class'=>'form-control input-large', 'maxlength'=>'2']) !!}
            </div>
        </div>
    </div>

    <div class="form-body">
        <div class="form-group required">
            {!! Form::label('expiration_day', trans("form.global_setting.expiration_day"), ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-9">
                {!! Form::text('expiration_day', @$productSetting['expiration_day'] , ['class'=>'form-control input-large', 'maxlength'=>'2']) !!}
            </div>
        </div>
    </div>

    <hr>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn btn-primary">{{ trans("form.save") }}</button>
                <a class="btn default" href="{{route(config('project.admin_route').'home.index')}}">{{ trans("form.cancel") }}</a>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>