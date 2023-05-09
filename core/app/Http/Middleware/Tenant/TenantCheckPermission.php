<?php

namespace App\Http\Middleware\Tenant;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantCheckPermission
{
    public function handle(Request $request, Closure $next)
    {
        $routeName = \Route::currentRouteName();
        $routeArr = explode('.',$routeName);

        $name = '';
        if (in_array('coupon', $routeArr))
        {
            $arrKey = array_search('coupon', $routeArr);
            $name = $routeArr[$arrKey];
        }

        $current_tenant_payment_data = tenant()->payment_log ?? [];

        if (!empty($current_tenant_payment_data) && !empty($name))
        {
            $package = $current_tenant_payment_data->package;

            if (!empty($package))
            {
                $features = $package->plan_features->pluck('feature_name')->toArray();

                if (in_array($name, (array)$features))
                {
                    return $next($request);
                }
            }
        }

        return redirect(url('admin'));
    }
}
