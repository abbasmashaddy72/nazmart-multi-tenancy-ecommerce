<?php

namespace Modules\SiteAnalytics\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SiteAnalyticsSettingsController extends Controller
{
    public function settings()
    {
        return view('siteanalytics::admin.settings');
    }
}
