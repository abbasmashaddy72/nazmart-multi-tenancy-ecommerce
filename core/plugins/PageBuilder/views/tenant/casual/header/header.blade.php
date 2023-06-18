@php
    $primary_image = get_attachment_image_by_id($data['primary_image']);
    $primary_image = !empty($primary_image) ? $primary_image['img_url'] : '';

    $particle_image_one = get_attachment_image_by_id($data['particle_image_one']);
    $particle_image_one = !empty($particle_image_one) ? $particle_image_one['img_url'] : theme_assets('img/shape1.png');

    $particle_image_two = get_attachment_image_by_id($data['particle_image_two']);
    $particle_image_two = !empty($particle_image_two) ? $particle_image_two['img_url'] : theme_assets('img/shape2.png');

    $particle_image_three =  get_attachment_image_by_id($data['particle_image_three']);
    $particle_image_three = !empty($particle_image_three) ? $particle_image_three['img_url'] : theme_assets('img/shape3.png');

    $particle_image_four = get_attachment_image_by_id($data['particle_image_four']);
    $particle_image_four = !empty($particle_image_four) ? $particle_image_four['img_url'] : theme_assets('img/shape4.png');
@endphp

<!-- Banner area Starts -->
{{--@if(!empty($data['background_color']))--}}
{{--    <style>--}}
{{--        .banner-five .banner-five-shapes::before{--}}
{{--            background: {{$data['background_color']}}--}}
{{--    }--}}
{{--    </style>--}}
{{--@endif--}}

<!-- Banner area end -->

<div class="banner-area banner-two position-relative">
    <div class="container-two">
        <div class="banner-contents-wrappers bg-item-four radius-30">
            <div class="banner-shapes">
                <img src="{{$particle_image_one}}" alt="">
                <img src="{{$particle_image_two}}" alt="">
                <img src="{{$particle_image_three}}" alt="">
                <img src="{{$particle_image_four}}" alt="">
            </div>
            <div class="banner-contents">
                <span class="banner-store color-heading fs-26"> {{$data['pre_title']}} </span>
                <h2 class="title ff-jost fw-600"> {{$data['title']}} </h2>
                @if(!empty($data['button_text']) && !empty($data['button_url']))
                    <div class="comingsoon-btn margin-top-40">
                        <a href="{{$data['button_url']}}" class="comingsoon-order brows-category"> {{$data['button_text']}} </a>
                    </div>
                @endif
                <div class="banner-left-products">
                    <div class="banner-single-products bg-white radius-20 margin-top-30">
                        <div class="banner-product-thumb radius-10">
                            <a href="javascript:void(0)"> <img class="lazyloads" data-src="assets/img/banner/bl1.jpg" alt=""> </a>
                        </div>
                        <div class="banner-product-flex">
                            <div class="single-flex-banner">
                                <h6 class="banner_title ff-jost"> <a href="javascript:void(0)"> Women Tops </a> </h6>
                                <span class="common-price-title color-one fs-18 fw-700"> $20.00 </span>
                            </div>
                            <div class="banner-iconlist">
                                <a href="javascript:void(0)" class="banner-icon popup-modal"> <i class="lar la-eye"></i> </a>
                            </div>
                        </div>
                    </div>
                    <div class="banner-single-products bg-white radius-20 margin-top-30">
                        <div class="banner-product-thumb radius-10">
                            <a href="javascript:void(0)"> <img class="lazyloads" data-src="assets/img/banner/bl2.jpg" alt=""> </a>
                        </div>
                        <div class="banner-product-flex">
                            <div class="single-flex-banner">
                                <h6 class="banner_title ff-jost"> <a href="javascript:void(0)"> Women T-Shirt </a> </h6>
                                <span class="common-price-title color-one fs-18 fw-700"> $30.00 </span>
                            </div>
                            <div class="banner-iconlist">
                                <a href="javascript:void(0)" class="banner-icon popup-modal"> <i class="lar la-eye"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner-socials">
                <ul class="social-lists">
                    <li><a href="javascript:void(0)"> Facebook </a></li>
                    <li><a href="javascript:void(0)"> Instagram </a></li>
                    <li><a href="javascript:void(0)"> Youtube </a></li>
                </ul>
            </div>
            <div class="banner-right-contents-all">
                <div class="banner-images-right wow fadeInUp" data-wow-delay=".3s">
                    <img class="lazyloads" src="{{$primary_image}}" alt="">
                </div>
                <div class="banner-image-shapes">
                </div>
            </div>
        </div>
    </div>
</div>
