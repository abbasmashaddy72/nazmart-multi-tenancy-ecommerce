<?php

namespace App\Http\Controllers\Tenant\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\DigitalProduct\Entities\DigitalProduct;

class FrontendDigitalProductController extends Controller
{
    public function shop_page(Request $request)
    {
        $product_object = DigitalProduct::where('status_id', 1);

        if ($request->has('category')) {
            $category = $request->category;
            $product_object->whereHas('category', function ($query) use ($category) {
                return $query->where('slug', $category);
            });
        }

        if ($request->has('author')) {
            $author = $request->author;
            $product_object->whereHas('additionalFields.author', function ($query) use ($author) {
                return $query->where('slug', $author);
            });
        }

        if ($request->has('language')) {
            $language = $request->language;
            $product_object->whereHas('additionalFields.language', function ($query) use ($language) {
                return $query->where('slug', $language);
            });
        }

        if ($request->has('tag')) {
            $tag = $request->tag;
            $product_object->whereHas('tag', function ($query) use ($tag) {
                return $query->where('tag_name', 'LIKE', "%{$tag}%");
            });
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $min_price = $request->min_price;
            $max_price = $request->max_price;
            $product_object->whereBetween('regular_price', [$min_price, $max_price]);
        }

        if ($request->has('rating')) {
            $rating = $request->rating;

            $product_object->whereHas('reviews', function ($query) use ($rating) {
                $query->where('rating', $rating);
            });
        }

        if ($request->has('sort')) {

            $order = 'desc';
            switch ($request->sort) {
                case 1:
                    $order_by = 'name';
                    break;
                case 2:
                    $order_by = 'rating';
                    break;
                case 3:
                    $order_by = 'created_at';
                    break;
                case 4:
                    $order_by = 'sale_price';
                    $order = 'asc';
                    break;
                case 5:
                    $order_by = 'sale_price';
                    break;
                default:
                    $order_by = 'created_at';
            }

            $product_object->orderBy($order_by, $order);
        } else {
            $product_object->latest();
        }

        $product_object = $product_object->paginate(12)->withQueryString();

        $create_arr = $request->all();
        $create_url = http_build_query($create_arr);

        $product_object->url(route('tenant.digital.shop') . '?' . $create_url);

        $links = $product_object->getUrlRange(1, $product_object->lastPage());
        $current_page = $product_object->currentPage();

        $products = $product_object->items();

        $grid = themeView("digital-shop.partials.product-partials.grid-products", compact("products", "links", "current_page"))->render();

        return response()->json(["grid" => $grid, 'pagination' => $product_object]);
    }

    public function shop_search(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);

        $search = $request->search;

        $product_object = Product::with('badge', 'campaign_product')
            ->where('status_id', 1)
            ->where("name", "LIKE", "%" . $search . "%")
            ->orWhere("sale_price", $search);

        $product_object = $product_object->paginate(30)->withQueryString();

        $create_arr = $request->all();
        $create_url = http_build_query($create_arr);


        $product_object->url(route('tenant.shop') . '?' . $create_url);
        $product_object->url(route('tenant.shop') . '?' . $create_url);

        $links = $product_object->getUrlRange(1, $product_object->lastPage());
        $current_page = $product_object->currentPage();

        $products = $product_object->items();

        $grid = themeView("shop.partials.product-partials.grid-products", compact("products", "links", "current_page"))->render();
        $list = themeView("shop.partials.product-partials.list-products", compact("products", "links", "current_page"))->render();

        if ($request->ajax()) {
            return response()->json(["list" => $list, "grid" => $grid, 'pagination' => $product_object]);
        }

        return themeView('shop.product-single-search', compact('product_object', 'search'));
    }
}
