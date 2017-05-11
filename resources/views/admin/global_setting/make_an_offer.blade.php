<div class="tab-pane active" id="make_an_offer_tab">
    <h3>{{ trans("form.global_setting.make_an_offer_setting") }}</h3>
    <hr>

    <?php 
    $update = FALSE;
    $timeToRetractOffer = 0;
    if(isset($makeAnOfferSetting) && !empty($makeAnOfferSetting)){
        $update = TRUE;
        $timeToRetractOffer = $makeAnOfferSetting['time_to_retract_offer'];
    }
    
    ?>
    {!! Form::open(['route' => 'postMakeAnOfferSetting', 'class' => 'form-horizontal form-row-seperated make-an-offer-form ajax']) !!}
    <div class="form-body">
        <div class="form-group required">
            {!! Form::label('time_to_retract_offer', trans("form.global_setting.time_to_retract_an_offer"), ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-9">
                {!! Form::text('time_to_retract_offer', $timeToRetractOffer , ['class'=>'form-control input-large', 'maxlength'=>'3']) !!}
                <span class="help-block">(Minute)</span>
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