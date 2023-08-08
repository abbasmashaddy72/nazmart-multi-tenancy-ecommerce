<?php

use App\Http\Middleware\Tenant\InitializeTenancyByDomainCustomisedMiddleware;
use Modules\WooCommerce\Http\Controllers\WooCommerceController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;;

Route::group(['middleware' => [
    'auth:admin','adminglobalVariable', 'set_lang',
    InitializeTenancyByDomainCustomisedMiddleware::class,
    PreventAccessFromCentralDomains::class,
],'prefix' => 'admin-home/tenant/woocommerce'],function () {
    Route::get("manage",[WooCommerceController::class,"index"])->name("tenant.woocommerce");
    Route::get("settings",[WooCommerceController::class,"settings"])->name("tenant.woocommerce.settings");
    Route::post("settings",[WooCommerceController::class,"settings_update"]);
//    Route::post("manage",[IntegrationsController::class,"store"]);
//    Route::post("manage/active",[IntegrationsController::class,"activate"])->name('tenant.integration.activation');
});


