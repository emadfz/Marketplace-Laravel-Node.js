<?php

/*
  |--------------------------------------------------------------------------
  | Users Management
  |--------------------------------------------------------------------------
  | Front side users such as Buyer, Individual Seller, Business Seller
  |
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
// Dev added
use Datatables;
use Mail;
use DB;
use App\Models\User;
use App\Models\SecretQuestion;
use App\Models\IndustryType;
//use App\Models\Country;
use App\Models\UserAddress;
use App\Models\SellerDetail;
use App\Models\UserPaymentCardDetail;
use App\Models\LoginHistoryUser;
use App\Models\UserPasswordReset;

class UsersController extends Controller {

    public function __construct() {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $userTypes = getMasterEntityOptions('user_types');
        $usersStatus = getMasterEntityOptions('user_statuses');
        return view('admin.users.index', compact('userTypes', 'usersStatus'));
    }

    public function datatableList(Request $request) {
        $usersDetails = User::getUsersData($purpose = 'datatable');
        
        $hasPermission['update'] = (checkAuthorize('users', 'update_access')) ? TRUE : FALSE;
        $hasPermission['delete'] = (checkAuthorize('users', 'delete_access')) ? TRUE : FALSE;

        return Datatables::of($usersDetails)
                        ->addColumn('action', function ($user) use ($hasPermission) {
                            $action = '';
                            $action .= ($hasPermission['update']) ? '<a href="' . route(config('project.admin_route') . 'users.edit', encrypt($user->id)) . '" class="btn btn-sm btn-outline grey-salsa" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-search"></i></a>' : '';
                            $status = $user->status=='Blocked' ? 'Active':'Blocked';
                            $icon = $user->status=='Blocked' ? '<i class="fa fa-toggle-off"></i>':'<i class="fa fa-toggle-on"></i>';
                            $iconClass = $user->status=='Blocked' ? 'btn-danger' : 'grey-salsa';
                            $action .= ($hasPermission['delete']) ? 
                                    '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-sm btn-outline blockUnblockUser '.$iconClass.'" data-toggle="modal" data-placement="top" title="Mark as '.$status.' user" data-user_block_unblock_remote="' . route('changeUserStatus', [encrypt($user->id), $status]) . '">'.$icon.'</a>' : '';
                            return $action;
                        })
                        ->editColumn('created_at', function ($user) {
                            return $user->created_at->format('d M Y, h:i A');
                        })
                        ->editColumn('phone_number', function ($user) {
                            return '<i class="fa fa-skype"></i>&nbsp<a href="skype:'.$user->phone_number.'?call">'.$user->phone_number.'</a>';
                        })
                        
                        ->filter(function ($query) use ($request) {
                            if ($request->has('user_type') && $request->input('user_type') != "") {
                                $query->where('users.user_type', $request->input('user_type'));
                            }

                            if ($request->has('status') && $request->input('status') != "") {
                                $query->where('users.status', $request->input('status'));
                            }

                            if ($request->has('full_name') && $request->input('full_name') != "") {
                                $query->whereRaw("CONCAT(users.first_name,' ',users.last_name) like ?", ["%{$request->input('full_name')}%"]);
                            }

                            if ($request->has('user_id') && $request->input('user_id') != "") {
                                $query->where('users.id', $request->input('user_id'));
                            }

                            /* if ($request->has('country') && $request->input('country') != "") {
                              $query->where('address_detail_billing.country.country_code', $request->input('country'));
                              } */

                            if ($request->has('customer_from') && $request->has('customer_to') && $request->get('customer_from') != "" && $request->get('customer_to') != "") {
                                $arrStart = explode("-", $request->get('customer_from'));
                                $arrEnd = explode("-", $request->get('customer_to'));
                                $fromDate = \Carbon\Carbon::create($arrStart[0], $arrStart[1], $arrStart[2], 0, 0, 0);
                                $toDate = \Carbon\Carbon::create($arrEnd[0], $arrEnd[1], $arrEnd[2], 23, 59, 59);
                                $query->whereBetween('created_at', [$fromDate, $toDate]);
                            }
                        })
                        /* ->filterColumn('full_name', function($query, $keyword) {
                          $query->whereRaw("CONCAT(users.first_name,' ',users.last_name) like ?", ["%{$keyword}%"]);
                          }) */
                        //->orderColumn('fullname', 'users.phone_number $1')
                        ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request) {
        $encryptUserId = $id;
        $id = decrypt($id);

        // get all the details of an user
        $userDetails = User::getUsersData($purpose = 'id', $id);
        //echo "<pre>";print_r($userDetails);die;

        if (empty($userDetails)) {
            return redirect()->route(config('project.admin_route') . 'users.index');
        }

        // select title
        $nameTitle = getMasterEntityOptions('name_title');
        // select gender
        $gender = getMasterEntityOptions('gender');
        // select industry types
        $industryTypes = IndustryType::getIndustryTypes('', true);
        
        // country, state, city dropdown
        $countries = getAllCountries(TRUE);
        
        // last accessed datetime from login_history_users
        $lastAccessedDate = 'Has not accessed yet';
        if (!empty($userDetails['login_history_detail'])) {
            $lastAccessedDate = $userDetails['login_history_detail'][0]['created_at'];
        }

        // assign all variables to view blade
        $view = [
            // variable to use
            'userId' => $encryptUserId,
            'lastAccessedDate' => $lastAccessedDate,
            
            // select drodown
            'nameTitle' => $nameTitle,
            'gender' => $gender,
            'industryTypes' => $industryTypes,
            'countries' => $countries,
            
            // all information about user
            'userDetails' => $userDetails,
            'sellerDetails' => $userDetails['seller_detail'],
            'addressDetails' => $userDetails['address_detail'],
            'paymentCardDetails' => $userDetails['payment_card_detail'],
            'loginHistoryDetail' => $userDetails['login_history_detail'],
            
        ];

        return view('admin.users.edit', compact('view'));
    }

    /**
     * Verify business seller user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verifyUser(Request $request, $id) {
        $id = decrypt($id);

        try {
            $userInfo = User::checkUserData(['id' => $id]);
            
            if ($userInfo) {

                $activationCode = generateToken($userInfo['email']);
                $verificationUrl = env('FRONT_APP_URL') . '/account-verify/' . $activationCode;
                
                // verify seller details by admin
                User::verifyUserByAdmin($id, $activationCode);
                
                // send notification
                $tags = ['ACTIVATION_LINK' => $verificationUrl];
                sendNotification('VERIFY_REGISTERED_SELLER_BY_ADMIN', [$id], $tags, $table = 'users');

                return response()->json(['success' => 1, 'msg' => trans("message.users.verification_email_sent_success")]);
            }
        } catch (\Exception $ex) {
            return response()->json(['success' => 0, 'msg' => $ex->getMessage()]);
        }
        
    }
    
    public function changeUserStatus(Request $request, $id, $status){
        $id = decrypt($id);

        try {
            $userInfo = User::checkUserData(['id' => $id]);

            if ($userInfo) {
                $mailData['email'] = $userInfo['email'];
                $mailData['full_name'] = $userInfo['first_name'] . ' ' . $userInfo['last_name'];
                $mailData['status'] = $status;
                
                User::updateUser(['id' => $id], ['status' => $status]);
                
                Mail::send('admin.auth.emails.update_user_status_notification', ['fullName' => $mailData['full_name'], 'status' => $status], function($message) use ($mailData) {
                    $message->to($mailData['email'], $mailData['full_name'])
                            ->subject('Account '.$mailData['status'].' - inSpree Marketplace');
                });
                
                if($status == 'Active'){
                    $msg = 'user_active_email_sent_success';
                }else if($status == 'Blocked'){
                    $msg = 'user_blocked_email_sent_success';
                }
                return response()->json(['success' => 1, 'msg' => trans("message.users.$msg")]);
            }
        } catch (\Exception $ex) {
            return response()->json(['success' => 0, 'msg' => trans("message.failure")]);
        }
    }

}
