<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

//$laravel = app();echo $version = $laravel::VERSION;die;
//echo "<pre>";print_r(url()->current());print_r(url()->full());print_r(url()->previous());die;

/*
  |--------------------------------------------------------------------------
  | ADMIN Routes
  |--------------------------------------------------------------------------
 */

Route::group(['prefix' => config('project.admin_prefix'), 'namespace' => 'Admin'/* , 'middleware' => 'admin' */], function () {

    //When attaching the auth middleware to a route, you may also specify which guard should be used to perform the authentication:
    Route::group(['middleware' => ['auth:admin', 'roles:admin']], function() {
        

        //used in /app/Http/Middleware/Authenticate.php (if admin user not loggedin then redirect to admin login page)
        Route::get('notifications', ['uses' =>'NotificationsController@index','as'=>'admin.home.notifications']) ;
        Route::post('notifications/datatableList', 'NotificationsController@datatableList')->name('notificationsListing');
        Route::get('/', ['uses' =>'AuthAdminController@index','as'=>'admin.home.index']);


        Route::post('/pdf', ['uses' =>'filesController@pdf','as'=>'file.pdf']);
        


//        Route::get('/test/{squirrel}', ['uses' =>'SomeController@doSomething', 'as'=>'routeName']);
//        Route::get('/test/{squirrel}', ['uses' =>'SomeController@doSomething']);
        
        /*
         * Demo Category
         */
        Route::resource('categories', 'DemoCategoriesController');
        Route::post('categories/datatableList', 'DemoCategoriesController@datatableList')->name('adminCategoriesListing');

        /*
         * Employee Departments
         */
        Route::resource('departments', 'EmployeeDepartmentsController');
        Route::post('departments/datatableList', 'EmployeeDepartmentsController@datatableList')->name('adminDepartmentsListing');

        /*
          Forums
         *          */
        Route::resource('forums', 'ForumsController');
        Route::post('forums/datatableList', 'ForumsController@datatableList')->name('adminForumsListing');
        Route::post('forums/datatableList/comments/{id}', 'ForumsController@CommentDatatable')->name('commentForumsListing');
        Route::get('forums/{id}/comments', ['uses' =>'ForumsController@GetCommentsIndex','as'=>'admin.ForumsComments']);
        Route::get('forums/{id}/reports', ['uses' =>'ForumsController@GetReportsTopics','as'=>'admin.ForumsReportsTopics']);
        Route::post('forums/{id}/reportsdatatable', ['uses' =>'ForumsController@ReportTpoicDatatable','as'=>'admin.ForumsReportsTopicsDatatables']);

        Route::get('forums/{id}/comments/{comment}/reports', ['uses' =>'ForumsController@GetCommentReports','as'=>'admin.ForumsCommentReports']);
        Route::post('forums/{id}/comments/{comment}/reportsDatatable', ['uses' =>'ForumsController@GetCommentReportsDatatable','as'=>'admin.ForumsCommentReportsDatatable']);



        //Route::get('forums/{id}/comments', 'ForumsController@GetCommentsIndex')->name('ForumsComments');

        /*
         * File Labls
         */
        Route::resource('labels', 'FileLabelsController');
        Route::post('labels/datatableList', 'FileLabelsController@datatableList')->name('adminLabelsListing');
        
        /*
         * File FileUploads
         */
        Route::resource('fileuploads', 'FileUploadsController');
        Route::post('fileuploads/datatableList', 'FileUploadsController@datatableList');
        
        /*
         * File FileUploads
         */
        Route::resource('donationvendors', 'DonationVendorsController');
        Route::post('donationvendors/datatableList', 'DonationVendorsController@datatableList')->name('adminDonationVendorListing');
        /*
          Vendors
         *          */
        Route::resource('vendors', 'VendorsController');
        Route::post('vendors/datatableList', 'VendorsController@datatableList')->name('adminVendorsListing');

        /*
          Transections
         *          */
        Route::get('transactions/create/{id}', 'TransactionsController@create');
        Route::resource('transactions', 'TransactionsController');
        Route::post('trasanction/datatableList/', 'TransactionsController@datatableList')->name('adminTransactionsListing');
        
        /*
         * Category
         */                
        Route::get('category/getdynamicchildajax', 'CategoriesController@getdynamicchildajax')->name('getdynamicchilddropdown');
        Route::get('category/getnode', 'CategoriesController@getNode');
        Route::get('category/getContent/{id}', 'CategoriesController@getContent');
        Route::get('category/createnode', 'CategoriesController@create');
        Route::get('category/renamenode', 'CategoriesController@renameNode');
        Route::get('category/deletenode/{id}', 'CategoriesController@destroy');
        Route::get('category/movenode/{id}/{parentId}', 'CategoriesController@moveNode');
        Route::get('category/copynode/{id}/{parentId}', 'CategoriesController@copyNode');
        Route::get('category/togglestatus/{id}', 'CategoriesController@toggleCategoryStatus');
        Route::resource('category', 'CategoriesController');

        /*
         * Manage commissions & fees | scope: Products or Services
         */
        Route::get('commissionfees/{scope}', 'CategoriesController@commissionFeesList')->name('commissionFeesList');
        Route::post('commissionfees/{scope}', 'CategoriesController@datatableCommissionFeesList')->name('datatableCommissionFeesList');
        Route::get('commissionfees/{id}/{scope}/edit', 'CategoriesController@editCommissionFees')->name('editCommissionFees');
        Route::patch('commissionfees/{id}/{scope}', 'CategoriesController@updateCommissionFees')->name('updateCommissionFees');
        
        /*
         * Product
         */
        Route::post('products/datatableList', ['uses' =>'ProductsController@datatableList','as'=>'admin.products.datatableList']);
        Route::get('products/uploadimage/{id}', ['uses' =>'ProductsController@getImage','as'=>'admin.products.uploadImage']);
        Route::post('products/uploadimage/{id}', ['uses' =>'ProductsController@uploadImage','as'=>'admin.products.uploadImage']);
        Route::DELETE('products/deleteimage/{id}', ['uses' =>'ProductsController@deleteImage','as'=>'admin.products.deleteImage']);        
        Route::resource('products', 'ProductsController');                
        Route::post('fileuploads/datatableList', ['uses' =>'FileUploadsController@datatableList','as'=>'admin.fileuploads.datatableList']);        
        /*
         * Giftcards
         */
        Route::post('giftcards/datatableList', 'GiftCardsController@datatableList')->name('giftcardsDatatableList');
        Route::resource('giftcards', 'GiftCardsController');        
        /*
         * Occasions
         */
        Route::post('occasions/removeImage', ['uses' =>'ImageController@removeImage','as'=>'image.removeImage']);
        Route::post('occasions/image/uploader', ['uses' =>'ImageController@upload','as'=>'image.uploader']);
        Route::post('occasions/datatableList', 'OccasionsController@datatableList')->name('occasionsDatatableList');        
        Route::resource('occasions', 'OccasionsController');
        
        /*
         * conditions
         */
        Route::post('product_conditions/datatableList', 'ProductConditions@datatableList')->name('ProductConditionsDatatableList');        
        Route::resource('product_conditions', 'ProductConditionsController');
        
        /*
         * conditions
         */
        //Route::post('promotions', 'ProductConditions@datatableList')->name('ProductConditionsDatatableList');                
        Route::get('promotions/getprmotionusers/{id}', 'PromotionsController@getPrmotionUsers');
        Route::resource('promotions', 'PromotionsController');
        
        
        //implicit model binding
        Route::get('/getAllUser', function () {                                    
            return App\Models\User::select('id',\DB::RAW('concat(first_name," ",last_name) as `text`'))
                    ->where('status','Active')
                    ->where('user_type','Buyer')
                    ->having('text','like','%'.request()->get('q').'%')
                    ->get(array('id',\DB::RAW('concat(first_name," ",last_name) as text')));            
        });
        
        //Get Notifications
        Route::post('getnotifications', 'NotificationsController@getNotifications');
        Route::post('readnotifications', 'NotificationsController@readNotifications');        
        
        /*
         * User
         */
        //Route::resource('users', 'DemoUsersController');

        Route::get('tasks', 'TaskController@index');

        /*
         * Levels
         */
        Route::resource('create_level__access', 'LevelsController');
        Route::post('create_level__access/datatableList', 'LevelsController@datatableList')->name('adminLevelListing');

        Route::resource('levelmodule', 'LevelmoduleController');
        Route::post('levelmodule/datatableList', 'LevelmoduleController@datatableList')->name('adminLevelmoduleListing');

        //admin logout
        Route::get('logout', 'AuthAdminController@logout')->name('adminLogout'); // admin/logout
        //admin profile update
        //Route::get('profile', 'AuthAdminController@profile')->name('admin_profile');// admin/logout

        Route::resource('country', 'CountryController');
        Route::resource('state', 'StateController');
        Route::resource('module', 'ModuleController');
        Route::resource('level', 'LevelController');
        
        /*
         * Attribute management for items
         */
        Route::resource('attributeset', 'AttributeSetController');
        Route::post('attributeset/datatableList', 'AttributeSetController@datatableList')->name('adminAttributeSetListing');

        Route::resource('attribute', 'AttributeController');
        Route::post('attribute/datatableList', 'AttributeController@datatableList')->name('adminAttributeListing');
        /*
         * Employee registration
         */
        Route::get('employee/block', ['uses' =>'EmployeeController@block', 'as'=>'admin.employee.block']);
        Route::get('employee/unblock', ['uses' =>'EmployeeController@unblock', 'as'=>'admin.employee.unblock']);
        Route::resource('employee', 'EmployeeController');
        Route::post('employee/datatableList', 'EmployeeController@datatableList')->name('employeeListing');
        Route::get('register/verify/{confirmationCode}', 'EmployeeController@confirm');
                
        /*
         * FAQ
         */
        Route::resource('faq', 'FaqController');
        Route::post('faq/datatableList', 'FaqController@datatableList')->name('faqTopicsListing');
        Route::delete('faqtopic/{id}', array('uses' => 'FaqController@destroyFaqTopic', 'as' => 'destroyFaqTopic'));


        /*
         * Terms & Conditions
         */
        Route::resource('terms_and_conditions', 'TermAndConditionController');
        Route::post('terms_and_conditions/datatableList', 'TermAndConditionController@datatableList')->name('adminTermsAndConditionsListing');

        /*
         * Content Pages
         */
        Route::get('content_pages/preview', 'ContentPageController@preview')->name('content_pages_preview');
        Route::resource('content_pages', 'ContentPageController');
        Route::get('content/{id}', 'ContentPageController@getPost')->name('getPost');            
        Route::post('content_pages/datatableList', 'ContentPageController@datatableList')->name('adminContentPagesListing');

        /*
         * Global Settings
         */
        Route::group(['prefix' => 'global_setting'], function () {
            Route::get('/', 'GlobalSettingController@showGlobalSettingForm')->name('showGlobalSettingForm');
            Route::post('make_an_offer_setting', 'GlobalSettingController@postMakeAnOfferSetting')->name('postMakeAnOfferSetting');

            Route::post('reward_point_setting', 'GlobalSettingController@postRewardPointSetting')->name('postRewardPointSetting');
            Route::get('reward_point_setting_logs', 'GlobalSettingController@getRewardPointSettingLog')->name('getRewardPointSettingLog');
            Route::get('reward_point_setting_popup_logs', 'GlobalSettingController@getRewardPointSettingLogPopup')->name('getRewardPointSettingLogPopup');

            Route::post('shipping_carrier_setting/{id}', 'GlobalSettingController@postShippingCarrierSetting')->name('postShippingCarrierSetting');
            Route::get('shipping_carrier_setting_logs/{id}', 'GlobalSettingController@getShippingCarrierSettingLog')->name('getShippingCarrierSettingLog');
            Route::get('shipping_carrier_setting_popup_logs/{id}', 'GlobalSettingController@getShippingCarrierSettingLogPopup')->name('getShippingCarrierSettingLogPopup');

            Route::post('save_product_settings', 'GlobalSettingController@postProductSetting')->name('postProductSetting');
        });

        /*
         * Secret Question
         */
        Route::resource('secret_questions', 'SecretQuestionController', ['except' => ['show', 'edit', 'update']]);
        Route::post('secret_questions/datatableList', 'SecretQuestionController@datatableList')->name('adminSecretQuestionsListing');

        /*
         * Newsletter
         */
        Route::resource('newsletters', 'NewsletterController', ['except' => ['show']]);
        Route::post('newsletters/datatableList', 'NewsletterController@datatableList')->name('adminNewslettersListing');
        Route::get('newsletters/resendNewsletter/{id}', 'NewsletterController@resendNewsletter')->name('adminResendNewsletter');

        /*
         * Under construction page
         */
        Route::get('under_construction', 'DashboardController@underConstruction')->name('underConstruction');
        /*
         * Messages
         */
        
        Route::post('messagelist/getMessages', ['uses' =>'MessageListController@getMessages', 'as'=>'admin.messagelist.getMessages']);
        Route::post('messagelist/reply_msg', ['uses' =>'MessageListController@reply_msg', 'as'=>'admin.messagelist.reply_msg']);
        Route::post('messagelist/move_to', ['uses' =>'MessageListController@move_to', 'as'=>'admin.messagelist.move_to']);
        Route::post('messagelist/mark_as', ['uses' =>'MessageListController@mark_as', 'as'=>'admin.messagelist.mark_as']);
        Route::post('messagelist/delete', ['uses' =>'MessageListController@delete', 'as'=>'admin.messagelist.delete']);
        Route::get('messagelist/inbox1', ['uses' =>'MessageListController@inbox1', 'as'=>'admin.messagelist.inbox1']);
        Route::get('messagelist/view_msg', ['uses' =>'MessageListController@view_msg', 'as'=>'admin.messagelist.view_msg']);
        Route::get('messagelist/sent', ['uses' =>'MessageListController@sent', 'as'=>'admin.messagelist.sent']);
        Route::get('messagelist/draft', ['uses' =>'MessageListController@draft', 'as'=>'admin.messagelist.draft']);
        Route::get('messagelist/trash', ['uses' =>'MessageListController@trash', 'as'=>'admin.messagelist.trash']);
        
        Route::get('messagelist/inbox/{user_type}', ['uses' =>'MessageListController@inbox', 'as'=>'admin.messagelist.inbox']);
        Route::get('messagelist/folder/{name}', ['uses' =>'MessageListController@folder', 'as'=>'admin.messagelist.folder']);
        
        Route::resource('messagelist', 'MessageListController');
        Route::post('messagelist/datatableList', 'MessageListController@datatableList')->name('messageListing');
              
        Route::resource('messagefolder', 'MessageFolderController');
        Route::post('messagefolder/datatableList', 'MessageFolderController@datatableList')->name('messagefolderListing');
        Route::post('messagefolder/show',['uses' =>'MessageListController@show', 'as'=>'admin.messagefolder.show']);
               
        ///Advertisements        
        Route::get('adver/checkavailabledate', 'AdvertisementController@checkavailabledate')->name( 'getavailabledate' );
        Route::get('adver/approve_advr', ['uses' =>'AdvertisementController@approve_advr', 'as'=>'admin.adver.approve_advr']);
        Route::get('adver/pendingadv', ['uses' =>'AdvertisementController@pendingadv', 'as'=>'admin.adver.pendingadv']);
        Route::post('adver/datatableListPendingadv', 'AdvertisementController@datatableListPendingadv')->name('pendingadvadvertisementListing');
              
        Route::post('adver/datatableList', 'AdvertisementController@datatableList')->name('advertisementListing');        
        Route::get('adver/settingsadv', ['uses' =>'AdvertisementController@settingsadv', 'as'=>'admin.adver.settingsadv']);                
        Route::post('adver/insertsetting', ['uses' =>'AdvertisementController@insertsetting', 'as'=>'admin.adver.insertsetting']);       
        Route::resource('adver', 'AdvertisementController');    
        Route::resource('advertisements', 'AdvertisementController');
        
        /*
         * Users Management
         */
        //Route::get('users', ['uses' => 'UsersController@index', 'as' => 'admin.users.index']);
        Route::resource('users', 'UsersController');
        Route::patch('verifyUser/{id}', 'UsersController@verifyUser')->name("verifyUser");
        Route::patch('changeUserStatus/{id}/{status}', 'UsersController@changeUserStatus')->name("changeUserStatus");
        Route::post('users/datatableList', 'UsersController@datatableList')->name('usersListing');
        
        /*
         * Email template
         */
        Route::resource('email_templates', 'EmailTemplatesController');
        Route::post('email_templates/datatableList', 'EmailTemplatesController@datatableList')->name('emailTemplatesDatatableList');
    });
        
    //admin login
    Route::get('login', 'AuthAdminController@showLoginForm')->name('adminLogin'); // admin/login
    Route::post('login', 'AuthAdminController@postLogin')->name('adminLogin');
            
    /*
     * Forgot password
     */
    Route::get('forgot-password', 'AuthAdminController@showForgotPasswordForm')->name('forgotPassword');
    Route::post('forgot-password', 'AuthAdminController@postForgotPassword')->name('postForgotPassword');

    /*
     * Reset Password
     */
    Route::get('reset-password/{token}', 'AuthAdminController@showResetPasswordForm')->name('resetPassword');
    Route::post('reset-password', 'AuthAdminController@postResetPassword')->name('postResetPassword');

    Route::get('refereshCaptcha', 'AuthAdminController@refereshCaptcha')->name('refereshCaptcha');

    
    
    /*
     * Auto suggestion for users in message module
     */    
    Route::get('autocomplete', 'MessageListController@autocomplete')->name('autocomplete');
    Route::get('addfolder', 'MessageListController@addfolder')->name('addfolder');
        
});

