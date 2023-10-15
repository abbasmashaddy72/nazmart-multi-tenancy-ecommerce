<?php

namespace App\Observers;

use App\Helpers\EmailHelpers\MarkupGenerator;
use App\Helpers\EmailHelpers\VerifyUserMailSend;
use App\Mail\BasicMail;
use App\Models\CustomDomain;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Modules\SmsGateway\Http\Traits\OtpGlobalTrait;
use Modules\WebHook\Events\WebhookEventFire;

class TenantRegisterObserver
{
    use OtpGlobalTrait;

    public function created(User $user)
    {
        /* send mail to admin about new user registration */
        $this->mailToAdminAboutUserRegister($user);
        /* send email verify mail to user */
        VerifyUserMailSend::sendMail($user);
        CustomDomain::create(['user_id' => $user->id]);

        if (moduleExists('SmsGateway'))
        {
            if (get_static_option('new_user_user'))
            {
                $this->smsToUserAboutUserRegister($user);
            }
            if (get_static_option('new_user_admin'))
            {
                $this->smsToAdminAboutUserRegister();
            }
        }

        if (!\tenant())
        {
            Event::dispatch(new WebhookEventFire('user:register', $user));
        }
    }

    private function mailToAdminAboutUserRegister(User $user)
    {

        $msg = MarkupGenerator::paragraph(__('Hello'));
        $msg .= MarkupGenerator::paragraph(sprintf(__('you have a user registration at %s'),site_title()));
        $subject = sprintf(__('new user registration at %s'),site_title());
        try {
            Mail::to(site_global_email())->send(new BasicMail($msg,$subject));
        }catch (\Exception $e){
            //handle exception
        }
    }

    private function smsToUserAboutUserRegister(User $user)
    {
        $number = $user->mobile;
        try {
            $this->sendSms([$number, __('Welcome to '.get_static_option('site_title').' .Your account is registration is successful')]);
        }
        catch (\Exception $exception) {}
    }

    private function smsToAdminAboutUserRegister()
    {
        $number = get_static_option('receiving_phone_number');
        try {
            $this->sendSms([$number, __('A new user has been registered - '.get_static_option('site_title'))]);
        }
        catch (\Exception $exception) {}
    }
}
