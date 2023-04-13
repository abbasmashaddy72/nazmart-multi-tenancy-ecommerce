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
                                           placeholder="Search Books....">
                                    <button type="submit"><i class="las la-search"></i></button>
                                    <div class="search-suggestions" id="search_suggestions_wrap">
                                        <div class="search-suggestions-inner">
                                            <h6 class="search-suggestions-title">Product Suggestions</h6>
                                            <ul class="product-suggestion-list mt-4">
                                                <li class="product-suggestion-list-item">
                                                    <a href="javascript:void(0)" class="product-suggestion-list-link">
                                                        <div class="product-image"><img src="assets/img/shop/shop1.jpg"
                                                                                        alt="img"></div>
                                                        <div class="product-info">
                                                            <div class="product-info-top">
                                                                <h6 class="product-name"> Apple Original Airpod
                                                                    Collection for most popular and best price item in
                                                                    market </h6>
                                                            </div>
                                                            <div class="product-price mt-2">
                                                                <div class="price-update-through">
                                                                    <span class="flash-price fw-500"> $330.00 </span>
                                                                    <span class="flash-old-prices"> $300.00 </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="product-suggestion-list-item">
                                                    <a href="javascript:void(0)" class="product-suggestion-list-link">
                                                        <div class="product-image"><img src="assets/img/shop/shop2.jpg"
                                                                                        alt="img"></div>
                                                        <div class="product-info">
                                                            <div class="product-info-top">
                                                                <h6 class="product-name"> Apple Original Airpod
                                                                    Collection </h6>
                                                            </div>
                                                            <div class="product-price mt-2">
                                                                <span
                                                                    class="main-price fw-500 color-light">$269.00</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="product-suggestion-list-item">
                                                    <a href="javascript:void(0)" class="product-suggestion-list-link">
                                                        <div class="product-image"><img src="assets/img/shop/shop3.jpg"
                                                                                        alt="img"></div>
                                                        <div class="product-info">
                                                            <div class="product-info-top">
                                                                <h6 class="product-name"> Apple Original Airpod
                                                                    Collection </h6>
                                                            </div>
                                                            <div class="product-price mt-2">
                                                                <span
                                                                    class="main-price fw-500 color-light">$499.00</span>
                                                                <span class="stock-out"> Stock Out </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="product-suggestion-list-item">
                                                    <a href="javascript:void(0)" class="product-suggestion-list-link">
                                                        <div class="product-image"><img src="assets/img/shop/shop4.jpg"
                                                                                        alt="img"></div>
                                                        <div class="product-info">
                                                            <div class="product-info-top">
                                                                <h6 class="product-name"> Apple Original Airpod
                                                                    Collection </h6>
                                                            </div>
                                                            <div class="product-price mt-2">
                                                                <span
                                                                    class="main-price fw-500 color-light">$499.00</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="product-suggestion-list-item">
                                                    <a href="javascript:void(0)" class="product-suggestion-list-link">
                                                        <div class="product-image"><img src="assets/img/shop/shop5.jpg"
                                                                                        alt="img"></div>
                                                        <div class="product-info">
                                                            <div class="product-info-top">
                                                                <h6 class="product-name"> Apple Original Airpod
                                                                    Collection </h6>
                                                            </div>
                                                            <div class="product-price mt-2">
                                                                <span
                                                                    class="main-price fw-500 color-light">$499.00</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="category-search">
                                        <select class="nice-select">
                                            <option value="1">All Category</option>
                                            <option value="2">Popular Book</option>
                                            <option value="3">High Price</option>
                                            <option value="4">Low Price</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="topbar-right-list right-flex d-flex flex-wrap align-items-center">
                        <ul class="topbar-list d-flex flex-wrap">
                            <li class="topbar-list-item color-light"><a href="javascript:void(0)"
                                                                        class="topbar-list-item-link"> Best Seller
                                    Books </a></li>
                            <li class="topbar-list-item color-light"><a href="javascript:void(0)"
                                                                        class="topbar-list-item-link"> Special
                                    Offer </a></li>
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
                <a href="index.html" class="logo">
                    <img src="assets/img/logo.png" alt="">
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
                <li class="menu-item-has-children current-menu-item">
                    <a href="javascript:void(0)">Home</a>
                    <ul class="sub-menu">
                        <li><a href="index.html">Home One</a></li>
                        <li><a href="02_index.html"> Home Two </a></li>
                    </ul>
                </li>
                <li><a href="about.html"> About </a></li>
                <li><a href="book_filter.html"> Book Filter </a></li>
                <li><a href="author.html"> Author </a></li>
                <li class="menu-item-has-children current-menu-item">
                    <a href="javascript:void(0)">Pages</a>
                    <ul class="sub-menu">
                        <li><a href="book_details.html"> Book Details </a></li>
                        <li><a href="cart.html"> Cart Page </a></li>
                        <li><a href="checkout.html"> Checkout Page </a></li>
                        <li><a href="book_order.html"> Book Order </a></li>
                        <li><a href="mission.html"> Mission </a></li>
                        <li><a href="wishlist.html"> Wishlist </a></li>
                        <li><a href="purchase_success.html"> Purchase Success </a></li>
                        <li><a href="02_cart.html"> Cart Blank </a></li>
                        <li><a href="404.html"> 404 Page </a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children current-menu-item">
                    <a href="javascript:void(0)">Blog</a>
                    <ul class="sub-menu">
                        <li><a href="blog.html"> Blog </a></li>
                        <li><a href="blog_details.html"> Blog Details </a></li>
                    </ul>
                </li>
                <li><a href="contact.html"> Contact </a></li>
            </ul>
        </div>
        <div class="navbar-right-content show-nav-content">
            <div class="single-right-content">
                <div class="navbar-right-flex">
                    <div class="track-icon-list">
                        <div class="single-icon">
                            <a class="icon" href="javascript:void(0)"> <i class="lar la-heart"></i> </a>
                            <a href="javascript:void(0)" class="icon-notification"> 0 </a>
                        </div>
                        <div class="single-icon cart-shopping">
                            <a class="icon" href="javascript:void(0)"> <i class="las la-shopping-cart"></i> </a>
                            <a href="javascript:void(0)" class="icon-notification"> 2 </a>
                            <div class="addto-cart-contents">
                                <div class="single-addto-cart-wrappers">
                                    <div class="single-addto-carts">
                                        <div class="addto-cart-flex-contents">
                                            <div class="addto-cart-thumb">
                                                <a href="javascript:void(0)"> <img
                                                        src="assets/img/single-page/cart1.jpg" alt="img"> </a>
                                            </div>
                                            <div class="addto-cart-img-contents">
                                                <h6 class="addto-cart-title"><a href="javascript:void(0)">Across The
                                                        Sky</a></h6>
                                                <div class="price-updates mt-2">
                                                    <span class="price-title fs-16 fw-500 color-heading"> $50.00 </span>
                                                    <span class="old-price"> $60.00 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="addto-cart-counts color-heading fw-500"> 1 </span>
                                        <a href="javascript:void(0)" class="close-cart">
                                            <span class="icon-close color-heading"> <i class="las la-times"></i> </span>
                                        </a>
                                    </div>
                                    <div class="single-addto-carts">
                                        <div class="addto-cart-flex-contents">
                                            <div class="addto-cart-thumb">
                                                <a href="javascript:void(0)"> <img
                                                        src="assets/img/single-page/cart2.jpg" alt="img"> </a>
                                            </div>
                                            <div class="addto-cart-img-contents">
                                                <h6 class="addto-cart-title"><a href="javascript:void(0)">Left
                                                        Behind</a></h6>
                                                <div class="price-updates mt-2">
                                                    <span class="price-title fs-16 fw-500 color-heading"> $40.00 </span>
                                                    <span class="old-price"> $50.00 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="addto-cart-counts color-heading fw-500"> 1 </span>
                                        <a href="javascript:void(0)" class="close-cart">
                                            <span class="icon-close color-heading"> <i class="las la-times"></i> </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="cart-total-amount">
                                    <h6 class="amount-title"> Total Amount: </h6> <span
                                        class="fs-18 fw-500 color-light"> $90.00 </span></div>
                                <div class="btn-wrapper mt-3">
                                    <a href="checkout.html" class="cart-btn radius-0 w-100"> CheckOut </a>
                                </div>
                                <div class="btn-wrapper mt-3">
                                    <a href="cart.html" class="cart-btn cart-btn-outline radius-0 w-100"> View Cart </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="login-account">
                        <a class="accounts" href="javascript:void(0)"> <i class="las la-user"></i> </a>
                        <ul class="account-list-item">
                            <li class="list"><a href="signin.html"> Sign In </a></li>
                            <li class="list"><a href="signup.html"> Sign Up </a></li>
                            <li class="list"><a href="javascript:void(0)"> Log Out </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Menu area end -->
