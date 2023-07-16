<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* ------------------------------------------
     LANDLORD ADMIN ROUTES
-------------------------------------------- */
Route::group(['middleware' => ['auth:admin','adminglobalVariable', 'set_lang'],'prefix' => 'admin-home'],function () {
    Route::get("integrations-manage",[\Modules\Integrations\Http\Controllers\IntegrationsController::class,"index"])->name("landlord.integration");
    Route::post("integrations-manage",[\Modules\Integrations\Http\Controllers\IntegrationsController::class,"store"]);
    Route::post("integrations-manage/active",[\Modules\Integrations\Http\Controllers\IntegrationsController::class,"activate"])->name('landlord.integration.activation');
});

Route::group(['middleware' => [
    'auth:admin','adminglobalVariable', 'set_lang',
    \App\Http\Middleware\Tenant\InitializeTenancyByDomainCustomisedMiddleware::class,
    \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
],'prefix' => 'admin-home/integrations/tenant'],function () {
    Route::get("manage",[\Modules\Integrations\Http\Controllers\IntegrationsController::class,"index"])->name("tenant.integration");
    Route::post("manage",[\Modules\Integrations\Http\Controllers\IntegrationsController::class,"store"]);
    Route::post("manage/active",[\Modules\Integrations\Http\Controllers\IntegrationsController::class,"activate"])->name('tenant.integration.activation');
});
