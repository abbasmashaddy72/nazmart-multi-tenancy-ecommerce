<?php

namespace App\Http\Controllers\Landlord\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AdminResetEmail;
use App\Models\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function login_form() {
        return view('landlord.admin.auth.login');
    }

    public function logout_admin() {
        Auth::guard('admin')->logout();
        return redirect()->route(route_prefix().'admin.login');
    }

    public function login_admin(Request $request){
        $this->validate($request, [
            'email'   => 'required|string',
            'password' => 'required|min:6'
        ],[
            'email.required'   => __('email or username required'),
            'password.required' => __('password required')
        ]);
        $type = 'username';
        //check is email or username
        if (filter_var($request->email,FILTER_VALIDATE_EMAIL)){
            $type = 'email';
        }
        if (Auth::guard('admin')->attempt([ $type => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return response()->json([
                'msg' => __('Login Success Redirecting'),
                'type' => 'success',
            ]);
        }

        abort(400,sprintf(__('Your %s or Password Is Wrong !!'),$type));
    }

    public function restricted()
    {
        $tenant_log = tenant()->payment_log;

        if ($tenant_log->status == 'complete')
        {
            return to_route('tenant.admin.dashboard');
        }
        return view('tenant.frontend.pages.restricted');
    }

    public function showUserForgetPasswordForm()
    {
        return view('landlord.admin.auth.forget-password');
    }

    public function sendUserForgetPasswordMail(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string:max:191'
        ]);

        $user_info = Admin::where('username', $request->username)->orWhere('email', $request->username)->first();

        if (!empty($user_info)) {
            $token_id = Str::random(30);
            DB::table('password_resets')->updateOrInsert(
                [
                    'email' => $user_info->email
                ],
                [
                    'email' => $user_info->email,
                    'token' => $token_id
                ]
            );

            $message = __('Here is you password reset link, If you did not request to reset your password just ignore this mail.') . '<br> <a class="btn" href="' . route(route_prefix().'admin.reset.password', ['user' => $user_info->username, 'token' => $token_id]) . '" style="color:white;background:gray">' . __('Click Reset Password') . '</a>';
            $data = [
                'username' => $user_info->username,
                'message' => $message
            ];

            try {
                Mail::to($user_info->email)->send(new AdminResetEmail($data));
            } catch (\Exception $e) {
                return redirect()->back()->with([
                    'msg' => $e->getMessage(),
                    'type' => 'danger'
                ]);
            }

            return redirect()->back()->with([
                'msg' => __('Check Your Mail For Reset Password Link'),
                'type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'msg' => __('Your Username or Email Is Wrong!!!'),
            'type' => 'danger'
        ]);
    }

    public function showUserResetPasswordForm($username, $token)
    {
        return view('landlord.admin.auth.reset-password')->with([
            'username' => $username,
            'token' => $token
        ]);
    }

    public function UserResetPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'username' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user_info = Admin::where('username', $request->username)->first();
        $token_info = DB::table('password_resets')->where(['email' => $user_info->email, 'token' => $request->token])->first();

        if (!empty($token_info)) {
            $user_info->password = Hash::make($request->password);
            $user_info->save();
            DB::table('password_resets')->where(['email' => $user_info->email, 'token' => $request->token])->delete();

            return redirect()->route(route_prefix().'admin.login')->with(['msg' => __('Password Changed Successfully'), 'type' => 'success']);
        }

        return redirect()->back()->with(['msg' => __('Somethings Going Wrong! Please Try Again or Check Your Old Password'), 'type' => 'danger']);
    }
}
