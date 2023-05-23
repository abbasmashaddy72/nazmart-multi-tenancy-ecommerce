{{--@dd($data)--}}
{{--<!-- Trendy area starts -->--}}
{{--<section class="trendy-area" data-padding-top="{{$data['padding_top']}}"--}}
{{--         data-padding-bottom="{{$data['padding_bottom']}}">--}}
{{--    <div class="container container-one">--}}
{{--        <div class="section-title theme-two">--}}
{{--            <h2 class="title fw-400"> {{\App\Helpers\SanitizeInput::esc_html($data['title']) ?? 'Title'}} </h2>--}}
{{--            <p class="para"> {{\App\Helpers\SanitizeInput::esc_html($data['subtitle']) ?? ''}} </p>--}}
{{--        </div>--}}
{{--        <div class="row gy-4 mt-3">--}}
{{--            @foreach($data['products'] as $product)--}}
{{--                @php--}}
{{--                    $data = get_product_dynamic_price($product);--}}
{{--                    $campaign_name = $data['campaign_name'];--}}
{{--                    $regular_price = $data['regular_price'];--}}
{{--                    $sale_price = $data['sale_price'];--}}
{{--                    $discount = $data['discount'];--}}
{{--                @endphp--}}

{{--                <div class="col-xl-3 col-lg-4 col-md-6">--}}
{{--                    <div class="global-card center-text no-shadow radius-0 pb-0">--}}
{{--                        <div class="global-card-thumb">--}}
{{--                            <a href="{{route('tenant.shop.product.details', $product->slug)}}">--}}
{{--                                {!! render_image_markup_by_attachment_id($product->image_id, 'rounded', 'grid') !!}--}}
{{--                            </a>--}}

{{--                            <div class="global-card-thumb-badge right-side">--}}
{{--                                @if($discount != null)--}}
{{--                                    <span--}}
{{--                                        class="global-card-thumb-badge-box bg-color-two"> {{$discount}}% {{__('off')}} </span>--}}
{{--                                @endif--}}
{{--                                @if(!empty($product->badge))--}}
{{--                                    <span--}}
{{--                                        class="global-card-thumb-badge-box bg-color-new"> {{$product?->badge?->name}} </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}

{{--                            @include('tenant.frontend.shop.partials.product-options')--}}
{{--                        </div>--}}
{{--                        <div class="global-card-contents">--}}
{{--                            <h5 class="global-card-contents-title">--}}
{{--                                <a href="{{route('tenant.shop.product.details', $product->slug)}}"> {{Str::words($product->name, 4)}} </a>--}}
{{--                            </h5>--}}

{{--                            {!! render_product_star_rating_markup_with_count($product) !!}--}}

{{--                            <div class="price-update-through mt-3">--}}
{{--                                <span--}}
{{--                                    class="flash-prices color-three"> {{amount_with_currency_symbol($sale_price)}} </span>--}}
{{--                                <span--}}
{{--                                    class="flash-old-prices"> {{$regular_price != null ? amount_with_currency_symbol($regular_price) : ''}} </span>--}}
{{--                            </div>--}}

{{--                            <div class="btn-wrapper">--}}
{{--                                @if($product->inventory_detail_count < 1)--}}
{{--                                    <a href="javascript:void(0)" data-product_id="{{ $product->id }}"--}}
{{--                                       class="cmn-btn cmn-btn-outline-three radius-0 mt-3 add-to-cart-btn"> {{__('Add to Cart')}} </a>--}}
{{--                                @else--}}
{{--                                    <a href="javascript:void(0)"--}}
{{--                                       data-action-route="{{ route('tenant.products.single-quick-view', $product->slug) }}"--}}
{{--                                       class="cmn-btn cmn-btn-outline-three radius-0 mt-3 product-quick-view-ajax"> {{__('Add to Cart')}} </a>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
{{--<!-- Trendy area end -->--}}


<!-- Collection area starts -->
<section class="collection-area padding-top-130 padding-bottom-130 body-bg-2">
    <div class="container-three">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-three text-center">
                    <h2 class="title">
                        @if(!empty($data['title_line']))
                            @php
                                $title_line = get_attachment_image_by_id(get_static_option('title_shape_image'));
                                $title_line_image = !empty($title_line) ? $title_line['img_url'] : '';
                            @endphp

                            <img class="line-round" src="{{$title_line_image}}" alt="">
                        @endif
                        {{$data['title'] ?? ''}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row margin-top-40">
            @foreach($data['products'] as $product)
                @php
                    $data = get_product_dynamic_price($product);
                    $campaign_name = $data['campaign_name'];
                    $regular_price = $data['regular_price'];
                    $sale_price = $data['sale_price'];
                    $discount = $data['discount'];

                    $delay = $loop->odd ? '.1s' : '.2s';
                    $fadeClass = $loop->odd ? 'fadeInUp' : 'fadeInDown';
                @endphp

                <div class="col-xl-3 col-sm-6 margin-top-30 wow {{$fadeClass}}" data-wow-delay="{{$delay}}">
                    <div class="signle-collection text-center padding-0">
                        <div class="collction-thumb">
                            <a href="{{route('tenant.shop.product.details', $product->slug)}}">
                                {!! render_image_markup_by_attachment_id($product->image_id, 'radius-0') !!}
                            </a>

                            <ul class="collection-icon-list color-three">
                                <li class="lists">
                                    <a class="icon cart-loading" href="javascript:void(0)"> <i class="lar la-heart"></i>
                                    </a>
                                </li>
                                <li class="lists">
                                    <a class="icon popup-modal cart-loading" href="javascript:void(0)"> <i
                                            class="lar la-eye"></i> </a>
                                </li>
                                <li class="lists">
                                    <a class="icon cart-loading" href="javascript:void(0)"> <i
                                            class="las la-shopping-bag"></i> </a>
                                </li>
                            </ul>
                        </div>
                        <div class="collection-contents">
                            <ul class="collection-review color-three justify-content-center margin-bottom-10">
                                <li><i class="las la-star"></i></li>
                                <li><i class="las la-star"></i></li>
                                <li><i class="las la-star"></i></li>
                                <li><i class="las la-star"></i></li>
                                <li><i class="las la-star"></i></li>
                            </ul>
                            <h2 class="collection-title color-three ff-playfair">
                                <a href="javascript:void(0)"> {{Str::}} </a>
                            </h2>
                            <div class="collection-bottom margin-top-15">
                                <a class="collection-cart fs-20 fw-500 ff-roboto color-three" href="javascript:void(0)">
                                    Add to Cart </a>
                                <h3 class="common-price-title color-three fs-20 ff-roboto"> $20.00 </h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Collection area end -->
