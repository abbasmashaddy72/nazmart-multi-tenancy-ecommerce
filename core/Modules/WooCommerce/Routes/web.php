<?php

use App\Http\Middleware\Tenant\InitializeTenancyByDomainCustomisedMiddleware;
use Modules\WooCommerce\Http\Controllers\WooCommerceController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;;

Route::group(['middleware' => [
    'auth:admin','adminglobalVariable', 'set_lang',
    InitializeTenancyByDomainCustomisedMiddleware::class,
    PreventAccessFromCentralDomains::class,
],'prefix' => 'admin-home/tenant/woocommerce', 'as' => 'tenant.'],function () {
    Route::get("manage",[WooCommerceController::class,"index"])->name("woocommerce");

    Route::get("settings",[WooCommerceController::class,"settings"])->name("woocommerce.settings");
    Route::post("settings",[WooCommerceController::class,"settings_update"]);

    Route::get("settings/import",[WooCommerceController::class,"import_settings"])->name("woocommerce.settings.import");
    Route::post("settings/import",[WooCommerceController::class,"import_settings_update"]);
});


