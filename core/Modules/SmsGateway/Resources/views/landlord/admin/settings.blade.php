@extends('landlord.admin.admin-master')

@section('title')
    {{ __('SMS Gateway') }}
@endsection

@section('style')
    <style>
        .plugin-grid {
            display: flex;
            flex-wrap: wrap;
            /*justify-content: space-between;*/
            /*padding: 1em;*/
            gap: 1em;  /* space between grid items */
        }

        .plugin-card {
            width: calc((100% - 2em) / 3);  /* for a three column layout */
            box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.2);
            /*padding: 1em;*/
            text-align: center;
        }
        .plugin-card .thumb-bg-color {
            background-color: #009688;
            padding: 40px;
            color: #fff;
        }

        .plugin-card .thumb-bg-color strong {
            font-size: 20px;
            line-height: 26px;
        }

        .plugin-card .thumb-bg-color strong .version {
            font-size: 14px;
            line-height: 18px;
            background-color: #fff;
            padding: 5px 10px;
            display: inline-block;
            color: #333;
            border-radius: 3px;
            margin-top: 15px;
        }

        .plugin-title {
            font-size: 16px;
            font-weight: 500;
            background-color: #03A9F4;
            box-shadow: 0 0 30px 0 rgba(0,0,0,0.2);
            display: inline-block;
            padding: 12px 30px;
            border-radius: 25px;
            color: #fff;
            position: relative;
            margin-top: -20px;
        }
        .plugin-title.externalplugin {
            background-color: #3F51B5;
        }
        .plugin-meta {
            font-size: 0.9em;
            color: #666;
            padding: 20px;
        }
        .padding-30{
            padding: 30px;
        }
        .plugin-card .thumb-bg-color.externalplugin {
            background-color: #FF9800;
        }

        .plugin-card .plugin-meta {
            min-height: 50px;
        }
        .plugin-card .btn-group-wrap {
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .plugin-card .btn-group-wrap a {
            display: inline-block;
            padding: 8px 25px;
            background-color: #4b4e5b;
            border-radius: 25px;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            transition: all 300ms;
        }

        .plugin-card .btn-group-wrap a.pl_delete {
            background-color: #e13a3a;
        }
        .plugin-card .btn-group-wrap a:hover{
            opacity: .8;
        }
        /* For large screens and above */
        @media (min-width: 900px) {
            .plugin-card {
                width: calc((100% - 3em) / 3);  /* three columns for large screens */
            }
        }

        /* For medium screens and above */
        @media (max-width: 600px) {
            .plugin-card {
                width: calc((100% - 2em) / 2);  /* two columns for medium screens */
            }
            .plugin-card .btn-group-wrap {
                gap: 5px;
            }
            .plugin-card .btn-group-wrap a {
                padding: 7px 15px;
            }
            .plugin-title {
                font-size: 12px;
                line-height: 16px;
            }
        }
        @media (max-width: 500px) {
            .plugin-card {
                width: calc((100% - 2em) / 1);  /* two columns for medium screens */
            }
            .plugin-title {
                font-size: 16px;
                line-height: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-recent-order">
        <div class="row">
            <x-flash-msg/>
            <div class="col-md-12">
                <div class="p-4 recent-order-wrapper dashboard-table bg-white padding-30">
                    <div class="header-wrap">
                        <h4 class="header-title mb-2">{{__("SMS Gateway Settings")}}</h4>
                        <p>{{__("Manage all sms gateway from here, you can active/deactivate any sms gateway from here.")}}</p>
                    </div>

                    <x-fields.switcher label="Enable or disable OTP login" name="otp_login_status" value="{{get_static_option('otp_login_status')}}"/>

                    <div class="my-5 plugin-grid" @style(['display: none' => empty(get_static_option('otp_login_status'))])>
                        @php
                            $smsGatewayList = ['twilio'];
                        @endphp
                        @foreach($smsGatewayList as $item)
                            @php
                                $sms_gateway = \Modules\SmsGateway\Entities\SmsGateway::where('name', $item)->first();
                                $status = $sms_gateway->status ?? 0;
                                $otp_time = $sms_gateway->otp_expire_time ?? 0;
                                $credentials = $sms_gateway->credentials ?? '{}';
                            @endphp

                            <div class="plugin-card">
                                <div class="thumb-bg-color google_analytics">
                                    <strong class="google_analytics text-capitalize">{{$item}}</strong>
                                </div>
                                <p class="plugin-meta">
                                    {{__("You can learn more about it from here,")}}
                                    <a href="https://www.twilio.com/" target="_blank">{{__('Link')}}</a>
                                </p>
                                <div class="btn-group-wrap">
                                    <a href="#"
                                       data-option="{{$item}}"
                                       data-status="{{$status}}"
                                       class="pl-btn pl_active_deactive {{$status ? 'bg-success' : ''}}">{{$status ? __('Activated') : __('Deactivated')}}</a>

                                    <a href="#" data-bs-target="#{{$item}}_modal" data-bs-toggle="modal"
                                       data-option="{{$item}}"
                                       data-otp-time="{{$otp_time}}"
                                       data-credentials="{{$credentials}}"
                                       class="pl-btn pl_delete pl_settings">{{__("Settings") }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="twilio_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize">{{__("twilio")}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{route(route_prefix().'admin.sms.settings')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="sms_gateway_name" value="twilio">
                    <div class="card-body">
                        <!--otp env settings -->
                        <h5 class="mb-4">{{ __('Configure Twilio credentials') }}</h5>
                        <div class="form-group mt-3">
                            <label for="TWILIO_SID"><strong>{{__('Twilio SID')}} <span class="text-danger">*</span> </strong></label>
                            <input type="text"  class="form-control" name="twilio_sid" value="{{ env('twilio_sid') }}"
                                   placeholder="{{ __('Twilio SID')}}">
                        </div>

                        <div class="form-group">
                            <label for="TWILIO_AUTH_TOKEN"><strong>{{__('Twilio Auth Token')}} <span class="text-danger">*</span></strong></label>
                            <input type="text"  class="form-control" name="twilio_auth_token" value="{{ env('twilio_auth_token') }}"
                                   placeholder="{{ __('Twilio Auth Token')}}">
                        </div>

                        <div class="form-group">
                            <label for="TWILIO_NUMBER"><strong>{{__('Valid Twilio Number')}} <span class="text-danger">*</span> </strong></label>
                            <input type="text" class="form-control" name="twilio_number" value="{{ env('twilio_number') }}"
                                   placeholder="{{ __('Valid Twilio Number')}}">
                        </div>

                        {{--                            <div class="form-group">--}}
                        {{--                                <label for="disable_user_otp_verify"><strong>{{__('User OTP Verify')}}</strong></label>--}}
                        {{--                                <label class="switch">--}}
                        {{--                                    <input type="checkbox" name="disable_user_otp_verify"  @if(!empty(get_static_option('disable_user_otp_verify'))) checked @endif id="disable_user_otp_verify">--}}
                        {{--                                    <span class="slider-enable-disable"></span>--}}
                        {{--                                </label>--}}
                        {{--                                <span class="form-text text-muted">{{__('Disable, means user must have to verify their OTP in order to access his/her dashboard.')}}</span>--}}
                        {{--                            </div>--}}

                        <div class="form-group">
                            <label for="disable_user_otp_verify"><strong>{{__('OTP Expire Time Add')}}</strong></label>
                            <select name="user_otp_expire_time" class="form-control">
                                <option  value="30">{{__('30 Second')}}</option>
                                @for($i=1; $i<=5; $i=$i+0.5)
                                    <option value="{{$i}}">{{__($i . ($i > 1 ? ' Minutes' : ' Minute'))}}</option>
                                @endfor
                            </select>
                            <p class="form-text text-muted mt-2">{{__('User OTP verify Expire Time Add.')}}</p>
                        </div>

                        <button type="submit" id="update" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function ($) {
            "use strict";

            $(document).on('change', 'input[name=otp_login_status]', function (e) {
                Swal.fire({
                    title: '{{__("Are you sure?")}}',
                    text: '{{__("You will able revert your decision anytime")}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{__('Yes!')}}",
                    cancelButtonText: "{{__('Cancel')}}",

                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.get("{{route(route_prefix()."admin.sms.login.otp.status")}}")
                            .then((response) => {
                                if (response.data.type === 'success') {
                                    toastr.success(`{{__('Settings updated')}}`);
                                    let plugin_grid = $('.plugin-grid');
                                    plugin_grid.toggle();
                                }
                            });
                    } else {
                        location.reload();
                    }
                });
            });

            $(document).on('click', '.pl_settings', function (e) {
                e.preventDefault();

                let el = $(this);
                let option = el.attr('data-option');
                let otp_expire_time = el.attr('data-otp-time');
                let credentials = el.attr('data-credentials');
                credentials = jQuery.parseJSON(credentials);

                let modal = $(`#${option}_modal`);
                for (let item in credentials)
                {
                    modal.find(`input[name=${item}]`).val(credentials[item]);
                }
                modal.find(`select[name=user_otp_expire_time] option[value=${otp_expire_time}]`).attr('selected', true)
            });

            $(document).on("click", '.pl_active_deactive', function (e) {
                e.preventDefault();
                var el = $(this);
                Swal.fire({
                    title: '{{__("Are you sure?")}}',
                    text: '{{__("you will able revert your decision anytime")}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{__('Yes!')}}",
                    cancelButtonText: "{{__('Cancel')}}",

                }).then((result) => {
                    if (result.isConfirmed) {
                        //todo: ajax call
                        let optionName = el.data('option');
                        let status = el.data('status');

                        axios.post("{{route(route_prefix()."admin.sms.status")}}", {
                            option_name: optionName,
                            status: status
                        })
                            .then((response) => {
                                if (response.data.type === 'success') {
                                    location.reload();
                                }
                            });
                    }
                });
            })

        })(jQuery);
    </script>
@endsection
