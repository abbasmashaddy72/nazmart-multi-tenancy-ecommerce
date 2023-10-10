<?php

use Modules\SmsGateway\Http\Controllers\admin\LandlordSettingsController;

Route::middleware(['auth:admin', 'adminglobalVariable', 'set_lang'])
    ->prefix('admin-home/sms-gateway/')
    ->name('landlord.')
    ->controller(LandlordSettingsController::class)
    ->group(function () {
    Route::get('/', 'sms_settings')->name('admin.sms.settings');
    Route::post('/', 'update_sms_settings');
    Route::match(['get', 'post'],'/update-status', 'update_status')->name('admin.sms.status');
    Route::get('/login-otp-status', 'login_otp_status')->name('admin.sms.login.otp.status');
//        Route::get('/change-password', 'change_password')->name('landlord.admin.change.password');
//        Route::post('/edit-profile', 'update_edit_profile');
//        Route::post('/change-password', 'update_change_password');
});
