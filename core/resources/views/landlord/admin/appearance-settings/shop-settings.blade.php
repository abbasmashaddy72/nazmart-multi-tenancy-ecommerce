@extends(route_prefix().'admin.admin-master')
@section('title') {{__('Digital Shop Manage')}} @endsection
@section('style')
    <x-media-upload.css/>
@endsection
@section('content')
    <div class="col-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{__('Digital Shop Manage')}}</h4>
                <x-error-msg/>
                <x-flash-msg/>
                <form class="forms-sample" method="post" action="{{route('landlord.admin.shop.settings.update')}}">
                    @csrf

                    <x-fields.switcher :label="'Enable/Disable Digital Shop'" :name="'digital_shop_show'" :value="get_static_option_central('digital_shop_show')" :info="'Keep No to disable the digital shop for tenants'"/>

                    <button type="submit" class="btn btn-gradient-primary mt-5 me-2">{{__('Save Changes')}}</button>
                </form>
            </div>
        </div>
    </div>
    <x-media-upload.markup/>
@endsection
@section('scripts')
    <x-media-upload.js/>
@endsection
