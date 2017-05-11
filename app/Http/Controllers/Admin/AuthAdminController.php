<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\LoginHistory;
use App\Models\AdminUserPasswordReset;
use App\Models\AdminUser;
use Carbon\Carbon;
use Mail;

class AuthAdminController extends Controller {

    use AuthenticatesAndRegistersUsers,
        ThrottlesLogins;

    //protected $loginView = 'admin.auth.login';
    protected $guard = 'admin';
    public $adminUserPasswordReset;
    //protected $redirectTo = '/';
    //protected $redirectAfterLogout = 'admin/';
    protected $lockoutTime = 1; //seconds
    protected $maxLoginAttempts = 5;
    protected $username = 'professional_email';

    public function __construct() {
        $this->adminUserPasswordReset = new AdminUserPasswordReset();
        //$this->middleware('auth:admin');
    }

    public function index() {
        //echo "<pre>";print_r(auth()->guard('admin')->check());die;
        return view('admin.dashboard.index');
    }

    public function showLoginForm() {
        //if (!auth()->guard('admin')->user()) {
        if (!auth()->guard('admin')->check()) {
            return view('admin.auth.login');
        } else {
            return redirect()->route(config('project.admin_route') . 'home.index');
        }
    }

    /**
     * Login Admin User
     * @param Request $request
     * @return type
     */
    public function postLogin(Request $request) {

        $loginValidateFields = collect(['professional_email' => 'required|email|max:100', 'password' => 'required|min:7']);

        if ($request->has('captcha_hdn')) {
            $loginValidateFields = $loginValidateFields->merge(['captcha' => 'required|captcha']);
        }

        $loginFailedLimitExceed = FALSE;
        
        if ($this->retriesLeft($request) <= 1) {
            $loginFailedLimitExceed = TRUE;
        }

        //echo "<pre>";print_r($loginValidateFields->all());dd($loginFailedLimitExceed);die;
        $validator = validator($request->all(), $loginValidateFields->all());
        //dd($validator->errors()->all());

        if ($validator->fails()) {
            return ($request->ajax()) ?
                    response()->json(['status' => 'error', 'messages' => $validator->errors()]) :
                    redirect()->route('adminLogin')->withErrors($validator)->withInput()->with('loginFailedLimitExceed', $loginFailedLimitExceed);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        $credentials = ['professional_email' => $request->input('professional_email'),
            'password' => $request->input('password'),
            'confirmed' => 1,
            'status' => config('project.status_active'),
            'deleted_at' => NULL];

        if (auth()->guard('admin')->attempt($credentials)) {

            $this->saveAttemptRecord($request, 'success');

            if ($throttles) {
                $this->clearLoginAttempts($request);
            }

            if (\Session::has('pre_login_url')) {
                $url = \Session::get('pre_login_url');
                \Session::forget('pre_login_url');
                return redirect()->to($url);
            } else {
                return ($request->ajax()) ?
                        response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'home.index')]) :
                        redirect()->route(config('project.admin_route') . 'home.index');
            }
        } else {

            $this->saveAttemptRecord($request, 'fail');

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            if ($throttles) {
                $this->incrementLoginAttempts($request);
            }

            //return $this->sendFailedLoginResponse($request);
            
            /* get user data by professional email */
            $getUserData = AdminUser::checkUserData([
                'professional_email' => $request->input('professional_email'),
                'deleted_at' => NULL ]);
            
            if ($getUserData && ($getUserData['confirmed'] == 0 || $getUserData['status'] != 'Active')) {
                if($getUserData['status'] == config('project.status_blocked'))
                {
                    $errorMsg = trans("message.user_blocked");
                }
                else
                {
                    $errorMsg = trans("message.account_not_confirmed");
                }                
            } else {
                $errorMsg = trans("message.login_invalid");
            }
            
            \Flash::error($errorMsg); //return redirect()->route('adminLogin');
            return redirect()->back()->withInput($request->only($this->loginUsername()))->with('loginFailedLimitExceed', $loginFailedLimitExceed);
        }
    }

    /**
     * Store the login attempt in the database
     *
     * @param  Request $request
     * @return 
     */
    private function saveAttemptRecord(Request $request, $status) {
        $user_id = (isset($status) && $status == 'success') ? auth()->guard('admin')->user()->id : 0;
        $log = new LoginHistory;
        $log->user_id = $user_id;
        $log->professional_email = $request->only($this->loginUsername())['professional_email'];
        $log->user_type = 'admin';
        $log->attempts = $this->maxLoginAttempts - ($this->retriesLeft($request) - 1);
        $log->ip_address = $request->ip();
        $log->user_agent = $request->header('User-Agent') !== null ? $request->header('User-Agent') : '';
        $log->status = $status;
        $log->created_at = Carbon::now(); //new DateTime
        $log->save();
    }

    /**
     * Refresh Captcha
     *
     * @param  No Param
     * @return Captcha image
     */
    public function refereshCaptcha() {
        return captcha_img('flat');
    }

    /**
     * Logout admin user
     * @return
     */
    public function logout() {
        auth()->guard('admin')->logout();
        return redirect()->route('adminLogin');
    }

    public function showForgotPasswordForm() {

        if (!auth()->guard('admin')->check()) {
            return view('admin.auth.passwords.forgot');
        } else {
            return redirect()->route(config('project.admin_route') . 'home.index');
        }
    }

    public function postForgotPassword(Request $request) {
        $validator = validator($request->all(), [
            'personal_email' => 'required|email|max:100|exists:admin_users,personal_email',
        ],['personal_email.exists'=>'Please enter registered personal email.']);

        if ($validator->fails()) {
            
            return redirect()->route('forgotPassword')->withErrors($validator)->withInput();
        }

        $personalEmail = $request->input('personal_email');

        // get user info
        $userInfo = AdminUser::where('personal_email', '=', $personalEmail)->firstOrFail()->toArray();

        // do one entry in admin_user_password_resets table
        $token = sha1(uniqid("iS", true) . $personalEmail . str_random(60));
        $data['personal_email'] = $personalEmail;
        $data['admin_user_id'] = $userInfo['id'];
        $data['token'] = $token;
        $data['created_at'] = Carbon::now();
        AdminUserPasswordReset::create($data);

        $data['full_name'] = $userInfo['first_name'] . ' ' . $userInfo['last_name'];

        // send an email to user with reset password link
        /*Mail::send('admin.auth.emails.password', $data, function ($message) use ($userInfo, $personalEmail) {
            $message->to($personalEmail, $userInfo['first_name'] . ' ' . $userInfo['last_name']);
            $message->subject(trans("form.password_reset"));
        });*/
        
        // send notification
        $tags = ['PASSWORD_RESET_LINK' => route('resetPassword', $token)];
        sendNotification('FORGOT_PASSWORD_ADMIN', [$userInfo['id']], $tags, $table = 'admin_users');

        \Flash::success(trans("message.password_reset_link_sent"));
        return redirect()->route('adminLogin');
        //return redirect()->back();
    }

    public function showResetPasswordForm($token) {

        if (!auth()->guard('admin')->check()) {
            $secretQuestion = [];
            try {
                $userInfo = AdminUserPasswordReset::where('token', '=', $token)->first();

                if (empty($userInfo)) {
                    \Flash::error(trans('message.token_does_not_exist'));
                    return redirect()->route('adminLogin');
                } else {
                    $userInfo = $userInfo->toArray();

                    $difference = ' +24 hours';
                    if ((strtotime($userInfo['created_at'] . $difference) < strtotime(Carbon::now()->format("Y-m-d H:i:s"))) || $userInfo['is_used'] == 1) {
                        \Flash::error(trans('message.token_expired'));
                        return redirect()->route('adminLogin');
                    }

                    $secretQuestion = \DB::table('admin_user_details AS aud')
                            ->select('aud.secret_question_id', 'aud.secret_answer', 'sq.secret_question')
                            ->join('secret_questions AS sq', 'sq.id', '=', 'aud.secret_question_id')
                            ->where('aud.admin_user_id', $userInfo['admin_user_id'])
                            ->first();
                    
                }
            } catch (\Exception $ex) {
                \Flash::error(trans('message.failure'));
                return redirect()->back();
            }

            return view('admin.auth.passwords.reset', compact('token', 'userInfo', 'secretQuestion'));
        } else {
            return redirect()->route(config('project.admin_route') . 'home.index');
        }
    }

    public function postResetPassword(Request $request) {
        $this->validate($request, [
            'date_of_birth' => 'required|date',
            'secret_answer' => 'required',
            'password' => 'required|min:7',
            'confirm_password' => 'required|same:password|min:7',
        ], ['secret_answer.required' => trans('message.secret_answer_required')]);

        try {
            $resetToken = decrypt($request->input("reset_token"));
            $userInfo = $this->adminUserPasswordReset->getAdminUserDetails($resetToken);

            if (empty($userInfo)) {
                \Flash::error(trans('message.token_does_not_exist'));
                return response()->json(['status' => 'success', 'redirectUrl' => route('adminLogin')]);
            }

            $msg = [];
            $requestDateOfBirth = date("Y-m-d", strtotime($request->input('date_of_birth')));

            if ($requestDateOfBirth != $userInfo['admin_users']['dob']) {
                $msg[] = trans("message.dob_not_match");
            }

            if ($request->input('secret_answer') != $userInfo['admin_user_details']['secret_answer']) {
                $msg[] = trans("message.secret_answer_not_match");
            }

            if (!empty($msg)) {
                return response()->json(['status' => 'error', 'messages' => ['global_form_message' => implode("<br/>", $msg)]]);
            }


            // update password in admin user
            AdminUser::updateAdminUser(['password' => bcrypt($request->input('password'))], $userInfo['admin_user_id']);
            // update password reset entry
            AdminUserPasswordReset::updateAdminUserPasswordReset(['is_used' => 1], $resetToken);

            \Flash::success(trans('message.password_reset_success'));
            return response()->json(['status' => 'success', 'redirectUrl' => route('adminLogin')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }
    }

}
