<?php

namespace App\Http\Services;

use Carbon\Carbon;

class TaxRenderService
{
    public array $prices;
    public function __construct(public object $product_object){}

    public function getProductPrice()
    {
        $this->prices['regular_price'] = $this->product_object->price ? (double) $this->product_object->price : null;
        $this->prices['sale_price'] = (double) $this->product_object->sale_price;

        $this->getCampaignPrice();

        dd($this->includeTaxPriceInShop());

        return $this->prices;
    }

    private function getCampaignPrice(): void
    {
        if ($this->hasCampaign()) {
            if ($this->campaignStatus()) {
                $start_date = Carbon::parse($this->product_object?->campaign_product?->start_date);
                $end_date = Carbon::parse($this->product_object?->campaign_product?->end_date);

                if ($start_date->lessThanOrEqualTo(now()) && $end_date->greaterThanOrEqualTo(now())) {
                    $this->prices['campaign_name'] = (string) $this->product_object?->campaign_product?->campaign?->title;
                    $this->prices['sale_price'] = (double) $this->product_object?->campaign_product?->campaign_price;
                    $this->prices['regular_price'] = (double) $this->product_object->sale_price;

                    $this->prices['discount'] = 100 - round(($this->prices['sale_price'] / ($this->prices['regular_price'] ?? 1)) * 100);
                }
            }
        }
    }

    public function hasCampaign(): bool
    {
        return !empty($this->product_object?->campaign_product);
    }

    public function campaignStatus(): bool
    {
        return $this->product_object?->campaign_product?->campaign?->status == 'publish';
    }

    public function getTaxedPrice()
    {
        if ($this->isAdvancedTaxSystem() && $this->isPriceIncludingTax())
        {
            if ($this->includeTaxPriceInShop())
            {

            }
        }
    }

    public function getTaxInfo(): array
    {
        $prices_include_tax = get_static_option("prices_include_tax", "no");
//        update_static_option("calculate_tax_based_on", $request->calculate_tax_based_on ?? "");
//        update_static_option("shipping_tax_class", $request->shipping_tax_class ?? "");
//        update_static_option("tax_round_at_subtotal", $request->tax_round_at_subtotal ?? "");
//        update_static_option("display_tax_total", $request->display_tax_total ?? "");
        $display_price_in_the_shop = get_static_option("display_price_in_the_shop", "exclusive");
        $tax_system = get_static_option("tax_system", "zone_wise_tax_system");

        return [
            "prices_include_tax" => $prices_include_tax,
            "tax_system" => $tax_system,
            "display_price_in_the_shop" => $display_price_in_the_shop
        ];
    }

    private function isAdvancedTaxSystem(): bool
    {
        $tax_info = $this->getTaxInfo();
        return $tax_info['tax_system'] == 'advance_tax_system';
    }

    private function isPriceIncludingTax(): bool
    {
        $tax_info = $this->getTaxInfo();
        return $tax_info['prices_include_tax'] == 'yes';
    }

    private function includeTaxPriceInShop(): bool
    {
        $tax_info = $this->getTaxInfo();
        return $tax_info['display_price_in_the_shop'] == 'including';
    }
}
