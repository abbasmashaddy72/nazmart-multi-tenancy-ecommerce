{{--<header class="header-style-01">--}}
{{--    <!-- Menu area Starts -->--}}
{{--    <nav class="navbar navbar-area navbar-expand-lg">--}}
{{--        <div class="container container-one nav-container">--}}
{{--            <div class="responsive-mobile-menu">--}}
{{--                <div class="logo-wrapper">--}}
{{--                    @if(\App\Facades\GlobalLanguage::user_lang_dir() == 'rtl')--}}
{{--                        <a href="{{url('/')}}" class="logo">--}}
{{--                            {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}--}}
{{--                        </a>--}}
{{--                    @else--}}
{{--                        <a href="{{url('/')}}" class="logo">--}}
{{--                            @if(!empty(get_static_option('site_white_logo')))--}}
{{--                                {!! render_image_markup_by_attachment_id(get_static_option('site_white_logo')) !!}--}}
{{--                            @else--}}
{{--                                <h2 class="site-title">{{filter_static_option_value('site_'.$user_select_lang_slug.'_title',$global_static_field_data)}}</h2>--}}
{{--                            @endif--}}
{{--                        </a>--}}
{{--                    @endif--}}
{{--                </div>--}}

{{--                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#multi_tenancy_menu">--}}
{{--                    <span class="navbar-toggler-icon"></span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="collapse navbar-collapse" id="multi_tenancy_menu">--}}
{{--                <ul class="navbar-nav">--}}
{{--                    {!! render_frontend_menu($primary_menu) !!}--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--            <div class="navbar-right-content show-nav-content">--}}
{{--                <div class="single-right-content">--}}
{{--                    <div class="search-suggestions-icon-wrapper">--}}
{{--                        <div class="search-click-icon">--}}
{{--                            <i class="las la-search"></i>--}}
{{--                        </div>--}}
{{--                        <div class="search-suggetions-show">--}}
{{--                            <div class="navbar-input searchbar-suggetions">--}}
{{--                                <form action="">--}}
{{--                                    <div class="search-open-form">--}}
{{--                                        <input autocomplete="off" class="form--control" id="search_form_input" type="text" placeholder="{{__('Search here....')}}">--}}
{{--                                        <button type="submit"> <i class="las la-search"></i> </button>--}}
{{--                                        <span class="suggetions-icon-close"> <i class="las la-times"></i> </span>--}}
{{--                                    </div>--}}
{{--                                    <div class="search-suggestions" id="search_suggestions_wrap">--}}
{{--                                        <div class="search-suggestions-inner">--}}
{{--                                            <h6 class="search-suggestions-title">{{__('Product Suggestions')}}</h6>--}}
{{--                                            <ul class="product-suggestion-list mt-4">--}}

{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="navbar-right-flex">--}}
{{--                        <div class="track-icon-list">--}}
{{--                            <div class="single-icon cart-shopping">--}}
{{--                                <a class="icon" href="{{route('tenant.shop.compare.product.page')}}"> <i class="las la-sync"></i> </a>--}}
{{--                            </div>--}}

{{--                            <div class="single-icon cart-shopping">--}}
{{--                                <a class="icon" href="javascript:void(0)"> <i class="lar la-heart"></i> </a>--}}
{{--                                <a href="javascript:void(0)" class="icon-notification"> {{ \Gloudemans\Shoppingcart\Facades\Cart::instance("wishlist")->content()->count() }}  </a>--}}
{{--                                <div class="addto-cart-contents">--}}
{{--                                    <div class="single-addto-cart-wrappers">--}}
{{--                                        @php--}}
{{--                                            $cart = \Gloudemans\Shoppingcart\Facades\Cart::instance("wishlist")->content();--}}
{{--                                            $subtotal = \Gloudemans\Shoppingcart\Facades\Cart::instance("wishlist")->subtotal();--}}
{{--                                        @endphp--}}
{{--                                        @forelse($cart as $cart_item)--}}
{{--                                            <div class="single-addto-carts">--}}
{{--                                                <div class="addto-cart-flex-contents">--}}
{{--                                                    <div class="addto-cart-thumb">--}}
{{--                                                        <a href="javascript:void(0)">--}}
{{--                                                            {!! render_image_markup_by_attachment_id($cart_item?->options?->image) !!}--}}
{{--                                                        </a>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="addto-cart-img-contents">--}}
{{--                                                        <h6 class="addto-cart-title"> <a href="javascript:void(0)"> {{Str::words($cart_item->name, 5)}} </a> </h6>--}}
{{--                                                        <span class="name-subtitle d-block">--}}
{{--                                                            @if($cart_item?->options?->color_name)--}}
{{--                                                                {{__('Color:')}} {{$cart_item?->options?->color_name}} ,--}}
{{--                                                            @endif--}}

{{--                                                            @if($cart_item?->options?->size_name)--}}
{{--                                                                {{__('Size:')}} {{$cart_item?->options?->size_name}}--}}
{{--                                                            @endif--}}

{{--                                                            @if($cart_item?->options?->attributes)--}}
{{--                                                                <br>--}}
{{--                                                                @foreach($cart_item?->options?->attributes as $key => $attribute)--}}
{{--                                                                    {{$key.':'}} {{$attribute}}{{!$loop->last ? ',' : ''}}--}}
{{--                                                                @endforeach--}}
{{--                                                            @endif--}}
{{--                                                        </span>--}}
{{--                                                        <div class="price-updates mt-2">--}}
{{--                                                            <span class="price-title fs-16 fw-500 color-heading"> {{amount_with_currency_symbol($cart_item->price)}} </span>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <span class="addto-cart-counts color-heading fw-500"> {{$cart_item->qty}} </span>--}}
{{--                                            </div>--}}
{{--                                        @empty--}}
{{--                                            <div class="single-addto-carts">--}}
{{--                                                <p class="text-center">{{__('No Item in Wishlist')}}</p>--}}
{{--                                            </div>--}}
{{--                                        @endforelse--}}
{{--                                    </div>--}}

{{--                                    @if($cart->count() != 0)--}}
{{--                                        <div class="cart-total-amount">--}}
{{--                                            <h6 class="amount-title"> {{__('Total Amount:')}} </h6>--}}
{{--                                            <span class="fs-18 fw-500 color-light"> {{site_currency_symbol().$subtotal}} </span>--}}
{{--                                        </div>--}}
{{--                                        <div class="btn-wrapper mt-3">--}}
{{--                                            <a href="{{route('tenant.shop.wishlist.page')}}" class="cart-btn cart-btn-outline radius-0 w-100"> {{__('View Wishlist')}} </a>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="single-icon cart-shopping">--}}
{{--                                <a class="icon" href="javascript:void(0)"> <i class="las la-shopping-cart"></i> </a>--}}
{{--                                <a href="javascript:void(0)" class="icon-notification"> {{\Gloudemans\Shoppingcart\Facades\Cart::instance("default")->content()->count()}} </a>--}}
{{--                                <div class="addto-cart-contents">--}}
{{--                                    <div class="single-addto-cart-wrappers">--}}
{{--                                        @php--}}
{{--                                            $cart = \Gloudemans\Shoppingcart\Facades\Cart::instance("default")->content();--}}
{{--                                            $subtotal = \Gloudemans\Shoppingcart\Facades\Cart::instance("default")->subtotal();--}}
{{--                                        @endphp--}}
{{--                                        @forelse($cart as $cart_item)--}}
{{--                                            <div class="single-addto-carts">--}}
{{--                                                <div class="addto-cart-flex-contents">--}}
{{--                                                    <div class="addto-cart-thumb">--}}
{{--                                                        <a href="javascript:void(0)">--}}
{{--                                                            {!! render_image_markup_by_attachment_id($cart_item?->options?->image) !!}--}}
{{--                                                        </a>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="addto-cart-img-contents">--}}
{{--                                                        <h6 class="addto-cart-title"> <a href="javascript:void(0)"> {{Str::words($cart_item->name, 5)}} </a> </h6>--}}

{{--                                                        <span class="name-subtitle d-block">--}}
{{--                                                            @if($cart_item?->options?->color_name)--}}
{{--                                                                {{__('Color:')}} {{$cart_item?->options?->color_name}} ,--}}
{{--                                                            @endif--}}

{{--                                                            @if($cart_item?->options?->size_name)--}}
{{--                                                                {{__('Size:')}} {{$cart_item?->options?->size_name}}--}}
{{--                                                            @endif--}}

{{--                                                            @if($cart_item?->options?->attributes)--}}
{{--                                                                <br>--}}
{{--                                                                @foreach($cart_item?->options?->attributes as $key => $attribute)--}}
{{--                                                                    {{$key.':'}} {{$attribute}}{{!$loop->last ? ',' : ''}}--}}
{{--                                                                @endforeach--}}
{{--                                                            @endif--}}
{{--                                                        </span>--}}

{{--                                                        <div class="price-updates">--}}
{{--                                                            <span class="price-title fs-16 fw-500 color-heading"> {{amount_with_currency_symbol($cart_item->price)}} </span>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <span class="addto-cart-counts color-heading fw-500"> {{$cart_item->qty}} </span>--}}
{{--                                            </div>--}}
{{--                                        @empty--}}
{{--                                            <div class="single-addto-carts">--}}
{{--                                                <p class="text-center">{{__('No Item in Cart')}}</p>--}}
{{--                                            </div>--}}
{{--                                        @endforelse--}}
{{--                                    </div>--}}

{{--                                    @if($cart->count() != 0)--}}
{{--                                        <div class="cart-total-amount">--}}
{{--                                            <h6 class="amount-title"> {{__('Total Amount:')}} </h6> <span class="fs-18 fw-500 color-light"> {{site_currency_symbol().$subtotal}} </span></div>--}}
{{--                                        <div class="btn-wrapper mt-3">--}}
{{--                                            <a href="{{route('tenant.shop.checkout')}}" class="cart-btn radius-0 w-100"> {{__('CheckOut')}} </a>--}}
{{--                                        </div>--}}
{{--                                        <div class="btn-wrapper mt-3">--}}
{{--                                            <a href="{{route('tenant.shop.cart')}}" class="cart-btn cart-btn-outline radius-0 w-100"> {{__('View Cart')}} </a>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="login-account">--}}
{{--                            <a class="accounts" href="javascript:void(0)"> <i class="las la-user"></i> </a>--}}
{{--                            <ul class="account-list-item">--}}
{{--                                @auth('web')--}}
{{--                                    <li class="list"> <a href="{{route('tenant.user.home')}}"> {{__('Dashboard')}} </a> </li>--}}
{{--                                    <li class="list"> <a href="{{route('tenant.user.logout')}}"> {{__('Log Out')}} </a> </li>--}}
{{--                                @else--}}
{{--                                    <li class="list"> <a href="{{route('tenant.user.login')}}"> {{__('Sign In')}} </a> </li>--}}
{{--                                    <li class="list"> <a href="{{route('tenant.user.register')}}"> {{__('Sign Up')}} </a> </li>--}}
{{--                                @endauth--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </nav>--}}
{{--    <!-- Menu area end -->--}}
{{--</header>--}}


<div class="topbar-area topbar-padding topbar-bottom-border">
    <div class="container custom-container-one">
        <div class="topbar-bottom-wrapper">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-7">
                    <div class="topbar-logo-wrapper d-flex align-items-center">
                        <div class="topbar-logo d-none d-lg-block">
                            <a href="{{url('/')}}" class="logo">
                                {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}
                            </a>
                        </div>
                        <div class="search-content-wrapper custom--form">
                            <form action="#">
                                <div class="search-input searchbar-suggetions">
                                    <input autocomplete="off" class="form--control" id="search_form_input" type="text"
                                           placeholder="{{__('Search Books....')}}" style="padding-left: 20px">
                                    <button type="submit"><i class="las la-search"></i></button>
                                    <div class="search-suggestions" id="search_suggestions_wrap">
                                        <div class="search-suggestions-inner">
                                            <h6 class="search-suggestions-title">{{__('Product Suggestions')}}</h6>
                                            <ul class="product-suggestion-list mt-4">

                                            </ul>
                                        </div>
                                    </div>
{{--                                    <div class="category-search">--}}
{{--                                        <select class="nice-select">--}}
{{--                                            <option value="1">All Category</option>--}}
{{--                                            <option value="2">Popular Book</option>--}}
{{--                                            <option value="3">High Price</option>--}}
{{--                                            <option value="4">Low Price</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="topbar-right-list right-flex d-flex flex-wrap align-items-center">
                        <ul class="topbar-list d-flex flex-wrap">
                            @php
                                $topbar_menu_id = get_static_option('topbar_menu') ?? $primary_menu;
                            @endphp
                            {!! render_frontend_menu($topbar_menu_id) !!}
{{--                            <li class="topbar-list-item color-light"><a href="javascript:void(0)"--}}
{{--                                                                        class="topbar-list-item-link"> Best Seller--}}
{{--                                    Books </a></li>--}}
{{--                            <li class="topbar-list-item color-light"><a href="javascript:void(0)"--}}
{{--                                                                        class="topbar-list-item-link"> Special--}}
{{--                                    Offer </a></li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Menu area Starts -->
<nav class="navbar navbar-area navbar-padding navbar-expand-lg">
    <div class="container custom-container-one nav-container">
        <div class="responsive-mobile-menu d-lg-none">
            <div class="logo-wrapper">
                <a href="{{url('/')}}" class="logo">
                    {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}
                </a>
            </div>
            <a href="javascript:void(0)" class="click-nav-right-icon">
                <i class="las la-ellipsis-v"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#book_point_menu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="book_point_menu">
            <ul class="navbar-nav">
                {!! render_frontend_menu($primary_menu) !!}
            </ul>
        </div>
        <div class="navbar-right-content show-nav-content">
            <div class="single-right-content">
                <div class="navbar-right-flex">
                    <div class="track-icon-list">
                        <div class="single-icon">
                            <a class="icon" href="{{route('tenant.shop.wishlist.page')}}"> <i class="lar la-heart"></i> </a>
                            <a href="{{route('tenant.shop.wishlist.page')}}" class="icon-notification"> {{ \Gloudemans\Shoppingcart\Facades\Cart::instance("wishlist")->content()->count() }} </a>
                        </div>
                        <div class="single-icon cart-shopping">
                            <a class="icon" href="javascript:void(0)"> <i class="las la-shopping-cart"></i> </a>
                            <a href="javascript:void(0)"
                               class="icon-notification"> {{\Gloudemans\Shoppingcart\Facades\Cart::instance("default")->content()->count()}} </a>
                            <div class="addto-cart-contents">
                                <div class="single-addto-cart-wrappers">
                                    @php
                                        $cart = \Gloudemans\Shoppingcart\Facades\Cart::instance("default")->content();
                                        $subtotal = \Gloudemans\Shoppingcart\Facades\Cart::instance("default")->subtotal();
                                    @endphp

                                    @forelse($cart as $cart_item)
                                        <div class="single-addto-carts">
                                            <div class="addto-cart-flex-contents">
                                                <div class="addto-cart-thumb">
                                                    <a href="javascript:void(0)">
                                                        {!! render_image_markup_by_attachment_id($cart_item?->options?->image) !!}
                                                    </a>
                                                </div>
                                                <div class="addto-cart-img-contents">
                                                    <h6 class="addto-cart-title">
                                                        <a href="javascript:void(0)">{{Str::words($cart_item->name, 5)}}</a>
                                                    </h6>

                                                    <span class="name-subtitle d-block">
                                                            @if($cart_item?->options?->color_name)
                                                            {{__('Color:')}} {{$cart_item?->options?->color_name}} ,
                                                        @endif

                                                        @if($cart_item?->options?->size_name)
                                                            {{__('Size:')}} {{$cart_item?->options?->size_name}}
                                                        @endif

                                                        @if($cart_item?->options?->attributes)
                                                            <br>
                                                            @foreach($cart_item?->options?->attributes as $key => $attribute)
                                                                {{$key.':'}} {{$attribute}}{{!$loop->last ? ',' : ''}}
                                                            @endforeach
                                                        @endif
                                                    </span>

                                                    <div class="price-updates mt-2">
                                                        <span
                                                            class="price-title fs-16 fw-500 color-heading"> {{float_amount_with_currency_symbol($cart_item->price)}} </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span
                                                class="addto-cart-counts color-heading fw-500"> {{$cart_item->qty}} </span>
                                            <a href="javascript:void(0)" class="close-cart">
                                                {{--  <span class="icon-close color-heading"> <i--}}
                                                {{--  class="las la-times"></i> </span>--}}
                                            </a>
                                        </div>
                                    @empty
                                        <div class="single-addto-carts">
                                            <p class="text-center">{{__('No Item in Cart')}}</p>
                                        </div>
                                    @endforelse
                                </div>

                                @if($cart->count() != 0)
                                    <div class="cart-total-amount">
                                        <h6 class="amount-title"> Total Amount: </h6> <span
                                            class="fs-18 fw-500 color-light"> {{float_amount_with_currency_symbol($subtotal)}} </span>
                                    </div>
                                    <div class="btn-wrapper mt-3">
                                        <a href="{{route('tenant.shop.checkout')}}"
                                           class="cart-btn radius-0 w-100"> {{__('CheckOut')}} </a>
                                    </div>
                                    <div class="btn-wrapper mt-3">
                                        <a href="{{route('tenant.shop.cart')}}"
                                           class="cart-btn cart-btn-outline radius-0 w-100"> {{__('View Cart')}} </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="login-account">
                        <a class="accounts" href="javascript:void(0)"> <i class="las la-user"></i> </a>
                        <ul class="account-list-item">
                            @auth('web')
                                <li class="list"><a
                                        href="{{route('tenant.user.home')}}"> {{__('Dashboard')}} </a>
                                </li>
                                <li class="list"><a href="{{route('tenant.user.logout')}}"> {{__('Log Out')}} </a></li>
                            @else
                                <li class="list"><a href="{{route('tenant.user.login')}}"> {{__('Sign In')}} </a></li>
                                <li class="list"><a href="{{route('tenant.user.register')}}"> {{__('Sign Up')}} </a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Menu area end -->
