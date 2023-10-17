<?php

use Modules\SiteAnalytics\Http\Controllers\Admin\SiteAnalyticsSettingsController;

// LANDLORD
Route::middleware(['auth:admin', 'adminglobalVariable', 'set_lang'])
    ->prefix('admin-home/site-analytics')
    ->name('landlord.')
    ->controller(SiteAnalyticsSettingsController::class)
    ->group(function () {
        Route::get('/', 'settings')->name('admin.analytics.settings');
//        Route::post('/', 'update_sms_settings');
//        Route::match(['get', 'post'], '/sms-options', 'update_sms_option_settings')->name('admin.sms.options');
//        Route::match(['get', 'post'], '/update-status', 'update_status')->name('admin.sms.status');
//        Route::get('/login-otp-status', 'login_otp_status')->name('admin.sms.login.otp.status');
//
//        Route::post('/test/otp', 'send_test_sms')->name('admin.sms.test');
    });
