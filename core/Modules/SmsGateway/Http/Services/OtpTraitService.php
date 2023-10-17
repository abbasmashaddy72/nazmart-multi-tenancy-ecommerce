<?php

namespace Modules\SmsGateway\Http\Services;

use Modules\SmsGateway\Http\Traits\OtpGlobalTrait;

class OtpTraitService
{
    use OtpGlobalTrait;

    public function send($data)
    {
        return $this->sendSms($data);
    }
}
