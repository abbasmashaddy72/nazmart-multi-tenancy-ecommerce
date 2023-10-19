<?php

namespace Modules\SiteAnalytics\Http\Controllers\Admin;

use App\Helpers\FlashMsg;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\SiteAnalytics\Http\Services\SiteAnalyticsService;

class SiteAnalyticsSettingsController extends Controller
{
    public function index(Request $request): View
    {
        $period = $request->get('period', 'today');
        $service = (new SiteAnalyticsService($period));

//        dd($service->periods(), $service->pagesByDate());

        return view('siteanalytics::admin.dashboard', [
            'period'  => $period,
            'periods' => $service->periods(),
            'stats'   => $service->stats(),
            'pages'   => $service->pages(),
            'sources' => $service->sources(),
            'users'   => $service->users(),
            'devices' => $service->devices(),
            'utm'     => $service->utm(),
            'pages_charts'     => $service->pagesByDate(),
        ]);
    }

    public function settings()
    {
        return view('siteanalytics::admin.settings');
    }

    public function update_settings(Request $request)
    {
        $requested_params = [
            'site_analytics_status' => 'nullable',
            'site_analytics_unique_user' => 'nullable',
            'site_analytics_page_view' => 'nullable',
            'site_analytics_view_source' => 'nullable',
            'site_analytics_users_country' => 'nullable',
            'site_analytics_users_device' => 'nullable',
            'site_analytics_users_browser' => 'nullable'
        ];

        $request->validate($requested_params);

        foreach ($requested_params as $key => $value)
        {
            update_static_option($key, $request->$key);
        }

        return back()->with(FlashMsg::update_succeed('Analytics Settings'));
    }
}
