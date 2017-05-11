<div class="row">
    <div class="col-md-12">
        <div class="portlet-body">
            <div class="table-toolbar margin-bottom-10">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>

            <div class="portlet light bordered">

                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-equalizer font-blue"></i>
                        <span class="caption-subject font-blue bold uppercase">{{ trans("form.commissionfees.edit_commissionfees") }}</span>
                        <span class="caption-helper"></span>
                    </div>
                </div>

                <div class="portlet-body form">

                    {!! Form::model($categoryData, ['route' => ['updateCommissionFees', encrypt($categoryData['id']), $scope], 'class' => 'form-horizontal custom-wo-public ajax', 'method' =>'patch', 'data-datatable_id'=>'commissionfees-table'])!!}
                    <!-- BEGIN FORM-->
                    <div class="form-body">
                        <div class="form-group">
                            {!! Form::label('text', trans("form.commissionfees.category_name"), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('text', null, ['class'=>'form-control placeholder-no-fix', 'readonly'=>true, 'disabled'=>true]) !!}
                            </div>
                        </div>

                        @if($scope == 'Products')
                        <div class="form-group required">
                            {!! Form::label('commission', trans("form.commissionfees.commission"), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-8">
                                <div class="input-icon">
                                    <i class="fa">%</i>
                                    {!! Form::text('commission', null, ['class'=>'form-control placeholder-no-fix']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group required">
                            {!! Form::label('buy_it_now_fees', trans("form.commissionfees.buy_it_now_fees"), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-8">
                                <div class="input-icon">
                                    <i class="fa fa-dollar"></i>
                                    {!! Form::text('buy_it_now_fees', null, ['class'=>'form-control placeholder-no-fix']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group required">
                            {!! Form::label('make_an_offer_fees', trans("form.commissionfees.make_an_offer_fees"), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-8">
                                <div class="input-icon">
                                    <i class="fa fa-dollar"></i>
                                    {!! Form::text('make_an_offer_fees', null, ['class'=>'form-control placeholder-no-fix']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group required">
                            {!! Form::label('auction_fees', trans("form.commissionfees.auction_fees"), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-8">
                                <div class="input-icon">
                                    <i class="fa fa-dollar"></i>
                                    {!! Form::text('auction_fees', null, ['class'=>'form-control placeholder-no-fix']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group required">
                            {!! Form::label('set_preview_fees', trans("form.commissionfees.set_a_preview_fees"), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-8">
                                <div class="input-icon">
                                    <i class="fa fa-dollar"></i>
                                    {!! Form::text('set_preview_fees', null, ['class'=>'form-control placeholder-no-fix']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group required">
                            {!! Form::label('seller_preview_charges', trans("form.commissionfees.seller_preview_charges"), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-8">
                                <div class="input-icon">
                                    <i class="fa fa-dollar"></i>
                                    {!! Form::text('seller_preview_charges', null, ['class'=>'form-control placeholder-no-fix']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group required">
                            {!! Form::label('buyer_preview_charges', trans("form.commissionfees.buyer_preview_charges"), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-8">
                                <div class="input-icon">
                                    <i class="fa fa-dollar"></i>
                                    {!! Form::text('buyer_preview_charges', null, ['class'=>'form-control placeholder-no-fix']) !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($scope == 'Services')
                        <div class="form-group required">
                            {!! Form::label('listing_fees', trans("form.commissionfees.listing_fees"), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-8">
                                <div class="input-icon">
                                    <i class="fa fa-dollar"></i>
                                    {!! Form::text('listing_fees', null, ['class'=>'form-control placeholder-no-fix']) !!}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-4 col-md-8">
                                {!! Form::submit(trans("form.update"), ['class'=>'btn btn-primary']) !!}
                                <button type="button" class="btn default" data-dismiss="modal">{{trans('form.cancel')}}</button>
                            </div>
                        </div>
                    </div>
                    <!-- END FORM-->
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>