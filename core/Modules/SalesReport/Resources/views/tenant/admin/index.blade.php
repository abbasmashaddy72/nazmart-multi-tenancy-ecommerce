@extends('tenant.admin.admin-master')
@section('title')
    {{__('Sales Dashboard')}}
@endsection
@section('style')
    <x-datatable.css />
    <x-bulk-action.css />
@endsection
@section('content')
    <style>
        .box{
            padding: 20px 10px;
            padding-left: 25px;
        }
        .box_wrapper:nth-child(1) .box{
            color: #FC4F00;
            background: rgba(252, 79, 0, 0.1);
        }
        .box_wrapper:nth-child(2) .box{
            color: #0079FF;
            background: rgba(0, 121, 255, 0.1);
        }
        .box_wrapper:nth-child(3) .box{
            color: #22A699;
            background: rgba(34, 166, 153, 0.1);
        }
        .box_wrapper:nth-child(4) .box{
            color: #8F43EE;
            background: rgba(143, 67, 238, 0.1);
        }
    </style>
    <div class="col-lg-12 col-ml-12">
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="margin-top-40">
                    <x-error-msg/>
                    <x-flash-msg/>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 box_wrapper">
                                <div class="box">
                                    <p>{{__('Number of Sales')}}</p>
                                    <h2>{{$total_sale}}</h2>
                                </div>
                            </div>

                            <div class="col-lg-3 box_wrapper">
                                <div class="box">
                                    <p>{{__('Total Revenue')}}</p>
                                    <h2>{{amount_with_currency_symbol($total_revenue)}}</h2>
                                </div>
                            </div>

                            <div class="col-lg-3 box_wrapper">
                                <div class="box">
                                    <p>{{__('Total Profit')}}</p>
                                    <h2>{{amount_with_currency_symbol($total_profit)}}</h2>
                                </div>
                            </div>
                            <div class="col-lg-3 box_wrapper">
                                <div class="box">
                                    <p>{{__('Total Cost')}}</p>
                                    <h2>{{amount_with_currency_symbol($total_cost)}}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row my-5">
                            <div class="col-lg-12">
                                <div class="sales_table_wrapper">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Product')}}</th>
                                            <th>{{__('Qty')}}</th>
                                            <th>{{__('Cost')}}</th>
                                            <th>{{__('Price')}}</th>
                                            <th>{{__('Profit')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products ?? [] as $product)
                                                @foreach($product ?? [] as $item)
                                                    <tr>
                                                        <td>{{$item['product_id']}}</td>
                                                        <td>{{$item['sale_date']->format('m/d/Y')}}</td>
                                                        <td>
                                                            <span>{{$item['name']}}</span>
                                                            @if(!empty($item['variant']))
                                                                <span>
                                                                    <p>{{$item['variant']['color']}}</p>
                                                                    <p>{{$item['variant']['size']}}</p>
                                                                </span>
                                                            @endif

                                                        </td>
                                                        <td>{{$item['qty']}}</td>
                                                        <td>{{amount_with_currency_symbol($item['cost'])}}</td>
                                                        <td>{{amount_with_currency_symbol($item['price'])}}</td>
                                                        <td>{{amount_with_currency_symbol($item['profit'])}}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <x-datatable.js />
    <x-table.btn.swal.js />
    <x-bulk-action.js :route="route('tenant.admin.shipping.method.bulk.action')" />
@endsection
