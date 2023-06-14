<?php

namespace Modules\SalesReport\Http\Controllers\Tenant;

use App\Models\OrderProducts;
use App\Models\ProductOrder;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Mollie\Api\Resources\Order;

class SalesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $orders = ProductOrder::completed()->orderBy('id','desc')->get();

        $total_sale = 0;
        $total_revenue = 0;
        $total_profit = 0;
        $total_cost = 0;

        $products = [];

        foreach ($orders as $key => $order)
        {
            $order_details = json_decode($order->order_details);

            $index = 0;
            foreach ($order_details as $item)
            {
                $product_cost = $item->options->base_cost;
                $product_price = $item->price;

                $total_sale += 1;
                $total_cost += $product_cost;
                $total_profit += ($product_price - $product_cost);

                $products[$key][$index++] = [
                    'product_id' => $item->id,
                    'name' => $item->name,
                    'qty' => $item->qty,
                    'cost' => $product_cost,
                    'price' => $product_price,
                    'profit' => ($product_price - $product_cost),
                    'sale_date' => $order->updated_at,
                    'variant' => [
                        'color' => $item->options->color_name ?? '',
                        'size' => $item->options->size_name ?? '',
                        'attributes' => $item->options->attributes ?? [],
                    ]
                ];
            }


            $total_revenue += json_decode($order->payment_meta)->subtotal;
        }

//        dd($products);

        return view('salesreport::tenant.admin.index', compact('total_sale', 'total_revenue', 'total_cost', 'total_profit', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('salesreport::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('salesreport::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('salesreport::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
