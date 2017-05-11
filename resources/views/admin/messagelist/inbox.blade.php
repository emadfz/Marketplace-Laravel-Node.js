
                                                    
    <div class="col-md-10">
        <div class="portlet light bordered">            
            <div class="portlet-title" >
                <div class="caption font-dark" style="width: 100% !important;">
                    <i class="icon-settings font-dark"></i>
                    <?php if(!empty($type) && $type == 'draft'){ ?>
                        <span class="caption-subject bold">{{trans("message.messagelist.draft_title")}}</span>
                    <?php }else{ ?>
                        <span class="caption-subject bold">{{trans("message.messagelist.index_title")}}</span>
                    <?php } ?>
                </div>                
                
                <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                    <div class="inbox-body" style="padding:0px;">                          
                        <?php if(!empty($emp_dept)) { ?>
                            <div class="tabbable tabbable-tabdrop">                                
                                <ul class="nav nav-tabs">
                                  @foreach ( $emp_dept as $k=>$emp )
                                  <li>
                                      <a href="javascript:getsearch('{!! $emp !!}');">{{ $emp }}</a>
                                  </li>
                                  @endforeach
                                </ul>                     
                            </div>
                        <?php } ?>                                                                                                                   
                    <div class="portlet-body">
                    <div class="table-toolbar"></div>
                    
                    
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="messagelist-table" >
                        <thead>
                            <tr>                             
                                <th class="sorting_disabled mt-checkbox-th">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input name="select_all" id="example-select-all" class="mail-checkbox" type="checkbox">
                                    <span></span>
                                    </label>
                                </th>
                                <th></th>
                                <th></th>                            
                                <th>{{trans("message.messagelist.date")}}</th>                                                
                            </tr>
                        </thead>
                    </table>
                    </div>                               
                                                    
                    </div>
                </div>                            
        </div>
        </div>
    </div>
</div>
</div>

    

