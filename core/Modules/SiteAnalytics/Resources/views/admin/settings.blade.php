@extends(route_prefix().'admin.admin-master')

@section('title')
    {{ __('Site Analytics') }}
@endsection

@section('style')

@endsection

@section('content')
    <div class="dashboard-recent-order">
        <div class="row">
            <x-flash-msg/>
            <x-error-msg/>
            <div class="col-md-12">
                <div class="p-4 recent-order-wrapper dashboard-table bg-white padding-30">
                    <div class="wrapper d-flex justify-content-between">
                        <div class="header-wrap">
                            <h4 class="header-title mb-2">{{__("Site Analytics Settings")}}</h4>
                            <p>{{__("Manage site analytics and views from here, you can active/deactivate the usages from here.")}}</p>
                        </div>
                    </div>

                    <x-fields.switcher label="Enable or disable site analytics" name="site_analytics_status" value="{{get_static_option('site_analytics_status')}}"/>
                    <div class="settings_wrapper">
                        <x-fields.switcher label="Show or hide unique users" name="site_analytics_unique_user" value="{{get_static_option('site_analytics_unique_users')}}"/>
                        <x-fields.switcher label="Show or hide page views" name="site_analytics_page_view" value="{{get_static_option('site_analytics_page_views')}}"/>
                        <x-fields.switcher label="Show or hide page views" name="site_analytics_view_source" value="{{get_static_option('site_analytics_view_sources')}}"/>
                        <x-fields.switcher label="Show or hide users country" name="site_analytics_users_country" value="{{get_static_option('site_analytics_users_country')}}"/>
                        <x-fields.switcher label="Show or hide users country" name="site_analytics_users_device" value="{{get_static_option('site_analytics_users_devices')}}"/>
                        <x-fields.switcher label="Show or hide users country" name="site_analytics_users_browser" value="{{get_static_option('site_analytics_users_browser')}}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
