<?php

namespace App\Actions\Sms;

use Modules\SmsGateway\Http\Traits\OtpGlobalTrait;

class SmsSendAction
{
    use OtpGlobalTrait;

    public function smsSender($user): void
    {
        if (moduleExists('SmsGateway'))
        {
            if (get_static_option('new_tenant_user'))
            {
                $this->smsToUserAboutNewTenant($user);
            }
            if (get_static_option('new_tenant_admin'))
            {
                $this->smsToAdminAboutNewTenant();
            }
        }
    }

    private function smsToUserAboutNewTenant($user)
    {
        $number = $user->mobile;
        try {
            $this->sendSms([$number, __('Hello, Your new shop is created successfully - ' . get_static_option('site_title'))]);
        }
        catch (\Exception $exception) {}
    }

    private function smsToAdminAboutNewTenant()
    {
        $number = get_static_option('receiving_phone_number');
        try {
            $this->sendSms([$number, __('A new shop has been created - '.get_static_option('site_title'))]);
        }
        catch (\Exception $exception) {}
    }
}
