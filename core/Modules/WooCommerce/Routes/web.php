<?php

use App\Http\Middleware\Tenant\InitializeTenancyByDomainCustomisedMiddleware;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Modules\WooCommerceImport\Http\Controllers\WooCommerceController;

Route::prefix('woocommerceimport')->group(function() {
    Route::get('/', 'WooCommerceImportController@index');
});

Route::group(['middleware' => [
    'auth:admin','adminglobalVariable', 'set_lang',
    InitializeTenancyByDomainCustomisedMiddleware::class,
    PreventAccessFromCentralDomains::class,
],'prefix' => 'admin-home/woocommerce/tenant'],function () {
    Route::get("manage",[WooCommerceController::class,"index"])->name("tenant.woocommerce");
//    Route::post("manage",[IntegrationsController::class,"store"]);
//    Route::post("manage/active",[IntegrationsController::class,"activate"])->name('tenant.integration.activation');
});


