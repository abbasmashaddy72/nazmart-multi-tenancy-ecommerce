<?php

namespace App\Observers;

use App\Helpers\EmailHelpers\MarkupGenerator;
use App\Mail\BasicMail;
use App\Models\ProductOrder;
use Illuminate\Support\Facades\Mail;
use Modules\SmsGateway\Http\Services\OtpTraitService;
use Modules\SmsGateway\Http\Traits\OtpGlobalTrait;

class TenantOrderObserver
{
    private object $order_details;
    private $otp_instance;

    public function created(ProductOrder $order)
    {
        $this->order_details = $order;
        $this->mailToAdminAboutUserRegister();
        $this->smsSender($order->phone);
    }

    private function mailToAdminAboutUserRegister()
    {
        $msg = MarkupGenerator::paragraph(__('Hello,'));
        $msg .= MarkupGenerator::paragraph(sprintf(__('You have a new order')));
        $msg .= MarkupGenerator::paragraph(sprintf(__('Order ID: #%s'), $this->order_details->id));
        $msg .= MarkupGenerator::paragraph(sprintf(__('- %s'), site_title()));
        $subject = sprintf(__('New order has placed at %s'), site_title());
        try {
            Mail::to(site_global_email())->send(new BasicMail($msg, $subject));
        } catch (\Exception $e) {
            //handle exception
        }
    }

    private function smsSender($number)
    {
        if (moduleExists('SmsGateway') && trait_exists(OtpGlobalTrait::class) && get_static_option('otp_login_status')) {
            $this->otp_instance = new OtpTraitService();
            if (get_static_option('new_order_user')) {
                $this->smsToUserAboutOrder($number);
            }
            if (get_static_option('new_order_admin')) {
                $this->smsToAdminAboutOrder();
            }
        }
    }

    private function smsToUserAboutOrder($number)
    {
        try {
            $this->otp_instance->send([$number ?? 0, __('Hello, Your order has placed. Order ID: #'.$this->order_details->id. ' - ' .get_static_option('site_title'))]);
        } catch (\Exception $exception) {
        }
    }

    private function smsToAdminAboutOrder()
    {
        $number = get_static_option('receiving_phone_number');
        try {
            $this->otp_instance->send([$number, __('A new order has placed. Order ID: #'.$this->order_details->id. ' - ' .get_static_option('site_title'))]);
        } catch (\Exception $exception) {
        }
    }
}
