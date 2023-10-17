<?php

namespace App\Providers;

use App\Helpers\LanguageHelper;
use App\Helpers\ModuleMetaData;
use App\Helpers\SidebarMenuHelper;
use App\Helpers\ThemeMetaData;
use App\Http\Services\RenderImageMarkupService;
use App\Models\Themes;
use App\Models\User;
use App\Observers\TenantRegisterObserver;
use App\Observers\WalletBalanceObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Modules\Blog\Entities\BlogCategory;
use Modules\Wallet\Entities\Wallet;
use function Psy\bin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton('LandlordAdminMenu',function (){
           return  new SidebarMenuHelper();
        });
        app()->singleton('GlobalLanguage',function (){
           return  new LanguageHelper();
        });

        $this->app->singleton('ThemeDataFacade', function (){
            return new ThemeMetaData();
        });
        $this->app->singleton('ModuleDataFacade', function (){
            return new ModuleMetaData();
        });
        $this->app->singleton('ImageRenderFacade', function (){
            return new RenderImageMarkupService();
        });

        /* LARAVEL TELESCOPE */
        if ($this->app->environment('local') && in_array(request()->getHost(), ['nazmart.test','127.0.0.1','localhost'])) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if (get_static_option('site_force_ssl_redirection') === 'on'){
            URL::forceScheme('https');
        }
    }
}
