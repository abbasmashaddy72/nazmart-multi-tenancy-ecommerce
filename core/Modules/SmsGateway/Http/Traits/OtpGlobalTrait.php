<?php

namespace Modules\SmsGateway\Http\Traits;

use App\Models\User;
use Exception;
use Modules\SmsGateway\Entities\SmsGateway;
use Modules\SmsGateway\Entities\UserOtp;
use Twilio\Rest\Client;

trait OtpGlobalTrait
{
    public string $twilio_number;

    public function sendSms($data)
    {
        [$receiverNumber, $message] = $data;
        $client = $this->config();

        $client->messages->create($receiverNumber, [
            'from' => $this->twilio_number,
            'body' => $message
        ]);

        return true;
    }

    public function generateOtp($phone_number, $model_name = 'User', $column_name = 'mobile', $relation_name = 'otpInfo', $is_module = false, $module_name = null)
    {
        $user = $this->getModel($model_name, $is_module, $module_name)::select('id')->where($column_name, $phone_number)->first();
        $userOtp = $user->$relation_name;

        if ($user) {
            $gateway = $this->activeSmsGateway();
            $now = now();

            $otp_expire_time = $gateway->otp_expire_time ?? 1;
            $times = $otp_expire_time == 30 ? 'addSeconds' : 'addMinutes';

            if ($userOtp) {
                $userOtp->update([
                    'user_id' => $user->id,
                    'user_type' => $user->getTable(),
                    'otp_code' => rand(111111, 999999),
                    'expire_date' => $now->$times($otp_expire_time)
                ]);
            } else {
                $userOtp = UserOtp::create([
                    'user_id' => $user->id,
                    'user_type' => $user->getTable(),
                    'otp_code' => rand(111111, 999999),
                    'expire_date' => $now->$times($otp_expire_time)
                ]);
            }
        }

        return $userOtp;
    }

    private function getModel($model_name = 'User', $is_module = false, $module_name = null): string
    {
        // Use CamelCase for Model and Module Name

        $model_path = '';
        if ($is_module) {
            $model_path = 'Modules\\' . ucwords($module_name) . '\Entities\\' . ucwords($model_name);
        } else {
            $model_path = '\App\Models\\' . ucwords($model_name);
        }

        return $model_path;
    }

    private function activeSmsGateway()
    {
        return SmsGateway::active()->first();
    }

    private function config()
    {
        $sms_gateway = $this->activeSmsGateway();
        $client = '';

        try {
            retry(2, function () use ($sms_gateway, &$client) {
                $client = null;
                if ($sms_gateway->name == 'twilio') {
                    $credentials = $this->twilioConfig($sms_gateway);
                    $client = new Client(...$credentials);
                }
            }, 1000);
        } catch (Exception $e) {
            info("error: " . $e->getMessage());
        }

        return $client;
    }

    private function twilioConfig($sms_gateway): array
    {
        $credentials = json_decode($sms_gateway->credentials);
        $account_sid = $credentials->twilio_sid;
        $auth_token = $credentials->twilio_auth_token;
        $this->twilio_number = $credentials->twilio_number;

        return [$account_sid, $auth_token];
    }
}
