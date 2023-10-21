<?php

use Modules\SiteAnalytics\Http\Controllers\Admin\SiteAnalyticsSettingsController;

// LANDLORD
Route::middleware(['auth:admin', 'adminglobalVariable', 'set_lang'])
    ->prefix('admin-home/site-analytics')
    ->name('landlord.')
    ->controller(SiteAnalyticsSettingsController::class)
    ->group(function () {
        Route::get( '/', 'index')->name('admin.dashboard');
        Route::get( '/analytics', 'analytics')->name('admin.packages');
        Route::get('/settings', 'settings')->name('admin.analytics.settings');
        Route::post('/settings', 'update_settings');
//        Route::match(['get', 'post'], '/update-status', 'update_status')->name('admin.sms.status');
//        Route::get('/login-otp-status', 'login_otp_status')->name('admin.sms.login.otp.status');
//
//        Route::post('/test/otp', 'send_test_sms')->name('admin.sms.test');
    });
