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
                            <p>{{__("Manage all sms gateway from here, you can active/deactivate any sms gateway from here.")}}</p>
                        </div>
                        <div class="settings-options justify-content-end">
                            <span data-bs-toggle="modal" data-bs-target="#settings_option_modal">
                                <a href="#" data-bs-toggle="tooltip"  data-bs-placement="top" title="{{__('SMS Settings')}}" class="modal-btn btn btn-info btn-small settings-option-modal">
                                    <i class="mdi mdi-cogs"></i>
                                </a>
                            </span>
                            <span data-bs-target="#test_sms_modal" data-bs-toggle="modal">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Send Test SMS')}}" class="modal-btn btn btn-success btn-small">
                                    <i class="mdi mdi-message-alert"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
