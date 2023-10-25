@extends(route_prefix().'admin.admin-master')
@section('title') {{__('Storage Settings')}} @endsection
@section('style')
    <x-media-upload.css/>
@endsection
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <x-admin.header-wrapper>
                    <x-slot name="left">
                        <h4 class="card-title mb-5">{{__('Storage Settings')}}</h4>
                    </x-slot>
                    <x-slot name="right" class="d-flex">
                        <form action="{{route(route_prefix().'admin.general.storage.settings')}}" method="post">
                            @csrf
                            <input type="hidden" name="_action" value="sync_file">
                           <button class="btn btn-info btn-sm" type="submit">{{__('Sync Local File To Cloud')}}</button>
                        </form>
                    </x-slot>
                </x-admin.header-wrapper>

                <x-error-msg/>
                <x-flash-msg/>
                <form class="forms-sample" method="post" action="{{route(route_prefix().'admin.general.storage.settings')}}">
                    @csrf
                        <x-fields.select name="storage_driver" title="{{__('Disks Driver')}}" info="{{__('By default it is local, if you have disk driver you can set here, unless leave this as (Local)')}}">
                            <option value="local" {{ get_static_option_central('storage_driver') == 'local' ? 'selected' : '' }}>{{__('Local')}}</option>
                            <option value="cloudFlareR2" {{ get_static_option_central('storage_driver') == 'cloudFlareR2' ? 'selected' : '' }}>{{__('cloud Flare R2')}}</option>
                            <option value="wasabi_s3" {{ get_static_option_central('storage_driver') == 'wasabi_s3' ? 'selected' : '' }}>{{__('Wasabi s3')}}</option>
                            <option value="s3" {{ get_static_option_central('storage_driver') == 's3' ? 'selected' : '' }}>{{__('Aws s3')}}</option>
                        </x-fields.select>
                    <button type="submit" class="btn btn-gradient-primary me-2">{{__('Save Changes')}}</button>
                </form>
            </div>
        </div>
    </div>
    <x-media-upload.markup/>
@endsection
@section('scripts')
    <x-media-upload.js/>
@endsection
