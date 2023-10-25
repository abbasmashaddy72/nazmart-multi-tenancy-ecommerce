<?php

namespace App\Http\Middleware\Tenant;

use App\Models\CustomDomain;
use App\Models\StaticOption;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TenantConfigMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // switches timezone according to tenant timezone from database value
        if (tenant()){
            $smtp_settings_values = StaticOption::select(['option_name','option_value'])->whereIn('option_name',[
                'site_smtp_driver',
                'site_smtp_host',
                'site_smtp_port',
                'site_smtp_username',
                'site_smtp_password',
                'site_smtp_encryption',
                'site_global_email'
            ])->get()->pluck('option_value','option_name')->toArray();

            Config::set('mail.mailers', $smtp_settings_values['site_smtp_driver'] ?? Config::get('mail.mailers'));
            $mailers = !empty($smtp_settings_values) ? $smtp_settings_values['site_smtp_driver'] : (get_static_option_central('site_smtp_driver') ?? 'smtp');

            Config::set([
                "mail.mailers.{$mailers}.transport" => $smtp_settings_values['site_smtp_driver'] ?? Config::get('mail.mailers.smtp.transport'),
                "mail.mailers.{$mailers}.host" => $smtp_settings_values['site_smtp_host'] ?? Config::get('mail.mailers.smtp.host'),
                "mail.mailers.{$mailers}.port" => $smtp_settings_values['site_smtp_port'] ?? Config::get('mail.mailers.smtp.port'),
                "mail.mailers.{$mailers}.username" => $smtp_settings_values['site_smtp_username'] ?? Config::get('mail.mailers.smtp.username'),
                "mail.mailers.{$mailers}.password" => $smtp_settings_values['site_smtp_password'] ?? Config::get('mail.mailers.smtp.password'),
                "mail.mailers.{$mailers}.encryption" => $smtp_settings_values['site_smtp_encryption'] ?? Config::get('mail.mailers.smtp.encryption'),
                "mail.from.address" => $smtp_settings_values['site_global_email'] ?? Config::get('mail.from.address')
            ]);

            //todo change booted config file on the fly
            $timezone = \Cache::remember('tenant_timezone', 60*60*24, function () {
                return get_static_option('timezone');
            });
            \Config::set('app.timezone', $timezone);

            // storage management
            $storagePathFix = str_replace('tenant'.tenant()->getTenantKey(),'', storage_path('../../assets/tenant/uploads/media-uploader/'));
            Config::set('filesystems.disks.TenantMediaUploader.root',$storagePathFix.tenant()->getTenantKey());
            $storage_driver = get_static_option_central('storage_driver','TenantMediaUploader');
            $defaultStorage = is_null($storage_driver) ? "cloudFlareR2" : $storage_driver;
            Config::set('filesystems.default',$defaultStorage);
        }
        else
        {
            Config::set('filesystems.default', get_static_option_central('storage_driver','LandlordMediaUploader'));
        }

        return $next($request);
    }
}
