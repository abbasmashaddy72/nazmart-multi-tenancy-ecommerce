<?php

namespace App\Observers;

use App\Models\Tenant;
use Modules\SmsGateway\Http\Traits\OtpGlobalTrait;

class TenantCreateObserver
{
    use OtpGlobalTrait;

    public function created(Tenant $tenant)
    {
        if (moduleExists('SmsGateway'))
        {
            $this->smsSender($tenant);
        }
    }

    private function smsSender($tenant)
    {
        if (get_static_option('new_tenant_user'))
        {
            $this->smsToUserAboutNewTenant($tenant);
        }
        if (get_static_option('new_tenant_admin'))
        {
            $this->smsToAdminAboutNewTenant();
        }
    }

    private function smsToUserAboutNewTenant(Tenant $tenant)
    {
        $number = $tenant->user?->mobile;
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
