<div class="block-quickview primary_block details-product">
    <div class="row">
        <div class="product-left-column product-images col-xs-12 col-sm-4 col-md-4 col-lg-5 col-xl-4">
            <div class="image-block large-image col_large_default">
                <span class="view_full_size">
                <a class="img-product" title="Ảnh sản phẩm" href="javascript:;">
                <img src="{{ $product->image->path }}" id="product-featured-image-quickview" class="img-responsive product-featured-image-quickview" alt="quickview">
                </a>
                </span>
                <div class="loading-imgquickview" style="display:none;"></div>
            </div>
            <div class="more-view-wrapper clearfix d-none">
                <div class="thumbs_quickview owl_nav_custome1 swiper-container" id="thumbs_list_quickview">
                <ul class="product-photo-thumbs quickview-more-views-owlslider not-thuongdq swiper-wrapper" id="thumblist_quickview"></ul>
                <div class="swiper-button-prev">
                </div>
                <div class="swiper-button-next">
                </div>
                </div>
            </div>
        </div>
        <div class="product-center-column product-info product-item col-xs-12 col-sm-6 col-md-8 col-lg-7 col-xl-8 details-pro style_product style_border" id="product-31513333">
            <div class="head-qv group-status">
                <h3 class="qwp-name title-product"><a class="text2line" href="{{ route('front.show-product-detail', $product->slug) }}" title="{{ $product->name }}">{{ $product->name }}</a></h3>
                <div class="onireviewapp-loop">
                    <div class="onireviewapp-loopitem" data-value="4.8" data-total="5">
                        <div class="onirvapp--shape-xs">
                            <div class="onirvapp--shape-container">
                                <div class="onirvapp--shape-background"></div>
                                <div class="onirvapp--shape-solid" style="width: {{ $product->product_rates->count() > 0 ? round($product->product_rates->sum('rating') / $product->product_rates->count()) / 5 * 100 : 0 }}%"></div>
                            </div>
                        </div><span class="onireviewapp-loopitem-title">({{$product->product_rates->count()}} đánh giá)</span>
                    </div>
                </div>
                <div class="vend-qv group-status">
                <div class="left_vend">
                    <div class="first_status ">Thương hiệu:
                        <span class="vendor_ status_name">Sudes Dino</span>
                    </div>
                    <span class="line_tt">|</span>
                    <div class="top_sku first_status">Mã sản phẩm:
                        <span class="sku_ status_name"><span>Đang cập nhật</span></span>
                    </div>
                </div>
                </div>
            </div>
            <div style="font-size: 18px">
                <span><i class="fa fa-tag" style="color: #f69326"></i><i style="font-size: 16px">Thưởng hoa hồng lên đến</i> <span style="color: #0974ba; font-weight:bold;">{{ formatCurrency($product->revenue_price) }}₫</span> <i style="font-size: 16px">khi mua sản phẩm</i></span>
            </div>
            <div class="quickview-info">
                <span class="prices price-box">
                <span class="price product-price sale-price">{{ formatCurrency($product->price) }}₫</span>
                <del class="old-price">{{ formatCurrency($product->price) }}₫</del>
                </span>
            </div>

            <div class="product-description product-summary">
                <div class="rte">{!! $product->intro !!}</div>
            </div>
            <form class="quick_option variants form-ajaxtocart form-product" id="product-actions-31513333">
                <span class="price-product-detail d-none" style="opacity: 0;">
                <span class=""></span>
                </span>
                <div class="form_product_content">
                <div class="count_btn_style quantity_wanted_p">
                    @if (!$product->type)
                    <div class=" soluong1 clearfix">
                        <div class="input_number_product">
                            <a class="btn_num num_1 button button_qty" onclick="var result = document.getElementById('quantity-detail'); var qtyqv = result.value; if( !isNaN( qtyqv ) &amp;&amp; qtyqv > 1 ) result.value--;return false;">-</a>
                            <input type="text" id="quantity-detail" name="quantity" ng-model="quantity_quickview" maxlength="2" class="form-control prd_quantity" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" onchange="if(this.value == 0)this.value=1;">
                            <a class="btn_num num_2 button button_qty" onclick="var result = document.getElementById('quantity-detail'); var qtyqv = result.value; if( !isNaN( qtyqv )) result.value++;return false;">+</a>
                        </div>
                    </div>
                    @endif
                    <div class="button_actions clearfix">
                        @if (!$product->type)
                        <button type="button" class="btn_cool btn btn_base fix_add_to_cart ajax_addtocart btn_add_cart btn-cart" ng-click="addToCart({{ $product->id }}, quantity_quickview)">
                        <span class="btn-content text_1">Thêm vào giỏ hàng</span>
                        </button>
                        @else
                        <button type="button" class="btn_cool btn btn_base fix_add_to_cart ajax_addtocart btn_add_cart btn-cart" onclick="window.open('{{ $product->type ? ($product->short_link ?? $product->aff_link) : route('front.show-product-detail', $product->slug) }}', '_blank')">
                        <span class="btn-content text_1">Mua hàng</span>
                        </button>
                        @endif
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <a title="Close" class="quickview-close close-window" href="javascript:;">
    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-times fa-w-10">
        <path fill="currentColor" d="M207.6 256l107.72-107.72c6.23-6.23 6.23-16.34 0-22.58l-25.03-25.03c-6.23-6.23-16.34-6.23-22.58 0L160 208.4 52.28 100.68c-6.23-6.23-16.34-6.23-22.58 0L4.68 125.7c-6.23 6.23-6.23 16.34 0 22.58L112.4 256 4.68 363.72c-6.23 6.23-6.23 16.34 0 22.58l25.03 25.03c6.23 6.23 16.34 6.23 22.58 0L160 303.6l107.72 107.72c6.23 6.23 16.34 6.23 22.58 0l25.03-25.03c6.23-6.23 6.23-16.34 0-22.58L207.6 256z" class=""></path>
    </svg>
    </a>
</div>
