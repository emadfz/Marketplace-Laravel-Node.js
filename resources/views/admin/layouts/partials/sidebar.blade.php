<?php 
$role_id = \Auth::guard('admin')->user()->role_id;
$userType=\Auth::guard('admin')->user()->first_name;
$sidebar_arrays=config('sidebar.sidebar_array');
$routeSegments=explode('.',\Route::currentRouteName());       

$currentPath='';
if(isset($routeSegments[2]) && !empty($routeSegments[2])){    
    $currentPath=URL('/'.@$routeSegments[0].'/'.@$routeSegments[1].'/'.@$routeSegments[2]);
}
$currentModulePath=URL('/'.@$routeSegments[0].'/'.@$routeSegments[1]);

?>

<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-levels="3" data-auto-scroll="true" data-slide-speed="200">
            
           
            
            <li class="nav-item start">                              
                    
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="arrow"></span>
                </a>
                
                <ul class="sub-menu">
                    <li class="nav-item start">
                        <a href="{{route(config('project.admin_route').'home.index')}}" class="nav-link ">
                            <i class="icon-bar-chart"></i>
                            <span class="title">Dashboard Home</span>
                        </a>
                    </li>
                    @if($userType=="Super" || checkAuthorize(array('advertisements','previewproducts','subscriptionplans','sitestores'),'read_access'))
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-graph"></i>
                            <span class="title">Revenue</span>
                            <span class="arrow"></span>
                        </a>
                        
                        <ul class="sub-menu">
                            @if( $userType=="Super" || checkAuthorize('advertisements','read_access'))
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link">
                                    <span class="title">Advertisements</span>
                                </a>
                            </li>
                            @endif
                            @if( $userType=="Super" || checkAuthorize('previewproducts','read_access'))
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link ">
                                    <span class="title">Preview Products</span>
                                </a>
                            </li>
                            @endif
                            @if( $userType=="Super" || checkAuthorize('generalproducts','read_access'))
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link ">
                                    <span class="title">General Products</span>
                                </a>
                            </li>
                            @endif
                            @if( $userType=="Super" || checkAuthorize('subscriptionplans','read_access'))
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link ">
                                    <span class="title">Subscription Plans</span>
                                </a>
                            </li>
                            @endif                            
                            @if( $userType=="Super" || checkAuthorize('sitestores','read_access'))
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link ">
                                    <span class="title">Site Stores</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                        
                    </li>
                    @endif
                    @if($userType=="Super" || checkAuthorize(array('expenses'),'read_access'))
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-calculator"></i>
                            <span class="title">Expenses</span>
                            <span class="arrow"></span>
                        </a>
                        
                        <ul class="sub-menu">                            
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link ">
                                    <span class="title">Seller's Payout</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link ">
                                    <span class="title">Refund</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link ">
                                    <span class="title">Employee Salaries</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link ">
                                    <span class="title">Other Vendors</span>
                                </a>
                            </li>
                        </ul>
                        
                    </li>
                    @endif
                </ul>
            </li>

            <!--<li class="heading">
                <h3 class="uppercase">Module</h3>
            </li>-->
            
            @if($userType=="Super" || checkAuthorize('users','read_access') )
            <li class="nav-item">
                <a href="{{route(config('project.admin_route').'users.index')}}" class="nav-link nav-toggle">
                    <i class="icon-user"></i>
                    <span class="title">Users Management</span>
                </a>
            </li>
            @endif

            @if( $userType=="Super" || checkAuthorize(array('employee','levelmodule'),'read_access'))
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">Employee Mgt.</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @if($userType=="Super" || checkAuthorize('employee','read_access') )
                    <li class="nav-item start">
                        <a href="{{route(config('project.admin_route').'employee.index')}}" class="nav-link">
                            <i class="icon-user-following"></i>
                            <span class="title">All Employees</span>
                        </a>
                    </li>
                    @endif
                    @if($userType=="Super" || checkAuthorize('levelmodule','read_access') )
                    <li class="nav-item">
                         <a href="{{route(config('project.admin_route').'levelmodule.create')}}" class="nav-link">
                            <i class="icon-layers"></i>
                            <span class="title">Manage Level Rights</span>
                        </a>
                    </li>
                    @endif
                    
                </ul>
            </li>
            @endif
            
            @if($userType=="Super" || checkAuthorize('messagelist','messagefolder','read_access') )
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-envelope"></i>
                    <span class="title">Message center</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @if($userType=="Super" || checkAuthorize('messagelist','read_access') )
                    <li class="nav-item start">
                        <a href="{{route(config('project.admin_route').'messagelist.index')}}" class="nav-link">                            
                            <span class="title">Messages</span>
                        </a>
                    </li>    
                    @endif
                    @if($userType=="Super" || checkAuthorize('messagefolder','read_access') )
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'messagefolder.index')}}" class="nav-link">
                            <span class="title">Manage Folder names </span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if($userType=="Super" || checkAuthorize('module','level','products','country','attributeset','attribute','occasions','read_access') ) 
            <li class="nav-item">
                <a href="{{route('underConstruction')}}" class="nav-link nav-toggle">
                    <i class="icon-basket"></i>
                    <span class="title">Master</span>
                    <span class="arrow"></span>
                </a>

                <ul class="sub-menu">
                    @if($userType=="Super" || checkAuthorize('category','read_access') ) 
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'category.index')}}" class="nav-link">
                            <span class="title">Categories</span>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'module.index')}}" class="nav-link">
                            <span class="title">Manage Module</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'level.index')}}" class="nav-link">
                            <span class="title">Manage Level</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'categories.index')}}" class="nav-link">
                            <span class="title">Product Categories</span>
                        </a>
                    </li> -->
                  
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'country.index')}}" class="nav-link">
                            <span class="title">Countries</span>
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'attributeset.index')}}" class="nav-link">
                            <span class="title">Attribute Set</span>
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'attribute.index')}}" class="nav-link">
                            <span class="title">Attribute</span>
                        </a>
                    </li>
                    @if($userType=="Super" || checkAuthorize('occasions','read_access') )
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <span class="title">Products By Occasion</span>
                            <span class="arrow"></span>
                        </a>                        
                        <ul class="sub-menu" >
                            <li class="nav-item">
                                <a href="{{route(config('project.admin_route').'occasions.index')}}" class="nav-link">
                                    <span class="title">Occasions Listing</span>
                                </a>
                            </li>                            
                            <li class="nav-item">
                                <a href="{{route(config('project.admin_route').'occasions.create')}}" class="nav-link">
                                    <span class="title">Add New Occasion</span>
                                </a>
                            </li>                            
                        </ul>
                    </li>
                    @endif
                    @if($userType=="Super" || checkAuthorize('conditions','read_access') )
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <span class="title">Products Conditions</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item">
                                <a href="{{route(config('project.admin_route').'product_conditions.index')}}" class="nav-link">
                                    <span class="title">Conditions Listing</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route(config('project.admin_route').'product_conditions.create')}}" class="nav-link">
                                    <span class="title">Add New Condition</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
