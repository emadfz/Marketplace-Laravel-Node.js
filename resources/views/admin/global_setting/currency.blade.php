<div class="tab-pane " id="currency">
    <h3>Currency Rates for today </h3>
    <hr>
 <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-cogs"></i>Currency Rates for today </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                        <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
                                        <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
                                        <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body flip-scroll">
                                    <table class="table table-bordered table-striped table-condensed flip-content">
                                        <thead class="flip-content">
                                            <tr>
                                                <th> Currency Code </th>
                                                <th> Rate to 1 USD </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $data = json_decode($currency->json_data); 
                                          //dd($data);     
                                          //dd($data->rates);
                                        ?>

                                        @foreach($data->rates as $countryCode=>$price)
                                            <tr>
                                                <td>  {{$countryCode}}</td>
                                                <td> {{$price}}  </td>  
                                            </tr>
                                        @endforeach
                                        
                                        
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
</div>