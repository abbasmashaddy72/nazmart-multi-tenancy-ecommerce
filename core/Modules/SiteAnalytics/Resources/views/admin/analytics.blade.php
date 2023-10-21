@extends(route_prefix().'admin.admin-master')

@section('title')
    {{ __('Site Analytics Dashboard') }}
@endsection

@section('style')
    <style>
        .card-header{
            background-color: rgba(249,250,251,1);
        }
        .card-header p{
            font-size: .75rem;
        }
        .apexcharts-canvas {
            margin-inline: auto;
        }
        .pagesFav {
            object-fit: contain;
        }
        .recent-orderChart {
            height: 100%;
        }
        a{
            text-decoration: none;
            color: var(--bs-dark);
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-recent-order">
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    @include('siteanalytics::admin.data.filter')
                </div>
            </div>
        </div>

        <div class="dashboard-recent-order">
            <div class="row g-4 mt-1">
                <x-flash-msg/>
                <x-error-msg/>
                <div class="col-md-6">
                    <div class="p-4 recent-order-wrapper recent-orderChart bg-white">
                        <div class="wrapper d-flex justify-content-between">
                            <div class="header-wrap">
                                <h4 class="header-title mb-2 text-capitalize">{{__("all subscription plan views")}}</h4>
                            </div>
                        </div>
                        <div class="page-view chart-wrapper">
                            <div class="my-2" id="chart-total"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-4 recent-order-wrapper recent-orderChart bg-white">
                        <div class="wrapper d-flex justify-content-between">
                            <div class="header-wrap">
                                <h4 class="header-title mb-2 text-capitalize">{{__("locations and devices")}}</h4>
                            </div>
                        </div>
                        <div class="page-view chart-wrapper">
                            <div id="chart-country"></div>
                            <div id="chart-device"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-1 row g-4">
            <div class="col-lg-6">
                @include('siteanalytics::admin.data.plan-card')
            </div>
            <div class="col-lg-6">
                @include('siteanalytics::admin.data.sources-card')
            </div>
            <div class="col-lg-6">
                @include('siteanalytics::admin.data.users-card')
            </div>
            <div class="col-lg-6">
                @include('siteanalytics::admin.data.devices-card')
            </div>
        </div>
        @endsection

        @section('scripts')
            <script src="{{global_asset('assets/landlord/admin/js/apexcharts.js')}}"></script>

            @php
                $plans = \App\Models\PricePlan::where('status', 1)->select(['id', 'title'])->pluck('title', 'id');

                $pages_array = $pages->toArray();
                $plan_pages = array_map(function ($item) {
                    $item['page'] = str_replace(['/plan-order/', '/view-plan/','/trial'],'',$item['page']);
                    return $item;
                }, $pages_array);

                $plan_with_names = [];
                foreach ($plan_pages ?? [] as $key => $item)
                {
                    $plan_with_names[$key]['users'] = $item['users'];
                    $plan_with_names[$key]['name'] = current($plans)[$item['page']] ?? '';
                }

                $views = json_encode(array_column($plan_with_names ,'users'));
                $name = json_encode(array_column($plan_with_names ,'name'));

                $country = json_encode(array_column(current($users) ,'country'));
                $country_users = json_encode(array_column(current($users) ,'users'));

                $device = json_encode(array_column(current($devices) ,'type'));
                $device_users = json_encode(array_column(current($devices) ,'users'));
            @endphp
            <script>
                $(document).ready(function () {
                    const chartByTotal = () => {
                        return {
                            series: [{
                                name: `{{__('Plan Views')}}`,
                                data: {{$views}}
                            }],
                            chart: {
                                height: 500,
                                type: 'bar',
                            },
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    dataLabels: {
                                        position: 'top',
                                    },
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                offsetY: -23,
                                style: {
                                    fontSize: '14px',
                                    colors: ["#304758"]
                                }
                            },

                            xaxis: {
                                categories: <?php echo $name ?>,
                                position: 'top',
                                axisBorder: {
                                    show: false
                                },
                                axisTicks: {
                                    show: false
                                },
                                crosshairs: {
                                    fill: {
                                        type: 'gradient',
                                        gradient: {
                                            colorFrom: 'rgb(214,233,255)',
                                            colorTo: '#BED1E6',
                                            stops: [0, 100],
                                            opacityFrom: 0.4,
                                            opacityTo: 0.5,
                                        }
                                    }
                                },
                                tooltip: {
                                    enabled: false,
                                }
                            },
                            yaxis: {
                                axisBorder: {
                                    show: false
                                },
                                axisTicks: {
                                    show: false,
                                },
                                labels: {
                                    show: false
                                }

                            },
                            title: {
                                text: '{{ucwords(str_replace('_',' ', $period))}} Page Views',
                                floating: false,
                                offsetY: 0,
                                align: 'center',
                                bottom: 0,
                                style: {
                                    color: '#444'
                                }
                            }
                        };
                    }

                    const chartByCountry = () => {
                        return {
                            series: {{$country_users}},
                            chart: {
                                width: 400,
                                type: 'pie',
                            },
                            labels: <?php echo $country ?>,
                            responsive: [{
                                breakpoint: 480,
                                options: {
                                    chart: {
                                        width: 200
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        };
                    }

                    const chartByDevice = () => {
                        return {
                            series: {{$device_users}},
                            chart: {
                                width: 390,
                                type: 'pie',
                            },
                            labels: <?php echo $device ?>,
                            responsive: [{
                                breakpoint: 480,
                                options: {
                                    chart: {
                                        width: 200
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        };
                    }

                    new ApexCharts(document.querySelector("#chart-total"), chartByTotal()).render();
                    new ApexCharts(document.querySelector("#chart-country"), chartByCountry()).render();
                    new ApexCharts(document.querySelector("#chart-device"), chartByDevice()).render();
                });
            </script>
@endsection
