@extends('admin.layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="portlet light clearfix" style="position:relative; padding-bottom:40px;">


            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject">Advertisements List</span>
                    </div>
                </div>
                @include('admin.advertisements.advertisetab')

                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['route' => 'admin.adver.insertsetting', 'class' => 'form-horizontal ajax','id'=>'postadv', 'files' => true])!!}


                    <div class="form-body">

                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-road font-dark"></i><span
                                        class="caption-subject font-dark bold uppercase">General Settings</span>
                                </div>
                                {{--<div class="tools"><a href="javascript:;" class="collapse"></a></div>--}}

                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="caption"><i class="icon-road font-dark"></i><span
                                            class="caption-subject font-dark bold">Home Page</span></div>
                                    <div class="form-group {{ $errors->has('no_advertisement') ? 'has-error' : ''}}">
                                        {!! Form::label('no_advertisement', trans('message.advertisementsgeneralsettings.no_advertisement_in_main_home_page'), ['class' => 'col-sm-6 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('settings[Main][no_advertisement]', isset($value['Main']['no_advertisement'])?$value['Main']['no_advertisement']:null, ['class' => 'form-control settings.Main.no_advertisement']) !!}
                                            {!! $errors->first('no_advertisement', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('rotational_time_ad') ? 'has-error' : ''}}">
                                        {!! Form::label('rotational_time_ad', trans('message.advertisementsgeneralsettings.rotational_in_main_home_page'), ['class' => 'col-sm-6 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('settings[Main][rotational_time_ad]', isset($value['Main']['rotational_time_ad'])?$value['Main']['rotational_time_ad']:null, ['class' => 'form-control settings.Main.rotational_time_ad','placeholder'=>"seconds"]) !!}
                                            {!! $errors->first('rotational_time_ad', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('no_advertisement') ? 'has-error' : ''}}" style="display: none;">
                                        {!! Form::label('no_advertisement', trans('message.advertisementsgeneralsettings.no_advertisement_in_banner_home_page'), ['class' => 'col-sm-6 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('settings[Banner][no_advertisement]', isset($value['Banner']['no_advertisement'])?$value['Banner']['no_advertisement']:null, ['class' => 'form-control settings.Banner.no_advertisement',]) !!}
                                            {!! $errors->first('no_advertisement', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('rotational_time_ad') ? 'has-error' : ''}}" style="display: none;">
                                        {!! Form::label('rotational_time_ad', trans('message.advertisementsgeneralsettings.rotational_in_banner_home_page'), ['class' => 'col-sm-6 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('settings[Banner][rotational_time_ad]', isset($value['Banner']['rotational_time_ad'])?$value['Banner']['rotational_time_ad']:null, ['class' => 'form-control settings.Banner.rotational_time_ad','placeholder'=>"seconds"]) !!}
                                            {!! $errors->first('rotational_time_ad', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="caption"><i class="icon-road font-dark"></i><span
                                            class="caption-subject font-dark bold">Price for Main Advertisement</span>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="days-price">
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('min_days_home_main.*') ? 'has-error' : ''}} required">
                                                    {!! Form::label('min_days', trans('message.advertisementsgeneralsettings.min_days'), ['class' => 'text-center col-lg-12 ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('min_days_home_main[0]', isset($value['Main']['advertisement_prices'][0]['min_days'])?$value['Main']['advertisement_prices'][0]['min_days']:null, ['class' => 'form-control min_days_home_main.0 homepage']) !!}
                                                        {!! $errors->first('min_days_home_main.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('max_days_home_main.*') ? 'has-error' : ''}} required">
                                                    {!! Form::label('max_days', trans('message.advertisementsgeneralsettings.max_days'), ['class' => 'text-center col-lg-12 ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('max_days_home_main[0]', isset($value['Main']['advertisement_prices'][0]['max_days'])?$value['Main']['advertisement_prices'][0]['max_days']:null, ['class' => 'form-control max_days_home_main.0 homepage']) !!}
                                                        {!! $errors->first('max_days_home_main.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('price_home_main.*') ? 'has-error' : ''}} required">
                                                    {!! Form::label('price', trans('message.advertisementsgeneralsettings.price'), ['class' => 'text-center col-lg-12 ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('price_home_main[0]', isset($value['Main']['advertisement_prices'][0]['price'])?$value['Main']['advertisement_prices'][0]['price']:null, ['class' => 'form-control price_home_main.0']) !!}
                                                        {!! $errors->first('price_home_main.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <br/><br/><br/><br/><br/><br/>
                                            <div class="input_fields_wrap_home_main">
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('min_days_home_main.*') ? 'has-error' : ''}} required">

                                                        <div class="col-lg-12">
                                                            {!! Form::text('min_days_home_main[1]', isset($value['Main']['advertisement_prices'][1]['min_days'])?$value['Main']['advertisement_prices'][1]['min_days']:null, ['class' => 'form-control min_days_home_main.1 homepage']) !!}
                                                            {!! $errors->first('min_days_home_main.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('max_days_home_main.*') ? 'has-error' : ''}} required">

                                                        <div class="col-lg-12">
                                                                {!! Form::text('max_days_home_main[1]', isset($value['Main']['advertisement_prices'][1]['max_days'])?$value['Main']['advertisement_prices'][1]['max_days']:null, ['class' => 'form-control max_days_home_main.1 homepage']) !!}
                                                            {!! $errors->first('max_days_home_main.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('price_home_main.*') ? 'has-error' : ''}} required">

                                                        <div class="col-lg-12">
                                                            {!! Form::text('price_home_main[1]', isset($value['Main']['advertisement_prices'][1]['price'])?$value['Main']['advertisement_prices'][1]['price']:null, ['class' => 'form-control price_home_main.1']) !!}
                                                            {!! $errors->first('price_home_main.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="incres"><i
                                                        class="fa fa-plus add_field_button_home_main"></i></div>

                                                <?php
                                                if (!empty($value['Main']['advertisement_prices'])) {
                                                    $flag = 0;
                                                    foreach ($value['Main']['advertisement_prices'] as $values) {
                                                        if ($flag >= 2) {
                                                            ?>
                                                            <div style="float: left;width : 100%; " >
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('min_days_home_main['.$flag.']', $values['min_days'], ['class'=>'form-control homepage min_days_home_main.'.$flag]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('max_days_home_main['.$flag.']', $values['max_days'], ['class'=>'form-control homepage max_days_home_main.'.$flag]) !!}
                                                                        </div></div></div>
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('price_home_main['.$flag.']', $values['price'], ['class'=>'form-control  price_home_main.'.$flag]) !!}
                                                                        </div></div></div>

                                                                <div class="remove"><a href="#" class="remove_field_mingle form-control btn btn-danger btn-xs fa fa-trash-o deleteAttribute" title="Delete" data-toggle="modal" data-placement="top" style=" float: right;font-size: 18px;height: 30px;width: 26px;"></a></div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php
                                                        $flag++;
                                                    }
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="caption"><i class="icon-road font-dark"></i><span
                                            class="caption-subject font-dark bold">Price for Banner Advertisement</span>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="days-price">
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('min_days_home_banner.*') ? 'has-error' : ''}}">
                                                    {!! Form::label('min_days', trans('message.advertisementsgeneralsettings.min_days'), ['class' => 'text-center col-lg-12 ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('min_days_home_banner[0]', isset($value['Banner']['advertisement_prices'][0]['min_days'])?$value['Banner']['advertisement_prices'][0]['min_days']:null, ['class' => 'form-control min_days_home_banner.0 advertisement_page']) !!}
                                                        {!! $errors->first('min_days_home_banner.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('max_days_home_banner.*') ? 'has-error' : ''}}">
                                                    {!! Form::label('max_days', trans('message.advertisementsgeneralsettings.max_days'), ['class' => 'text-center col-lg-12 ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('max_days_home_banner[0]', isset($value['Banner']['advertisement_prices'][0]['max_days'])?$value['Banner']['advertisement_prices'][0]['max_days']:null, ['class' => 'form-control max_days_home_banner.0 advertisement_page']) !!}
                                                        {!! $errors->first('max_days_home_banner.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('price_home_banner.*') ? 'has-error' : ''}}">
                                                    {!! Form::label('price', trans('message.advertisementsgeneralsettings.price'), ['class' => 'text-center col-lg-12 ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('price_home_banner[0]', isset($value['Banner']['advertisement_prices'][0]['price'])?$value['Banner']['advertisement_prices'][0]['price']:null, ['class' => 'form-control price_home_banner.0']) !!}
                                                        {!! $errors->first('price_home_banner.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <br/><br/><br/><br/><br/><br/><br/><br/>
                                            <div class="input_fields_wrap_home_banner">
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('min_days_home_banner.*') ? 'has-error' : ''}}">

                                                        <div class="col-lg-12">
                                                            {!! Form::text('min_days_home_banner[1]', isset($value['Banner']['advertisement_prices'][1]['min_days'])?$value['Banner']['advertisement_prices'][1]['min_days']:null, ['class' => 'form-control min_days_home_banner.1 advertisement_page']) !!}
                                                            {!! $errors->first('min_days_home_banner.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('max_days_home_banner.*') ? 'has-error' : ''}}">

                                                        <div class="col-lg-12">
                                                            {!! Form::text('max_days_home_banner[1]', isset($value['Banner']['advertisement_prices'][1]['max_days'])?$value['Banner']['advertisement_prices'][1]['max_days']:null, ['class' => 'form-control max_days_home_banner.1 advertisement_page']) !!}
                                                            {!! $errors->first('max_days_home_banner.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('price_home_banner.*') ? 'has-error' : ''}}">

                                                        <div class="col-lg-12">
                                                            {!! Form::text('price_home_banner[1]', isset($value['Banner']['advertisement_prices'][1]['price'])?$value['Banner']['advertisement_prices'][1]['price']:null, ['class' => 'form-control price_home_banner.1']) !!}
                                                            {!! $errors->first('price_home_banner.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="incres"><i
                                                        class="fa fa-plus add_field_button_home_banner"></i></div>

                                                <?php
                                                if (!empty($value['Banner']['advertisement_prices'])) {
                                                    $flag = 0;
                                                    foreach ($value['Banner']['advertisement_prices'] as $values) {
                                                        if ($flag >= 2) {
                                                            ?>
                                                            <div style="float: left;width : 100%; " >
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('min_days_home_banner['.$flag.']', $values['min_days'], ['class'=>'advertisement_page form-control min_days_home_banner.'.$flag]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('max_days_home_banner['.$flag.']', $values['max_days'], ['class'=>'advertisement_page form-control max_days_home_banner.'.$flag]) !!}
                                                                        </div></div></div>
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('price_home_banner['.$flag.']', $values['price'], ['class'=>'form-control price_home_banner.'.$flag]) !!}
                                                                        </div></div></div>

                                                                <div class="remove"><a href="#" class="remove_field_mingle form-control btn btn-danger btn-xs fa fa-trash-o deleteAttribute" title="Delete" data-toggle="modal" data-placement="top" style=" float: right;font-size: 18px;height: 30px;width: 26px;"></a></div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php
                                                        $flag++;
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="caption"><i class="icon-road font-dark"></i><span
                                            class="caption-subject font-dark bold">Category/ Sub-category Page</span>
                                    </div>
                                    <div class="form-group {{ $errors->has('no_advertisement') ? 'has-error' : ''}}">
                                        {!! Form::label('no_advertisement', trans('message.advertisementsgeneralsettings.no_advertisement_in_box'), ['class' => 'col-sm-6 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('settings[Category][no_advertisement]', isset($value['Category']['no_advertisement'])?$value['Category']['no_advertisement']:null, ['class' => 'form-control settings.Category.no_advertisement']) !!}
                                            {!! $errors->first('no_advertisement', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('rotational_time_ad') ? 'has-error' : ''}}">
                                        {!! Form::label('rotational_time_ad', trans('message.advertisementsgeneralsettings.rotational_in_box'), ['class' => 'col-sm-6 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('settings[Category][rotational_time_ad]', isset($value['Category']['rotational_time_ad'])?$value['Category']['rotational_time_ad']:null, ['class' => 'form-control settings.Category.rotational_time_ad','placeholder'=>"seconds"]) !!}
                                            {!! $errors->first('rotational_time_ad', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>


                                </div>

                                <div class="col-md-6">
                                    <div class="caption"><i class="icon-road font-dark"></i><span
                                            class="caption-subject font-dark bold">Price</span></div>
                                    <div class="col-sm-12">
                                        <div class="days-price">
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('min_days_category.*') ? 'has-error' : ''}}">
                                                    {!! Form::label('min_days', trans('message.advertisementsgeneralsettings.min_days'), ['class' => 'text-center col-lg-12 ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('min_days_category[0]', isset($value['Category']['advertisement_prices'][0]['min_days'])?$value['Category']['advertisement_prices'][0]['min_days']:null, ['class' => 'form-control category_page min_days_category.0']) !!}
                                                        {!! $errors->first('min_days_category.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('max_days_category.*') ? 'has-error' : ''}}">
                                                    {!! Form::label('max_days_category[0]', trans('message.advertisementsgeneralsettings.max_days'), ['class' => 'text-center col-lg-12 category_page ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('max_days_category[0]', isset($value['Category']['advertisement_prices'][0]['max_days'])?$value['Category']['advertisement_prices'][0]['max_days']:null, ['class' => 'form-control category_page max_days_category.0']) !!}
                                                        {!! $errors->first('max_days_category.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('price_category.*') ? 'has-error' : ''}}">
                                                    {!! Form::label('price', trans('message.advertisementsgeneralsettings.price'), ['class' => 'text-center col-lg-12 ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('price_category[0]', isset($value['Category']['advertisement_prices'][0]['price'])?$value['Category']['advertisement_prices'][0]['price']:null, ['class' => 'form-control price_category.0']) !!}
                                                        {!! $errors->first('price_category.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input_fields_wrap_category">
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('min_days_category.*') ? 'has-error' : ''}}">

                                                        <div class="col-lg-12">
                                                            {!! Form::text('min_days_category[1]', isset($value['Category']['advertisement_prices'][1]['min_days'])?$value['Category']['advertisement_prices'][1]['min_days']:null, ['class' => 'form-control min_days_category.1 category_page']) !!}
                                                            {!! $errors->first('min_days_category.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('max_days_category.*') ? 'has-error' : ''}}">

                                                        <div class="col-lg-12">
                                                            {!! Form::text('max_days_category[1]', isset($value['Category']['advertisement_prices'][1]['max_days'])?$value['Category']['advertisement_prices'][1]['max_days']:null, ['class' => 'form-control max_days_category.1 category_page']) !!}
                                                            {!! $errors->first('max_days_category.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('price_category.*') ? 'has-error' : ''}}">

                                                        <div class="col-lg-12">
                                                            {!! Form::text('price_category[1]', isset($value['Category']['advertisement_prices'][1]['price'])?$value['Category']['advertisement_prices'][1]['price']:null, ['class' => 'form-control price_category.1']) !!}
                                                            {!! $errors->first('price_category.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="incres"><i class="fa fa-plus add_field_button_category"></i>
                                                </div>

                                                <?php
                                                if (!empty($value['Category']['advertisement_prices'])) {
                                                    $flag = 0;
                                                    foreach ($value['Category']['advertisement_prices'] as $values) {
                                                        if ($flag >= 2) {
                                                            ?>
                                                            <div style="float: left;width : 100%; " >
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('min_days_category['.$flag.']', $values['min_days'], ['class'=>'form-control category_page min_days_category.'.$flag]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('max_days_category['.$flag.']', $values['max_days'], ['class'=>'form-control category_page max_days_category.'.$flag]) !!}
                                                                        </div></div></div>
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('price_category['.$flag.']', $values['price'], ['class'=>'form-control price_category.'.$flag]) !!}
                                                                        </div></div></div>

                                                                <div class="remove"><a href="#" class="remove_field_mingle form-control btn btn-danger btn-xs fa fa-trash-o deleteAttribute" title="Delete" data-toggle="modal" data-placement="top" style=" float: right;font-size: 18px;height: 30px;width: 26px;"></a></div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php
                                                        $flag++;
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="caption"><i class="icon-road font-dark"></i><span
                                            class="caption-subject font-dark bold">Mingle Page</span></div>
                                    <div class="form-group {{ $errors->has('no_advertisement') ? 'has-error' : ''}}">
                                        {!! Form::label('no_advertisement', trans('message.advertisementsgeneralsettings.no_advertisement_in_box'), ['class' => 'col-sm-6 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('settings[Mingle][no_advertisement]', isset($value['Mingle']['no_advertisement'])?$value['Mingle']['no_advertisement']:null, ['class' => 'form-control settings.Mingle.no_advertisement']) !!}
                                            {!! $errors->first('no_advertisement', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('rotational_time_ad') ? 'has-error' : ''}}">
                                        {!! Form::label('rotational_time_ad', trans('message.advertisementsgeneralsettings.rotational_in_box'), ['class' => 'col-sm-6 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('settings[Mingle][rotational_time_ad]', isset($value['Mingle']['rotational_time_ad'])?$value['Mingle']['rotational_time_ad']:null, ['class' => 'form-control settings.Mingle.rotational_time_ad']) !!}
                                            {!! $errors->first('rotational_time_ad', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>


                                </div>

                                <div class="col-md-6">
                                    <div class="caption"><i class="icon-road font-dark"></i><span
                                            class="caption-subject font-dark bold">Price</span></div>
                                    <div class="col-sm-12">
                                        <div class="days-price">
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('min_days_mingle.*') ? 'has-error' : ''}}">
                                                    {!! Form::label('min_days', trans('message.advertisementsgeneralsettings.min_days'), ['class' => 'text-center col-lg-12 ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('min_days_mingle[0]', isset($value['Mingle']['advertisement_prices'][0]['min_days'])?$value['Mingle']['advertisement_prices'][0]['min_days']:null, ['class' => 'form-control mingle_page min_days_mingle.0']) !!}
                                                        {!! $errors->first('min_days_mingle.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('max_days_mingle.*') ? 'has-error' : ''}}">
                                                    {!! Form::label('max_days', trans('message.advertisementsgeneralsettings.max_days'), ['class' => 'text-center col-lg-12 ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('max_days_mingle[0]', isset($value['Mingle']['advertisement_prices'][0]['max_days'])?$value['Mingle']['advertisement_prices'][0]['max_days']:null, ['class' => 'form-control mingle_page max_days_mingle.0']) !!}
                                                        {!! $errors->first('max_days_mingle.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class=" {{ $errors->has('price_mingle.*') ? 'has-error' : ''}}">
                                                    {!! Form::label('price', trans('message.advertisementsgeneralsettings.price'), ['class' => 'text-center col-lg-12 ']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('price_mingle[0]', isset($value['Mingle']['advertisement_prices'][0]['price'])?$value['Mingle']['advertisement_prices'][0]['price']:null, ['class' => 'form-control price_mingle.0']) !!}
                                                        {!! $errors->first('price_mingle.*', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input_fields_wrap_mingle">
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('min_days_mingle.*') ? 'has-error' : ''}}">

                                                        <div class="col-lg-12">
                                                            {!! Form::text('min_days_mingle[1]', isset($value['Mingle']['advertisement_prices'][1]['min_days'])?$value['Mingle']['advertisement_prices'][1]['min_days']:null, ['class' => 'form-control mingle_page min_days_mingle.1']) !!}
                                                            {!! $errors->first('min_days_mingle.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('max_days_mingle.*') ? 'has-error' : ''}}">

                                                        <div class="col-lg-12">
                                                            {!! Form::text('max_days_mingle[1]', isset($value['Mingle']['advertisement_prices'][1]['max_days'])?$value['Mingle']['advertisement_prices'][1]['max_days']:null, ['class' => 'form-control mingle_page max_days_mingle.1']) !!}
                                                            {!! $errors->first('max_days_mingle.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class=" {{ $errors->has('price_mingle.*') ? 'has-error' : ''}}">

                                                        <div class="col-lg-12">
                                                            {!! Form::text('price_mingle[1]', isset($value['Mingle']['advertisement_prices'][1]['price'])?$value['Mingle']['advertisement_prices'][1]['price']:null, ['class' => 'form-control price_mingle.1']) !!}
                                                            {!! $errors->first('price_mingle.*', '<p class="help-block">:message</p>') !!}
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="incres"><i class="fa fa-plus add_field_button_mingle"></i>
                                                </div>

                                                <?php
                                                if (!empty($value['Mingle']['advertisement_prices'])) {
                                                    $flag = 0;
                                                    foreach ($value['Mingle']['advertisement_prices'] as $values) {
                                                        if ($flag >= 2) {
                                                            ?>
                                                            <div style="float: left;width : 100%; " >
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('min_days_mingle['.$flag.']', $values['min_days'], ['class'=>'form-control mingle_page min_days_mingle.'.$flag]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('max_days_mingle['.$flag.']', $values['max_days'], ['class'=>'form-control mingle_page max_days_mingle.'.$flag]) !!}
                                                                        </div></div></div>
                                                                <div class="col-sm-4">
                                                                    <div class=" ">
                                                                        <div class="col-lg-12">
                                                                            {!! Form::text('price_mingle['.$flag.']', $values['price'], ['class'=>'form-control price_mingle.'.$flag]) !!}
                                                                        </div></div></div>

                                                                <div class="remove"><a href="#" class="remove_field_mingle form-control btn btn-danger btn-xs fa fa-trash-o deleteAttribute" title="Delete" data-toggle="modal" data-placement="top" style=" float: right;font-size: 18px;height: 30px;width: 26px;"></a></div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php
                                                        $flag++;
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9" style="position:absolute; bottom:10px;">
                                        {!! Form::submit(isset($model) ? trans("message.advertisementsgeneralsettings.update") : trans("message.advertisementsgeneralsettings.save"), ['class'=>'btn btn-primary']) !!}
                                        <a class="btn default"
                                           href="{{route(config('project.admin_route').'advertisements.index')}}">Cancel</a>
                                    </div>
                                </div>
                            </div>

                        </div><!-- END FORM-->
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')

@endpush

@push('scripts')
<script>

    //mingle
    var wrapper_mingle = $(".input_fields_wrap_mingle"); //Fields wrapper
    var add_button_mingle = $(".add_field_button_mingle"); //Add button ID

    var get_counter = $('.input_fields_wrap_mingle .col-sm-4 div div .form-control').last().attr('name');
    var val = get_counter.split(']');

    var counter_mingle = val[0].slice(-1);

    $(add_button_mingle).click(function (e) { //on add input button click
        counter_mingle++;
        e.preventDefault();
        $(wrapper_mingle).append('<div style="float: left;width : 100%; " ><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="min_days_mingle[' + counter_mingle + ']" class="form-control mingle_page min_days_mingle.' + counter_mingle + '"></div></div></div><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="max_days_mingle[' + counter_mingle + ']" class="form-control max_days_mingle.' + counter_mingle + '" ></div></div></div><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="price_mingle[' + counter_mingle + ']" class="form-control price_mingle.' + counter_mingle + '"></div></div></div><div class="remove"><a href="#" class="remove_field_mingle form-control btn btn-danger btn-xs fa fa-trash-o deleteAttribute" title="Delete" data-toggle="modal" data-placement="top" style=" float: right;font-size: 18px;height: 30px;width: 26px;"></a></div></div>'); //add input box
    });


    $(wrapper_mingle).on("click", ".remove_field_mingle", function (e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').parent('div').remove();
    });
    //end

    //category
    var wrapper_category = $(".input_fields_wrap_category"); //Fields wrapper
    var add_button_category = $(".add_field_button_category"); //Add button ID

    var get_counter_category = $('.input_fields_wrap_category .col-sm-4 div div .form-control').last().attr('name');
    var val_category = get_counter_category.split(']');

    var counter_category = val_category[0].slice(-1);

    $(add_button_category).click(function (e) { //on add input button click
        counter_category++;
        e.preventDefault();
        $(wrapper_category).append('<div style="float: left;width : 100%; " ><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="min_days_category[' + counter_category + ']" class="form-control category_page min_days_category.' + counter_category + '"></div></div></div><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="max_days_category[' + counter_category + ']" class="form-control category_page max_days_category.' + counter_category + '" ></div></div></div><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="price_category[' + counter_category + ']" class="form-control price_category.' + counter_category + '"></div></div></div><div class="remove"><a href="#" class="remove_field_mingle form-control btn btn-danger btn-xs fa fa-trash-o deleteAttribute" title="Delete" data-toggle="modal" data-placement="top" style=" float: right;font-size: 18px;height: 30px;width: 26px;"></a></div></div>'); //add input box
    });

    $(wrapper_category).on("click", ".remove_field_mingle", function (e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').parent('div').remove();
    });
    //end

    //home Banner
    var wrapper_home_banner = $(".input_fields_wrap_home_banner"); //Fields wrapper
    var add_button_home_banner = $(".add_field_button_home_banner"); //Add button ID

    var get_counter_banner = $('.input_fields_wrap_home_banner .col-sm-4 div div .form-control').last().attr('name');
    var val_banner = get_counter_category.split(']');

    var counter_home_banner = val_banner[0].slice(-1);

    $(add_button_home_banner).click(function (e) { //on add input button click
        counter_home_banner++;
        e.preventDefault();
        $(wrapper_home_banner).append('<div style="float: left;width : 100%; " ><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="min_days_home_banner[' + counter_home_banner + ']" class="advertisement_page form-control min_days_home_banner.' + counter_home_banner + '"></div></div></div><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="max_days_home_banner[' + counter_home_banner + ']" class="advertisement_page form-control max_days_home_banner.' + counter_home_banner + '" ></div></div></div><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="price_home_banner[' + counter_home_banner + ']" class="form-control price_home_banner.' + counter_home_banner + '"></div></div></div><div class="remove"><a href="#" class="remove_field_mingle form-control btn btn-danger btn-xs fa fa-trash-o deleteAttribute" title="Delete" data-toggle="modal" data-placement="top" style=" float: right;font-size: 18px;height: 30px;width: 26px;"></a></div></div>'); //add input box
    });

    $(wrapper_home_banner).on("click", ".remove_field_mingle", function (e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').parent('div').remove();
    });
    //end

    //home Main
    var wrapper_home_main = $(".input_fields_wrap_home_main"); //Fields wrapper
    var add_button_home_main = $(".add_field_button_home_main"); //Add button ID

    var get_counter_main = $('.input_fields_wrap_home_main .col-sm-4 div div .form-control').last().attr('name');
    var val_main = get_counter_main.split(']');

    var counter_home_main = val_main[0].slice(-1);

    $(add_button_home_main).click(function (e) { //on add input button click
        counter_home_main++;
        e.preventDefault();
        $(wrapper_home_main).append('<div style="float: left;width : 100%; " ><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="min_days_home_main[' + counter_home_main + ']" class="form-control homepage min_days_home_main.' + counter_home_main + '"></div></div></div><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="max_days_home_main[' + counter_home_main + ']" class="form-control homepage max_days_home_main.' + counter_home_main + '" ></div></div></div><div class="col-sm-4"><div class=" "><div class="col-lg-12"><input type="text" name="price_home_main[' + counter_home_main + ']" class="form-control price_home_main.' + counter_home_main + '"></div></div></div><div class="remove"><a href="#" class="remove_field_mingle form-control btn btn-danger btn-xs fa fa-trash-o deleteAttribute" title="Delete" data-toggle="modal" data-placement="top" style=" float: right;font-size: 18px;height: 30px;width: 26px;"></a></div></div>'); //add input box
    });

    $(wrapper_home_main).on("click", ".remove_field_mingle", function (e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').parent('div').remove();
    });
    //end
    
 var thisindex=0;
$('body').delegate( '.homepage,.advertisement_page,.category_page,.mingle_page','keyup',function(){
//$("").keyup(function(){
    $('.error').remove();  
    if($(this).hasClass('homepage')){
        classNameSelector='.homepage';
    }
    if($(this).hasClass('advertisement_page')){
        classNameSelector='.advertisement_page';
    }
    if($(this).hasClass('category_page')){
        classNameSelector='.category_page';
    }
    if($(this).hasClass('mingle_page')){
        classNameSelector='.mingle_page';
    }
    
    
    $(classNameSelector).each(function(){
                 thisindex=$(this).index(classNameSelector);    
                 main_value=parseInt($(classNameSelector+":eq("+thisindex+")").val());
                 previous_value=parseInt($(classNameSelector+":eq("+(thisindex-1)+")").val());
                 if(main_value < 1 || main_value>365){
                     $(this).after('<span class="error" style="color:red">Please Enter Value between 1 to 365</span>');
                 } 
                 else if( main_value <= previous_value && thisindex!=0){
                      $(this).after('<span class="error" style="color:red">Please Enter Value greater than '+previous_value+'</span>');
                 }                 
    });
    if($('.error').length>0){
        $('input[value="Save"]').attr('disabled','disabled');
    }
    else{
        $('input[value="Save"]').removeAttr('disabled');
    }
});   
    
    
</script>

<script src="{{ asset('assets/admin/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}"
type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
@endpush
