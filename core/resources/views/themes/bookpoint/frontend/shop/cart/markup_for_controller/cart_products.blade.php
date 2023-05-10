@foreach($cart_data as $key => $data)
    <tr class="table-cart-row" data-product-id="{{$key}}" data-varinat-id="{{$data->variant_id}}">
        <td class="ff-jost" data-label="Product">
            <div class="product-name-table">
                <div class="thumbs bg-image radius-10"
                    {!! render_background_image_markup_by_attachment_id($data?->options?->image) !!}></div>
                <div class="carts-contents">
                    @php
                        if ($data->options->type == \App\Enums\ProductTypeEnum::DIGITAL)
                        {
                            $slug = \Modules\DigitalProduct\Entities\DigitalProduct::select('id', 'slug')->find($data->id)?->slug;
                            $product_details_route = route('tenant.digital.shop.product.details', $slug);
                            $product_type = 'Digital';
                        } else {
                            $slug = \Modules\Product\Entities\Product::select('id', 'slug')->find($data->id)?->slug;
                            $product_details_route = route('tenant.shop.product.details', $slug);
                            $product_type = 'Normal';
                        }
                    @endphp

                    <a href="{{$product_details_route}}" class="name-title"> {{$data->name}} </a>
                    <p class="badge bg-primary text-white text-small" style="vertical-align: text-top">{{$product_type}}</p>

                    <span class="name-subtitle d-block mt-2">
                        @if($data?->options?->color_name)
                            {{__('Color:')}} {{$data?->options?->color_name}} ,
                        @endif

                        @if($data?->options?->size_name)
                            {{__('Size:')}} {{$data?->options?->size_name}}
                        @endif

                        @if($data?->options?->attributes)
                            <br>
                            @foreach($data?->options?->attributes as $key => $attribute)
                                {{$key.':'}} {{$attribute}}{{!$loop->last ? ',' : ''}}
                            @endforeach
                        @endif
                    </span>
                </div>
            </div>
        </td>
        <td class="price-td" data-label="Price"> {{float_amount_with_currency_symbol($data->price)}} </td>
        <td class="ff-jost" data-label="Quantity">
            @if($data->options->type == \App\Enums\ProductTypeEnum::PHYSICAL)
                <div class="product-quantity">
                      <span class="substract">
                            <i class="las la-minus"></i>
                      </span>
                    <input class="quantity-input" type="number" value="{{$data->qty}}">
                    <span class="plus">
                          <i class="las la-plus"></i>
                    </span>
                </div>
            @endif
        </td>
        @php
            $subtotal = $data->price * $data->qty;
        @endphp
        <td class="price-td" data-label="Subtotal"> {{float_amount_with_currency_symbol($subtotal)}} </td>
        <td class="ff-jost" data-label="Close" data-product_hash_id="{{$data->rowId}}">
            <div class="close-table-cart">
                <i class="las la-times"></i>
            </div>
        </td>
    </tr>
@endforeach
