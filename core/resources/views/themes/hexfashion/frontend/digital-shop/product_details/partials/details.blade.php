@php
    $regular_price = $product->regular_price;
    $sale_price = $product->sale_price;

    if (!is_null($product->promotional_date) && !is_null($product->promotional_price))
    {
        $sale_price = $product->promotional_price;
    }

    $image = get_attachment_image_by_id($product->image_id);
    $image_url = !empty($image) ? $image['img_url'] : '';
@endphp

<div class="book-details-product bg-white details-product-padding">
    <div class="book-details-product-flex">
        <div class="book-details-product-content-thumb book-details-product-thumb-border book-details-product-thumb-padding">
            <div class="book-details-product-thumb bg-image" style="background-image: url({{$image_url}});">
            </div>
        </div>
        <div class="book-details-product-contents">
            {!! render_product_star_rating_markup_with_count($product) !!}
            <h2 class="book-details-product-contents-title mt-2"> {{$product->name}} </h2>
            <span class="book-details-product-contents-subtitle mt-1"> {{$product->additionalFields?->author?->name}} </span>
            <div class="price-update-through mt-3">
                @if($product->accessibility != 'free')
                    @if(!empty($sale_price) && $sale_price > 0)
                        <span class="fs-24 fw-500 flash-prices color-one"> {{float_amount_with_currency_symbol($sale_price)}} </span>
                        <span class="fs-16 flash-old-prices"> {{float_amount_with_currency_symbol($regular_price)}} </span>
                    @else
                        <span class="fs-24 fw-500 flash-prices color-one"> {{float_amount_with_currency_symbol($regular_price)}} </span>
                    @endif
                @else
                    <span class="fs-24 fw-500 flash-prices color-one"> {{__('Free')}} </span>
                @endif

            </div>
            <div class="book-details-product-contents-flex mt-4">
                <div class="available-stock">
                    {{__('Downloads')}} <span class="available color-heading"> (40 Copies) </span>
                </div>
            </div>
            <div class="btn-wrapper mt-4">
                @if(!is_null($product->preview_link))
                    <a href="{{$product->preview_link}}" class="cmn-btn cmn-btn-outline-one cmn-btn-small color-one radius-0 mt-2 pdf_preview"> {{__('Preview')}} </a>
                @endif
                <a href="javascript:void(0)" class="cmn-btn cmn-btn-bg-1 cmn-btn-small radius-0 mt-2 add_to_cart_single_page"> {{__('Add to Cart')}} </a>
            </div>
            <div class="book-details-product-contents-category mt-4 mt-xxl-5">
                <ul class="book-details-product-contents-category-list">
                    <li class="book-details-product-contents-category-list-item">
                        <span class="category-para"> {{__('Category:')}} </span>
                        <a class="fw-600 color-heading" href="javascript:void(0)"> {{$product?->category?->name}} </a>
                    </li>

                    @if(!empty($product->subCategory))
                        <li class="book-details-product-contents-category-list-item">
                            <span class="category-para"> {{__('Subcategory:')}} </span>
                            <a class="fw-600 color-heading" href="javascript:void(0)"> {{$product?->subCategory?->name}} </a>
                        </li>
                    @endif

                    @if(count($product->childCategory) > 0)
                        <li class="book-details-product-contents-category-list-item">
                            <span class="category-para"> {{__('Child category:')}} </span>

                            @foreach($product?->childCategory ?? [] as $child_category)
                                <a class="fw-600 color-heading" href="javascript:void(0)"> {{$child_category->name}} </a>{{!$loop->last ? ',' : ''}}
                            @endforeach
                        </li>
                    @endif

                    @if(!empty($product->tag))
                        <li class="book-details-product-contents-category-list-item">
                            <span class="category-para"> {{__('Tags:')}} </span>

                            @foreach($product->tag ?? [] as $tag)
                                <a class="fw-600 color-heading" href="javascript:void(0)"> {{$tag->tag_name}} </a>{{!$loop->last ? ',' : ''}}
                            @endforeach
                        </li>
                    @endif
                </ul>
                <ul class="book-details-product-contents-category-list">
                    <li class="book-details-product-contents-category-list-item">
                        {{$product->summary}}
                    </li>
                </ul>
            </div>
            <div class="single-blog-details-socials mt-4">
                <span class="single-blog-details-socials-title"> {{__('Share to:')}} </span>
                <div class="single-blog-details-socials-icon">
                    <ul class="single-blog-details-socials-list">
                        {!! single_post_share_bookpoint($product->slug, $product->name, $image_url) !!}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
