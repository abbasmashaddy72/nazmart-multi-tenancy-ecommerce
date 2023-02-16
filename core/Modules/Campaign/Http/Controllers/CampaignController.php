<?php

namespace Modules\Campaign\Http\Controllers;

use App\Helpers\FlashMsg;
use App\Helpers\SanitizeInput;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Campaign\Entities\Campaign;
use Modules\Campaign\Entities\CampaignProduct;
use Modules\Product\Entities\Product;
use Razorpay\Api\Resource;
use Sabberworm\CSS\Renderable;

class CampaignController extends Controller
{
    const BASE_URL = 'campaign::backend.';

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:campaign-list|campaign-create|campaign-edit|campaign-delete', ['only', ['index']]);
        $this->middleware('permission:campaign-create', ['only', ['store']]);
        $this->middleware('permission:campaign-edit', ['only', ['update']]);
        $this->middleware('permission:campaign-delete', ['only', ['destroy', 'bulk_action']]);
    }

    public function index()
    {
        $all_campaigns = Campaign::with("campaignImage")->get();
        return view(self::BASE_URL.'all', compact('all_campaigns'));
    }

    public function create()
    {
        $all_campaign_products = CampaignProduct::select('product_id')->pluck('product_id')->toArray();
        $all_products = Product::with('inventory')->where('status_id', '1')->whereNotIn('id', $all_campaign_products)->get();
        return view(self::BASE_URL.'new', compact('all_products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'campaign_name' => 'required|string|max:191',
            'campaign_subtitle' => 'required|string',
            'campaign_start_date' => 'required',
            'campaign_end_date' => 'required',
        ]);

        try{
            DB::beginTransaction();
            $campaign = Campaign::create([
                'title' => SanitizeInput::esc_html($request->campaign_name),
                'subtitle' => SanitizeInput::esc_html($request->campaign_subtitle),
                'image' => $request->image,
                'status' => $request->status,
                'start_date' => $request->campaign_start_date,
                'end_date' => $request->campaign_end_date,
            ] + $this->how_is_the_owner());

            if ($campaign->id) {
                $validated_product_data = $this->getValidatedCampaignProducts($request);
                $this->insertCampaignProducts($campaign->id, $validated_product_data);
            }

            DB::commit();
            return back()->with(FlashMsg::create_succeed('Campaign'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with(FlashMsg::create_failed('Campaign'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign\Campaign  $campaign
     * @return Response
     */
    public function show(Campaign $campaign)
    {
        //
    }


    public function edit(Campaign $item)
    {
        $campaign = Campaign::with(['products', 'products.product','admin'])->findOrFail($item->id);
        $other_campaign_products = CampaignProduct::select('product_id')->where('campaign_id', '!=', $campaign->id)->pluck('product_id')->toArray();
        $all_products = Product::with('inventory')->where('status_id', 1)->whereNotIn('id', $other_campaign_products)->get();

        return view(self::BASE_URL.'edit', compact('campaign', 'all_products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'campaign_name' => 'required|string|max:191',
            'campaign_subtitle' => 'required|string',
            'image' => 'required|string',
            'status' => 'required|string',
            'campaign_start_date' => 'required',
            'campaign_end_date' => 'required',
        ]);

        DB::beginTransaction();
        try{
            $campaign = Campaign::findOrFail($request->id)->update([
                'title' => SanitizeInput::esc_html($request->campaign_name),
                'subtitle' => SanitizeInput::esc_html($request->campaign_subtitle),
                'image' => $request->image,
                'status' => $request->status,
                'start_date' => $request->campaign_start_date,
                'end_date' => $request->campaign_end_date,
            ] + $this->how_is_the_owner());

            $this->updateCampaignProducts($request->id, $request);

            DB::commit();
            return back()->with(FlashMsg::update_succeed('Campaign'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with(FlashMsg::update_failed('Campaign'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign\Campaign  $campaign
     * @return Response
     */
    public function destroy(Campaign $item)
    {
        try {
            DB::beginTransaction();
            $products = $item->products;
            if ($products->count()) {
                foreach ($products as $product) {
                    $product->delete();
                }
            }
            $item_deleted = $item->delete();
            DB::commit();

            return back()->with(FlashMsg::delete_succeed('Campaign'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function bulk_action(Request $request)
    {
        try {
            DB::beginTransaction();
            $all_campaigns = Campaign::whereIn('id', $request->ids)->delete();
            $campaign_products = CampaignProduct::whereIn('campaign_id', $request->ids)->delete();
            DB::commit();
            return 'ok';
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function getProductPrice(Request $request)
    {
        $price = Product::findOrFail($request->id)->price;
        return response()->json(['price' => $price], 200);
    }

    public function deleteProductSingle(Request $request)
    {
        return (bool) CampaignProduct::findOrFail($request->id)->delete();
    }

    /**====================================================================
     *                  CAMPAIGN PRODUCT FUNCTIONS
    ==================================================================== */
    public function updateCampaignProducts($campaign_id, $request)
    {
        try {
            DB::beginTransaction();

            $delete = $this->deleteCampaignProducts($campaign_id);
            $validated_product_data = $this->getValidatedCampaignProducts($request);
            $campaign_products = $this->insertCampaignProducts($campaign_id, $validated_product_data, $request->campaign_start_date, $request->campaign_end_date);

            DB::commit();
        }catch(\Throwable $th) {
            DB::rollBack();

            return false;
        }
    }

    public function getValidatedCampaignProducts(Request $request): array
    {
        return $request->validate([
            'product_id' => 'required|array',
            'campaign_price' => 'required|array',
            'units_for_sale' => 'required|array',
            'start_date' => 'required|array',
            'end_date' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
            'campaign_price.*' => 'required|string',
            'units_for_sale.*' => 'required|string',
            'start_date.*' => 'nullable|date',
            'end_date.*' => 'nullable|date',
        ]);
    }

    public function insertCampaignProducts($campaign_id, $products_data, $start_date = null, $end_date = null): bool
    {
        $insert_data = [];

        foreach ($products_data['product_id'] as $key => $value) {
            $insert_data[$products_data['product_id'][$key]] = [
                'campaign_id' => $campaign_id,
                'product_id' => $products_data['product_id'][$key],
                'campaign_price' => $products_data['campaign_price'][$key],
                'units_for_sale' => $products_data['units_for_sale'][$key],
                'start_date' => $products_data['start_date'][$key] ?? $start_date,
                'end_date' => $products_data['end_date'][$key] ?? $end_date,
            ];
        }

        return (bool) CampaignProduct::insert($insert_data);
    }

    public function deleteCampaignProducts($all_product_id): bool
    {
        return (bool) CampaignProduct::where('campaign_id', $all_product_id)->delete();
    }

    private function userId(){
        return \Auth::guard("admin")->check() ? \Auth::guard("admin")->user()->id : '';
    }

    private function getGuardName(): string
    {
        return \Auth::guard("admin")->check() ? "admin" : "";
    }


    private function how_is_the_owner(): array
    {
        $arr = [];
        if($this->getGuardName() == "admin"){
            $arr = [
                "admin_id" => $this->userId(),
                "vendor_id" => null,
                "type" => $this->getGuardName(),
            ];
        }

        return $arr;
    }
}