@if($userType=="Super" || checkAuthorize('category','read_access') ) 
            <li class="nav-item">
                <a href="{{route('underConstruction')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Catalog</span>
                    <span class="arrow"></span>
                </a>
                
                <ul class="sub-menu">                    
                    @if($userType=="Super") 

                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link">
                            <span class="title">Manage General Products</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link">
                            <span class="title">Manage Preview Request Product</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link">
                            <span class="title">Manage Classified Services</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link">
                            <span class="title">Requested Products</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link">
                            <span class="title">Reported Products</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
@endif
            @if($userType=="Super" || checkAuthorize('giftcards','read_access') )
            <li class="nav-item">                
                <a href="{{URL('admin/giftcards')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Manage Gift Cards</span>
                </a>
            </li>
            @endif
            
            @if($userType=="Super" || checkAuthorize('advertisements','read_access') )
            <li class="nav-item">
                <a href="{{route(config('project.admin_route').'advertisements.index')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Advertisements</span>
                    <span class="arrow"></span>
                </a>
                
                <ul class="sub-menu">
                    @if($userType=="Super" || checkAuthorize('advertisements','read_access'))
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'advertisements.index')}}" class="nav-link">
                            <span class="title">All Advertisements</span>
                        </a>
                    </li>
                    @endif 
                    
                    @if($userType=="Super" || checkAuthorize('pendingadv','read_access'))
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'adver.pendingadv')}}" class="nav-link">
                            <span class="title">Pending Advertisements</span>
                        </a>
                    </li>
                    @endif
                    
                    @if($userType=="Super" || checkAuthorize('settingsadv','read_access') )
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'adver.settingsadv')}}" class="nav-link">
                            <span class="title">Settings</span>
                        </a>
                    </li>
                    @endif
                    
                    @if($userType=="Super" || checkAuthorize('create_advertisement','read_access') )
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'advertisements.create')}}" class="nav-link">
                            <span class="title">Post New Advertisement</span>
                        </a>
                    </li>
                    @endif                    
                </ul>                
            </li>
            @endif

            @if($userType=="Super" || checkAuthorize('fileuploads','read_access') )
            <li class="nav-item">
                <a href="{{route(config('project.admin_route').'fileuploads.index')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">File Storage</span>
                </a>
            </li>
            @endif
            @if($userType=="Super" || checkAuthorize('underConstruction','read_access') )
            <li class="nav-item">
                <a href="{{route('underConstruction')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Order Management</span>
                </a>
            </li>
            @endif
            @if($userType=="Super" || checkAuthorize(array('content_pages','faq','terms_and_conditions','secret_questions', 'email_templates'),'read_access') )
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Content Management</span>
                    <span class="arrow"></span>
                </a>
                
                <ul class="sub-menu">
                    @if($userType=="Super" || checkAuthorize('content_pages','read_access') )
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'content_pages.index')}}" class="nav-link">
                            <span class="title">Manage Pages</span>
                        </a>
                    </li>
                    @endif
                    @if($userType=="Super" || checkAuthorize('faq','read_access'))
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'faq.index')}}" class="nav-link">
                            <span class="title">Manage FAQs</span>
                        </a>
                    </li>
                    @endif
                    @if($userType=="Super" || checkAuthorize('terms_and_conditions','read_access') )
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'terms_and_conditions.index')}}" class="nav-link">
                            <span class="title">Manage Terms & Conditions</span>
                        </a>
                    </li>
                    @endif
                    @if($userType=="Super" || checkAuthorize('email_templates','read_access') )
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'email_templates.index')}}" class="nav-link">
                            <span class="title">Mange Templates</span>
                        </a>
                    </li>
                    @endif
                    @if($userType=="Super" || checkAuthorize('secret_questions','read_access') )
                    <li class="nav-item">
                        <a href="{{route(config('project.admin_route').'secret_questions.index')}}" class="nav-link">
                            <span class="title">Secret Questions</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            
            @if($userType=="Super" || checkAuthorize('newsletters','read_access') )
            <li class="nav-item">
                <a href="{{route(config('project.admin_route').'newsletters.index')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Newsletters</span>
                </a>
            </li>
            @endif
            @if($userType=="Super" || checkAuthorize('global_setting','read_access') )    
            <li class="nav-item">
                <a href="{{route('showGlobalSettingForm')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Global Settings</span>
                </a>
            </li>
            @endif
            @if($userType=="Super" || checkAuthorize('underConstruction','read_access') )
            <li class="nav-item">
                <a href="{{route('underConstruction')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Manage Subscription</span>
                </a>
            </li>
            @endif
            
            @if($userType=="Super" || checkAuthorize(array('commissionfees'),'read_access'))
            <li class="nav-item">
                <a href="javascript:;" class="nav-link ">
                    <i class="icon-diamond"></i>
                    <span class="title">Manage Commission & Fees</span>
                </a>

                <ul class="sub-menu">
                    @if($userType=="Super" || checkAuthorize(array('commissionfees'),'read_access'))
                    <li class="nav-item">
                        <a href="{{route('commissionFeesList', 'Products')}}" class="nav-link">
                            <span class="title">Products</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('commissionFeesList', 'Services')}}" class="nav-link ">
                            <span class="title">Services</span>
                        </a>
                    </li>
                    @endif    
                </ul>
            </li>
            @endif
            
            @if($userType=="Super" || checkAuthorize('underConstruction','read_access') )
            <li class="nav-item">
                <a href="{{route(config('project.admin_route').'vendors.index')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Manage Vendors</span>
                </a>
            </li>
            @endif
            @if($userType=="Super" || checkAuthorize('underConstruction','read_access') )
            <li class="nav-item">
                <a href="{{route('underConstruction')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Auction</span>
                </a>
            </li>
            @endif
            @if($userType=="Super" || checkAuthorize(array('promotions'),'read_access'))
                <li class="nav-item">
                    <a href="{{route(config('project.admin_route').'promotions.index')}}" class="nav-link">
                        <i class="icon-diamond"></i>
                        <span class="title">Promotions</span>
                    </a>
                </li>            
            @endif
            @if($userType=="Super" || checkAuthorize('donationvendors','read_access') )
            <li class="nav-item">
                <a href="{{route(config('project.admin_route').'donationvendors.index')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Donation</span>
                </a>
            </li>
            @endif
            @if($userType=="Super" || checkAuthorize('underConstruction','read_access') )
            <li class="nav-item">
                <a href="{{route('underConstruction')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Survey</span>
                </a>
            </li>
            @endif
            @if($userType=="Super" || checkAuthorize('underConstruction','read_access') )
            <li class="nav-item">
                <a href="{{route('underConstruction')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Site Stores</span>
                </a>
            </li>
            @endif
            @if($userType=="Super" || checkAuthorize('forums','read_access') )
            <li class="nav-item">
                <a href="{{route(config('project.admin_route').'forums.index')}}" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Forum</span>
                </a>
            </li>
            @endif

            <!--            <li class="nav-item">
                            <a href="{{route(config('project.admin_route').'categories.index')}}" class="nav-link">
                                <i class="icon-diamond"></i>
                                <span class="title">Categories</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="{{route(config('project.admin_route').'categories.index')}}" class="nav-link ">
                                        <span class="title">Categories listing</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route(config('project.admin_route').'categories.create')}}" class="nav-link ">
                                        <span class="title">Add category</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
            
            
                        <li class="nav-item">
                            <a href="{{route('underConstruction')}}" class="nav-link nav-toggle">
                                <i class="icon-diamond"></i>
                                <span class="title">Products</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="{{route(config('project.admin_route').'products.index')}}" class="nav-link ">
                                        <span class="title">Products listing</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route(config('project.admin_route').'products.create')}}" class="nav-link ">
                                        <span class="title">Add Product</span>
                                    </a>
                                </li>
                            </ul>
                        </li>-->




        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
<script>
window.onload = function(e){     
    currentPath='<?php echo $currentPath; ?>';
    currentModulePath='<?php echo $currentModulePath; ?>';
    
    //currentPath=location.protocol + '//' + location.host + location.pathname;    
    $selectedElement=$('.page-sidebar-menu').find('a[href="'+currentPath+'"]').parent();    
    if(!$selectedElement.html()){        
        $selectedElement=$('.page-sidebar-menu').find('a[href="'+currentModulePath+'"]').parent();
    }
    $selectedElementLevel=$selectedElement.data('level');
    $selectedElement.addClass('open');
    var numberoflevels=$('.page-sidebar-menu').data('levels')-1;
    for(i=0;i<numberoflevels;i++){    

        $secondElement=$selectedElement.parent('ul').parent('li');
        if($secondElement.html()){
            $selectedElement.parent('ul').show();
            $secondElement.addClass('open');
            $secondElement.find('span.arrow').addClass('open');
            $selectedElement=$secondElement;
        }
    }
}
</script>