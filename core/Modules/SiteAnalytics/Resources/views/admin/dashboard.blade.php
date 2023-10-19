@extends(route_prefix().'admin.admin-master')

@section('title')
    {{ __('Site Analytics Dashboard') }}
@endsection

@section('style')
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css">
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
                            <h4 class="header-title mb-2">{{__("Site Analytics Dashboard")}}</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="page-view chart-wrapper">
                                <div class="my-2" id="chart-total"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="min-h-screen bg-gray-100 text-gray-500 py-6 flex flex-col sm:py-16">
        <div class="px-4 w-full lg:px-0 sm:max-w-5xl sm:mx-auto">
            <div class="flex justify-end">
                @include('analytics::data.filter')
            </div>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                @each('analytics::stats.card', $stats, 'stat')
            </div>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                @include('analytics::data.pages-card')
                @include('analytics::data.sources-card')
                @include('analytics::data.users-card')
                @include('analytics::data.devices-card')
                @each('analytics::data.utm-card', $utm, 'data')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{global_asset('assets/landlord/admin/js/apexcharts.js')}}"></script>

    <script>
        const filterButton = document.getElementById('filter-button');
        const filterDropdown = document.getElementById('filter-dropdown');

        filterButton.addEventListener('click', function (e) {
            e.preventDefault();

            filterDropdown.style.display = 'block';
        });

        document.addEventListener('click', function (e) {
            if (!filterButton.contains(e.target) && !filterDropdown.contains(e.target)) {
                filterDropdown.style.display = 'none';
            }
        });
    </script>

    @php
//        $charts_data = array_map(function ($item){
//            $data = preg_replace_callback('/^\/|^\//', function ($matches) {
//                return $matches[0] === '/' ? '' : 'home';
//            }, $item);
//
//            $data['users'] = (int)$data['users'];
//            return $data;
//        }, $pages_charts->toArray());
//
//        $users = json_encode(array_column($charts_data ,'users'));
//        $pages = json_encode(array_column($charts_data ,'page'));

//        $users = json_encode(array_column($pages_charts->toArray() ,'users'));
//        $pages = json_encode(array_column($pages_charts->toArray() ,'page'));

//        $charts_data = array_map(function ($item){
//            $data['total_views'] = (int)$item['total_views'];
//            $data['created_at'] = \Carbon\Carbon::parse($item['created_at'])->format('d M Y');
//            return $data;
//        }, current($pages_charts));

        $views = json_encode(array_column(current($pages_charts) ,'total_views'));
        $date = json_encode(array_column(current($pages_charts) ,'time'));
    @endphp
    <script>
        $(document).ready(function () {
            const chartByTotal = () => {
                return {
                    series: [{
                        name: 'Page Views',
                        data: {{$views}}
                    }],
                    chart: {
                        height: 350,
                        type: 'bar',
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 10,
                            dataLabels: {
                                position: 'top', // top, center, bottom
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
                        categories: <?php echo $date ?>,
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
                                    colorFrom: '#0075ff',
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
                        text: '{{ucfirst($period)}} Page Views',
                        floating: true,
                        offsetY: 330,
                        align: 'center',
                        style: {
                            color: '#444'
                        }
                    }
                };

                {{--return {--}}
                {{--    series: [--}}
                {{--        {--}}
                {{--            name: '{{__('Views')}}',--}}
                {{--            data: {{json_encode($today['salesData'])}}--}}
                {{--        }--}}
                {{--    ],--}}
                {{--    chart: {--}}
                {{--        height: 350,--}}
                {{--        type: 'line',--}}
                {{--        toolbar: {--}}
                {{--            show: false--}}
                {{--        },--}}
                {{--        zoom: {--}}
                {{--            enabled: false--}}
                {{--        }--}}
                {{--    },--}}
                {{--    colors: ['#ff5252', '#0079FF', '#8F43EE', '#22A699'],--}}
                {{--    dataLabels: {--}}
                {{--        enabled: true,--}}
                {{--    },--}}
                {{--    stroke: {--}}
                {{--        curve: 'smooth'--}}
                {{--    },--}}
                {{--    title: {--}}
                {{--        text: '{{__('Today Revenue, Cost and Profit')}}',--}}
                {{--        align: 'left'--}}
                {{--    },--}}
                {{--    grid: {--}}
                {{--        borderColor: '#e7e7e7',--}}
                {{--        row: {--}}
                {{--            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns--}}
                {{--            opacity: 0.5--}}
                {{--        },--}}
                {{--    },--}}
                {{--    markers: {--}}
                {{--        size: 1--}}
                {{--    },--}}
                {{--    xaxis: {--}}
                {{--        categories: <?php echo json_encode($today['categories']) ?>,--}}
                {{--        title: {--}}
                {{--            text: '{{__('Time')}}'--}}
                {{--        }--}}
                {{--    },--}}
                {{--    yaxis: {--}}
                {{--        title: {--}}
                {{--            text: '{{__('Amount')}}'--}}
                {{--        },--}}
                {{--        min: 0,--}}
                {{--        max: {{$today['max_value']}}--}}
                {{--    },--}}
                {{--    legend: {--}}
                {{--        position: 'top',--}}
                {{--        horizontalAlign: 'right',--}}
                {{--        floating: true,--}}
                {{--        offsetY: -25,--}}
                {{--        offsetX: -5--}}
                {{--    }--}}
                {{--};--}}
            }

            new ApexCharts(document.querySelector("#chart-total"), chartByTotal()).render();
        });
    </script>
@endsection
