<?php

namespace Modules\SmsGateway\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserOtp extends Model
{
    protected $table = 'user_otps';
    protected $fillable = ['user_id', 'otp_code', 'expire_date'];
    protected $dates = ['expire_date'];
}
