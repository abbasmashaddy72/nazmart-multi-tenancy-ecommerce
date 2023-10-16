<?php

namespace Modules\SmsGateway\Http\Controllers\admin;

use App\Helpers\FlashMsg;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SmsGateway\Entities\SmsGateway;
use Modules\SmsGateway\Http\Traits\OtpGlobalTrait;

class LandlordSettingsController extends Controller
{
    use OtpGlobalTrait;

    public function login_otp_status()
    {
        if (!get_static_option('otp_login_status'))
        {
            update_static_option('otp_login_status', 'on');
        } else {
            delete_static_option('otp_login_status');
        }

        return response()->json([
            'type' => 'success'
        ]);
    }

    public function sms_settings()
    {
        return view('smsgateway::landlord.admin.settings');
    }

    public function update_sms_settings(Request $request)
    {
        abort_if($request->method() == 'GET', 404);

        $request->validate([
            'sms_gateway_name' => 'required',
            'user_otp_expire_time' => 'required|numeric'
        ]);

        $fields = [];
        foreach ($request->toArray() ?? [] as $key => $value)
        {
            $fields[$key] = $value;
        }

        unset($fields['_token'], $fields['sms_gateway_name'], $fields['user_otp_expire_time']);

        $gateway = SmsGateway::updateOrCreate(
            [
                'name' => $request->sms_gateway_name
            ],
            [
                'name' => $request->sms_gateway_name,
                'status' => SmsGateway::where('name', $request->sms_gateway_name)->first()?->status ?? true,
                'otp_expire_time' => $request->user_otp_expire_time,
                'credentials' => json_encode($fields)
            ]
        );

        SmsGateway::where('id', '!=', $gateway->id)->update(['status' => false]);

        return back()->with(['msg' => __('Settings updated'), 'type' => 'success']);
    }

    public function update_status(Request $request)
    {
        $validated = $request->validate([
            'option_name' => 'required',
            'status' => 'required|bool'
        ]);

        $gateway = SmsGateway::where('name', $validated['option_name'])->update([
            'status' => !$validated['status']
        ]);
        SmsGateway::where('id', '!=', $gateway->id)->update(['status' => false]);

        return response()->json([
            'type' => 'success'
        ]);
    }

    public function update_sms_option_settings(Request $request)
    {
        abort_if($request->method() == 'GET', 404);

        if (tenant())
        {
            $validated = [
                'new_user_admin' => 'nullable',
                'new_user_user' => 'nullable',
                'new_order_admin' => 'nullable',
                'new_order_user' => 'nullable'
            ];
        }

        if (!tenant())
        {
            $validated = [
                'new_user_admin' => 'nullable',
                'new_user_user' => 'nullable',
                'new_tenant_admin' => 'nullable',
                'new_tenant_user' => 'nullable'
            ];
        }

        $validated['receiving_phone_number'] = 'required|numeric|regex:/^[+].*/';

        $request->validate($validated);

        foreach ($validated ?? [] as $key => $value)
        {
            update_static_option($key, $request->$key);
        }

        return back()->with(FlashMsg::settings_update('SMS option settings updated successfully'));
    }

    public function send_test_sms(Request $request)
    {
        abort_if($request->method() == 'GET', 404);

        $request->validate([
            'test_phone_number' => 'required'
        ]);

        try {
            $this->sendSms([$request->test_phone_number, __('Test SMS From '.get_static_option('site_title'))]);
        } catch (\Exception $exception) {
            if ($exception->getCode() == 20003)
            {
                return back()->with(FlashMsg::explain('danger', __('Authentication failed, sms gateway access credentials are incorrect.')));
            }
        }

        return back()->with(FlashMsg::explain('success', __('Test SMS has sent to your phone number.')));
    }
}