use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Input;
use App\Models\Vendors;
use App\Models\Category;
/*
 * state drop down
 */
Route::get('/information/create/ajax-state', function() {
    $country_id = Input::get('country_id');
    $subcategories = State::where('country_id', '=', $country_id)->get();
    return $subcategories;
});
/*
 * City drop down
 */
Route::get('/information/create/ajax-city', function() {
    $state_id = Input::get('state_id');
    $subcategories = City::where('state_id', '=', $state_id)->get();
    return $subcategories;
});
Route::get('/information/getvendors/ajax-state', function() {
    $vendor_types_id = Input::get('vendor_types_id');
    $vendors = Vendors::where('vendor_types_id', '=',$vendor_types_id)->get();
    return $vendors;
});
Route::get('/information/getvendorsacccount/ajax-state', function() {
    $vendor = Input::get('id');
    $vendors = Vendors::where('id', '=',$vendor)->get();
    return $vendors;
});

Route::get('/information/getsubcategory/ajax-subcat', function() {
    $category_obj = new Category();
    $cat_id = Input::get('cat_id');
    $categories = $category_obj->getChildNode($cat_id);
    //print_r($categories[0]['children']);
    return $categories[0]['children'];
});

//come here when click on toggle
Route::get('setSidebarOpenClose', function (){
    $state = Input::get('state');
    setToggelState($state);
    return response()->json(['status' => 'success']);
})->name('setSidebarOpenClose');
//end

/*
  |--------------------------------------------------------------------------
  | FRONT Routes
  |--------------------------------------------------------------------------
 */
##Route::group(['middleware' => 'web'], function () {

Route::get('/', function () {
    return view('front.welcome');
});


Route::get('home', 'HomeController@index');
Route::get('unsubscribe/{id}', 'HomeController@unsubscribeNewsletter')->name('unsubscribeNewsletter');

// ref link: https://mattstauffer.co/blog/middleware-groups-in-laravel-5-2, https://mattstauffer.co/blog/the-auth-scaffold-in-laravel-5-2
Route::auth();

Route::group(['before' => 'middleware-one'], function () {
    Route::get('test-filter', function () {
        return "Test Filter";
    });
});
