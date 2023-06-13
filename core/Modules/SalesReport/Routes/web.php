<?php

use App\Http\Middleware\Tenant\InitializeTenancyByDomainCustomisedMiddleware;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Modules\SalesReport\Http\Controllers\Tenant\SalesReportController;

Route::middleware([
    'web',
    InitializeTenancyByDomainCustomisedMiddleware::class,
    PreventAccessFromCentralDomains::class,
    'auth:admin',
    'tenant_admin_glvar',
    'package_expire',
    'tenantAdminPanelMailVerify',
    'tenant_status',
    'set_lang'
])->prefix('admin-home')->name('tenant.')->group(function () {
    Route::controller(SalesReportController::class)->prefix('sales-report')->name('admin.sales.')->group(function (){
        Route::get('/', 'index')->name('dashboard');
    });
});
