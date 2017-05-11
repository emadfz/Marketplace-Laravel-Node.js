<?php

use Carbon\Carbon;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
// users, admin_users
use App\Models\User;
use App\Models\AdminUser;

/* Event for notification email, alert, sms */
use App\Events\SendMail;
use App\Models\EmailTemplate;

//Pass only object and edit deleted will be apended accordingly with authorization
function getAuthorizedButton($data) {          
    if(!isset($data) || empty($data) ){
        return $data = collect($data);        
    }
    if(is_array($data)){
        $data = collect($data);        
    }
    if( $data->count() < 1 )
    {
        return $data ;
    }
    $moduleName = getCurrentModuleName();

    $update_access=checkAuthorize($moduleName,'update_access');
    $delete_access=checkAuthorize($moduleName,'delete_access');
    
    if(isset($data[0])){
        foreach ($data as $key => $val) {        
            $data[$key]->action='';
            if($update_access==1){
                $data[$key]->action = '<a href="' . route(config('project.admin_route') .$moduleName.'.edit', encrypt($val->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>';
            }
            if ($delete_access == 1) {
                $data[$key]->action.='&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o delete' . ucfirst($moduleName) . '" data-toggle="modal" data-placement="top" title="Delete" data-' . $moduleName . '_delete_remote="' . route(config('project.admin_route') . $moduleName . '.destroy', encrypt($val->id)) . '"></a>';
            }
        }
   }
   else{                             
            $data->action='';
            if($update_access==1){
                $data->action = '<a href="' . route(config('project.admin_route') .$moduleName.'.edit', encrypt($data->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>';
            }
            if ($delete_access == 1) {
                $data->action.='&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o delete' . ucfirst($moduleName) . '" data-toggle="modal" data-placement="top" title="Delete" data-' . $moduleName . '_delete_remote="' . route(config('project.admin_route') . $moduleName . '.destroy', encrypt($data->id)) . '"></a>';
            }    
            return $data->action;
   }
   return $data;
}

function checkAuthorize($moduleName, $operationName) {

    if (\Auth::guard('admin')->user()->first_name == "Super") {
        return true;
    }
    GLOBAL $modulesWithLevelAcess;
    if (!isset($modulesWithLevelAcess)) {
        $modulesWithLevelAcess = \App\Models\Levelmodule::getLevelModulesByLevelId(Auth::guard('admin')->user()->role_id);
        $modulesWithLevelAcess = array_combine(array_column($modulesWithLevelAcess, "module_name"), $modulesWithLevelAcess);
    }
    if (count($moduleName) > 1) {
        foreach ($moduleName as $modName) {
            if (@$modulesWithLevelAcess[$modName][$operationName] == 1) {
                return true;
            }
        }
    } else {
        if (@$modulesWithLevelAcess[$moduleName][$operationName] == 1) {
            return true;
        }
    }
    return false;
}

function getCreateButton() {
    $moduleName = getCurrentModuleName();
    if (checkAuthorize($moduleName, 'create_access') != 1) {
        return '';
    }
    return '<div class="actions pull-left" style="margin-left:2%;">
                    <div class="btn-group">
                        <a href= "' . route(config('project.admin_route') . $moduleName . '.create') . '" class="btn sbold default">' . trans("form." . $moduleName . ".create") . ' &nbsp;<i class="fa fa-plus"></i></a>
                    </div>
                </div>';
}

function uploadImage($files, $is_thumbnail = false, $old_image = '', $crop = array(), $moduleName = '') {
    try {
        if (empty($moduleName)) {
            $moduleName = getCurrentModuleName();
        }

        $path = public_path() . '/images/' . $moduleName . '/';
        if (isset($old_image) && !empty($old_image)) {
            $main = $path . '/main/' . $old_image;
            $small = $path . '/small/' . $old_image;
            $thumbnail = $path . '/thumbnail/' . $old_image;
            $documents = $path . '/documents/' . $old_image;
            if (file_exists($main)) {
                unlink($main);
            }
            if (file_exists($small)) {
                unlink($small);
            }
            if (file_exists($thumbnail)) {
                unlink($thumbnail);
            }
            if (file_exists($documents)) {
                unlink($documents);
            }
        }

        foreach ($files as $file) {
            //getting timestamp
            $name = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString() . '-' . $file->getClientOriginalName());
            $imagetype = explode('/', $file->getClientMimeType());
            if (in_array($imagetype[count($imagetype) - 1], array('jpeg','jpg', 'gif', 'png'))) {
                $type = 'images';
            } else if (in_array($imagetype[count($imagetype) - 1], array('pdf'))) {
                $type = 'documents';
            } else {
                return 'there is some error while uploading file';
            }
            //$name = $timestamp . '.' . $imagetype[count($imagetype) - 1];
            //$name = $timestamp . '.' . $imagetype[count($imagetype) - 1];


            if (!is_dir($path)) {
                mkdir($path);
                chmod($path, 0777);
            }

            if ($type == 'images') {
                $mainPath = $path . 'main/';
                if (!is_dir($mainPath)) {
                    mkdir($mainPath);
                    chmod($mainPath, 0777);
                }
                $file->move($path . '/main', $name);

                if ($is_thumbnail == true) {
                    $smallPath = $path . 'small/';
                    if (!is_dir($smallPath)) {
                        mkdir($smallPath);
                        chmod($smallPath, 0777);
                    }

                    $thumbnailPath = $path . 'thumbnail/';
                    if (!is_dir($thumbnailPath)) {
                        mkdir($thumbnailPath);
                        chmod($thumbnailPath, 0777);
                    }

                    //small image
                    $img = \Image::make($path . '/main/' . $name);



                    //IMAGE CROPPING FEATURE
                    //$img->resize(640, 480);
                    //if(isset($crop) && count($crop)>0){                             
//                        $crop['w']=round($crop['w']*640/304);                                
//                        $crop['h']=round($crop['h']*480/304);                                
                    //$crop['w']=round($crop['w']*$img->getWidth()/304);
                    //$crop['w']=round($crop['w']*$img->getWidth()/304);
//                        $crop['w']=round($crop['w']*$img->getWidth()/304);
//                        $crop['h']=round($crop['h']*$img->getHeight()/304);                                
//                        $crop['x1']=round($crop['x1']*$img->getWidth()/304);                                
//                        $crop['y1']=round($crop['y1']*$img->getHeight()/304);              
//                        $img->crop($crop['w'], $crop['h'],$crop['x1'],$crop['y1']);
                    //}
                    // resize image instance
                    //$img->resize(600,450);
                    $img->resize(300,250);
                    // save image in desired format
                    $img->save($path . '/small/' . $name);

                    //small image
                    //thumbnail image
                    $img = \Image::make($path . '/main/' . $name);
                    // resize image instance
                    $img->resize(80, 60);
                    // save image in desired format
//                    if( isset($crop) && count($crop)>0){
//                            $img->crop($crop['w'], $crop['h'],$crop['x1'],$crop['y1']);
//                    }
                    $img->save($path . '/thumbnail/' . $name);
                    //thumbnail image
                }
                $names[] = array('path' => $name, 'file_type' => 'image');
            }
            if ($type == 'documents') {
                $thumbnailPath = $path . 'documents/';
                if (!is_dir($thumbnailPath)) {
                    mkdir($thumbnailPath);
                    chmod($thumbnailPath, 0777);
                }
                //dd($path);
                $file->move($path . '/documents', $name);

                $names[] = array('path' => $name, 'file_type' => 'documents');
            }
        }
        if (count($names) > 1) {
            return $names;
        }

        return $names[0];
    } catch (\Exception $e) {
//        echo $e->getMessage();
//        die;
    }
}

function getImageByPath($imgname, $imageSubFolder = '') {
    $moduleName = getCurrentModuleName();
    return "<img class='img-holder' height='100' width='100'  src='" . URL("/images/" . $moduleName . "/" . $imageSubFolder . "/" . $imgname) . "'/>";
}

function getDocumentPath($path) {
    $moduleName = getCurrentModuleName();
    return URL("/images/" . $moduleName . "/documents/" . $path);
}

function getImageFullPath($imgname, $imageSubFolder = '') {
    $moduleName = getCurrentModuleName();
    return URL("/images/" . $moduleName . "/" . $imageSubFolder . "/" . $imgname);
}

function generateDocumentAnchor($path) {
    return "<a target='_blank' href=" . getDocumentPath($path) . ">" . getDocumentPath($path) . "</a>";
}

function generateDocumentAnchorpreview($path) {
    return "<a target='_blank' href=" . getDocumentPath($path) . " class='fa fa-file-pdf-o'></a>";
}

function getCurrentModuleName() {
    GLOBAL $moduleName;
    if (!isset($moduleName)) {
        $routeSegments = explode('.', \Route::currentRouteName());
        if (count($routeSegments) > 1) {
            $moduleName = $routeSegments[1];
        } else {
            $moduleName = '';
        }
    }
    return $moduleName;
}
function getCurrentOperation(){        
        GLOBAL $operationName;
        if (!isset($operationName)) {
            $routeSegments=explode('.',\Route::currentRouteName());                      
            if(count($routeSegments)>2){
                $operationName=last($routeSegments);
            }
            else{
                $operationName='index';
            }
        }        
        return $operationName;        
}

/* From front side - copied */
if (!function_exists('generateToken')) {

    /**
     * To generate token
     *
     * @param  string  $string (i.e email,username)
     * @return token string
     */
    function generateToken($string = '') {
        return sha1(uniqid("imf", true) . $string . str_random(60));
    }

}

if (!function_exists('convertToDateFormat')) {

    function convertToDateFormat($input, $format = 'Y-m-d') {
        $date = Carbon::parse($input);
        return $date->format($format);
    }

}

if (!function_exists('convertToDatetimeFormat')) {

    function convertToDatetimeFormat($input, $format = 'Y-m-d H:i:s') {
        $datetime = Carbon::parse($input);
        return $datetime->format($format);
    }

}

if (!function_exists('getCurrentDatetime')) {

    function getCurrentDatetime($format = 'Y-m-d H:i:s') {
        return Carbon::now()->format($format);
    }

}

/*
  |--------------------------------------------------------------------------
  | Common master entities
  |--------------------------------------------------------------------------
 */

if (!function_exists('getMasterEntityOptions')) {

    // Used for dropdown
    function getMasterEntityOptions($type = FALSE) {
        if (!$type)
            return FALSE;
        switch ($type) {
            case 'name_title':
                $options = ['' => trans('form.common.select_title'), 'Mr' => 'Mr.', 'Mrs' => 'Mrs.', 'Miss' => 'Miss.'];
                break;
            case 'gender':
                $options = ['' => trans('form.common.select_gender'), 'Male' => 'Male', 'Female' => 'Female', 'Prefer not to say' => 'Prefer not to say'];
                break;
            case 'payment_card_type':
                $options = ['' => trans('form.common.select_card_type'), 'Master' => 'Master', 'Visa' => 'Visa'];
                break;
            case 'position':
                $options = ['' => trans('form.common.select_position'), '1' => 'Position 1', '2' => 'Position 2', '3' => 'Position 3', '4' => 'Position 4', '5' => 'Other'];
                break;
            case 'user_types':
                $options = ['' => trans('form.users.select_user_type'), 'Buyer' => 'Buyer', 'Individual Seller' => 'Individual Seller', 'Business Seller' => 'Business Seller'];
                break;
            case 'user_statuses':
                $options = ['' => trans('form.users.select_status'), 'Active' => 'Active', 'Inactive' => 'Inactive', 'Pending' => 'Pending', 'Blocked' => 'Blocked', 'Verified' => 'Verified'];
                break;
            default :
                $options = FALSE;
        }
        return $options;
    }

}

if (!function_exists('getAllCountries')) {

    function getAllCountries($dropdown = FALSE) {
        $result = Country::select('id', 'country_name', 'country_code')->get(); //->where(['is_deleted' => 0])
        if ($dropdown) {
            $result = $result->pluck('country_name', 'id')->toArray();
        }
        return $result;
    }

}

if (!function_exists('getAllStates')) {

    function getAllStates($countryId, $dropdown = FALSE) {
        $result = State::select('id', 'state_name', 'state_code')->where(['country_id' => $countryId])->get();
        if ($dropdown) {
            $result = $result->pluck('state_name', 'id')->toArray();
        }
        return $result;
    }

}

if (!function_exists('getAllCities')) {

    function getAllCities($stateId, $dropdown = FALSE) {
        $result = City::select('id', 'city_name', 'city_code')->where(['state_id' => $stateId])->get();
        if ($dropdown) {
            $result = $result->pluck('city_name', 'id')->toArray();
        }
        return $result;
    }

}
function unsetImages($imageName,$moduleName='') {    
        if(empty($moduleName)){
                $moduleName = getCurrentModuleName();   
        }
        
        $path = public_path() . '/images/' . $moduleName . '/';
        if (isset($imageName) && !empty($imageName)) {
            $main = $path . '/main/' . $imageName;
            $small = $path . '/small/' . $imageName;
            $thumbnail = $path . '/thumbnail/' . $imageName;
            $documents = $path . '/documents/' . $imageName;
            if (file_exists($main)) {
                unlink($main);
            }
            if (file_exists($small)) {
                unlink($small);
            }
            if (file_exists($thumbnail)) {
                unlink($thumbnail);
            }
            if (file_exists($documents)) {
                unlink($documents);
            }
        }
}
function getImageAbsolutePath($imgname, $imageSubFolder = '') {
    $moduleName = getCurrentModuleName();
    return public_path('images/products/'.$imageSubFolder.'/'.$imgname);            
}


if (!function_exists('sendNotification')) {

    /*
     * Send notification
     * @param $to : id
     * @param $data : replaceable variables array
     * @param $table : users or admin_users
     */

    function sendNotification($template, $toIds=[], $tags=[], $table = 'users') {

        // get template
        $templateData = EmailTemplate::getTemplate(['template_key' => $template]);
        
        if (!empty($templateData) && !empty($toIds)) {

            $toIds = array_unique($toIds);

            foreach ($toIds AS $id) {
                if ($table == 'users') {
                    $user = User::select(['username', 'first_name', 'last_name', 'email'])->where(['id'=>$id])->first(); // where condition
                    $toEmail = $user->email;
                } else if ($table == 'admin_users') {
                    $user = AdminUser::select(['first_name', 'last_name', 'personal_email', 'professional_email'])->where(['id'=>$id])->first(); // where condition
                    $toEmail = $user->personal_email;
                }

                //echo "<pre>";print_r($templateData);echo "<pre>";print_r($user);die;

                $toUserFullname = $tags['TO_NAME'] = $user->first_name . ' ' . $user->last_name;
                $fromName = $tags['FROM_NAME'] = config('mail.from.name');
                $fromEmail = config('mail.from.address');
                $search = $replace = [];

                foreach ($tags AS $k => $v) {
                    array_push($search, "{#{$k}#}");
                    array_push($replace, $v);
                }
                
                $mailData['toName'] = $toUserFullname;
                $mailData['toEmail'] = $toEmail;
                $mailData['fromName'] = $fromName;
                $mailData['fromEmail'] = $fromEmail;
                $mailData['emailSubject'] = nl2br(str_replace($search, $replace, $templateData['email_subject']));
                $mailData['emailContent'] = nl2br(str_replace($search, $replace, $templateData['email_content']));
                //$template_notification = nl2br(str_replace($search, $replace, $templateData['notification_content']));
                //$template_sms = str_replace($search, $replace, $templateData['sms_content']);
                //attachment
                
                \Event::fire(new SendMail($mailData));
            }

            return TRUE;
        }
        return FALSE;
    }
}

//update session value when click on toggle in header
function setToggelState($state){
    \Session::set('sidebar', $state);
    return TRUE;
}
//end