<?php

namespace Modules\SalesReport\Http\Controllers\Tenant;

use App\Http\Services\CustomPaginationService;
use App\Models\ProductOrder;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Modules\SalesReport\Http\Services\SalesReport;
use phpDocumentor\Reflection\Types\This;

class SalesReportController extends Controller
{
    /**
     * 01847111881
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $orders = ProductOrder::completed()->orderBy('id','desc')->get();

        $start_date = Carbon::parse('2023-01-01');
        $end_date = Carbon::parse('2023-06-15');
        $orders_weekly = ProductOrder::completed()
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('id','desc')->get();

        $orders_months = ProductOrder::completed()->orderBy('updated_at','asc')->get()
            ->groupBy(function ($query){
            // 'm' if month number is need, eg 05
            // 'M' if month name is needed, eg may
            return Carbon::parse($query->updated_at)->format('M Y');
        });

        $orders_years = ProductOrder::completed()->orderBy('id','desc')->get()
            ->groupBy(function ($query){
            // 'y' if year last two number is need, eg 23
            // 'Y' if full year number is needed, eg 2023
            return Carbon::parse($query->updated_at)->format('Y');
        });


        $reports = SalesReport::reports($orders);
        $total_report = [
            'total_sale' => $reports['total_sale'],
            'total_profit' => $reports['total_profit'],
            'total_revenue' => $reports['total_revenue'],
            'total_cost' => $reports['total_cost'],
            'products' => $reports['products']
        ];

        $reports = SalesReport::reports($orders_weekly);
        $weekly_report = [
            'total_sale' => $reports['total_sale'],
            'total_profit' => $reports['total_profit'],
            'total_revenue' => $reports['total_revenue'],
            'total_cost' => $reports['total_cost'],
            'products' => $reports['products']
        ];

        $monthly_report = $this->prepareDataForChart($orders_months);
        $yearly_report = $this->prepareDataForChart($orders_years);

        $display_item_count = request()->count ?? 10;
        $current_query = request()->all();
        $create_query = http_build_query($current_query);
        $route = 'tenant.admin';

        $products = $this->pagination_type($total_report['products'], $display_item_count, 'custom', route($route . ".sales.dashboard") . '?' . $create_query);
        return view('salesreport::tenant.admin.index', compact('total_report', 'weekly_report', 'monthly_report', 'yearly_report', 'products'));
    }

    private function prepareDataForChart($orders_months)
    {
        $data = SalesReport::reportByMonthsOrYears($orders_months);

        $categories = [];
        $profitData = [];
        $revenueData = [];
        $costData = [];

        foreach ($data as $month => $values) {
            $categories[] = $month;
            $profitData[] = $values['total_profit'];
            $revenueData[] = $values['total_revenue'];
            $costData[] = $values['total_cost'];
        }

        $max_value = max(array_merge($profitData,$revenueData, $costData) ?? []);

        return [
            'categories' => $categories,
            'profitData' => $profitData,
            'revenueData' => $revenueData,
            'costData' => $costData,
            'max_value' => $max_value
        ];
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

    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function pagination_type($all_products, $count, $type = "custom", $route=null){
        $display_item_count = $count ?? 10;
        $all_products = $this->paginate($all_products, $display_item_count);

        if(!empty($route)){
            $all_products->withPath($route);
        }


        if($type == "custom"){
            $current_items = (($all_products->currentPage() - 1) * $display_item_count);
            return [
                "items" => $all_products->items(),
                "current_page" => $all_products->currentPage(),
                "total_items" => $all_products->total(),
                "total_page" => $all_products->lastPage(),
                "next_page" => $all_products->nextPageUrl(),
                "previous_page" => $all_products->previousPageUrl(),
                "last_page" => $all_products->lastPage(),
                "per_page" => $all_products->perPage(),
                "path" => $all_products->path(),
                "current_list" => $all_products->count(),
                "from" => $all_products->count() ? $current_items + 1 : 0,
                "to" => $current_items + $all_products->count(),
                "on_first_page" => $all_products->onFirstPage(),
                "hasMorePages" => $all_products->hasMorePages(),
                "links" => $all_products->getUrlRange(0,$all_products->lastPage())
            ];
        }else{
            return $all_products;
        }
    }
}
