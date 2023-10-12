<?php

namespace Modules\SmsGateway\Http\Controllers\admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SmsGateway\Entities\SmsGateway;

class LandlordSettingsController extends Controller
{
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
                'status' => SmsGateway::where('name', $request->sms_gateway_name)->first()?->status,
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

        return response()->json([
            'type' => 'success'
        ]);
    }
}
