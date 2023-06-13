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
        $orders = ProductOrder::completed()->get();

        $total_sale = 0;
        $total_product_sale = 0;
        $total_revenue = 0;
        $total_profit = 0;
        $total_cost = 0;

        foreach ($orders as $order)
        {
            dd(json_decode($orders[1]->order_details), json_decode($orders[1]->payment_meta));
            $order_details = json_decode($order->order_details);
            $product_id = $order_details->id;

            $product = Product::find($product_id);

            $total_revenue += json_decode($order->payment_meta)->subtotal;
        }

        return view('salesreport::tenant.admin.index');
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
