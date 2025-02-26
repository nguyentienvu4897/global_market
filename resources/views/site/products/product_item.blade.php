<form class="variants product-action">
    {{-- <a class="image_thumb scale_hover" href="{{ $product->type ? ($product->short_link ?? $product->aff_link) : route('front.show-product-detail', $product->slug) }}" --}}
    <a class="image_thumb scale_hover" href="{{ route('front.show-product-detail', $product->slug) }}"
        title="{{ $product->name }}">
        <img width="480" height="480" class="lazyload image1"
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
            data-src="{{ $product->image->path }}" alt="{{ $product->name }}">
    </a>
    {{-- <div class="group_action">
        <a title="Xem nhanh" href='javascript:void(0)' data-handle="{{ $product->id }}" style="font-size: 15px;"
            class="btn-anima hidden-xs xem_nhanh btn-circle btn-views btn_view btn right-to quick-view"
            ng-click="showQuickView({{ $product->id }})">
            <img width="24" height="24" src="/site/images/view.svg?1729657650563" alt="Xem nhanh" /> Xem
            nhanh
        </a>
        <a href="{{ $product->type ? ($product->short_link ?? $product->aff_link) : 'javascript:void(0)' }}" class="btn-anima hidden-xs btn-buy btn-cart btn-left btn btn-views left-to" style="font-size: 15px;"
            title="Mua ngay" ng-click="addToCart({{ $product->id }})">
            <img width="24" height="24" src="/site/images/cart_new.svg?1729657650563" alt="Mua ngay" /> Mua
            ngay
        </a>
    </div> --}}
    @if ($product->base_price > 0)
    <div class="sale-label"><span class="smart">-
            {{ round((($product->base_price - $product->price) / $product->base_price) * 100) }}% </span></div>
    @endif
    {{-- <a href="javascript:void(0)" class="setWishlist" data-wish="{{ $product->id }}" tabindex="0"
        title="Thêm vào yêu thích" ng-click="addToWishlist({{ $product->id }})">
        <img width="24" height="24" src="/site/images/heart.png?1729657650563" alt="Thêm vào yêu thích" />
    </a> --}}
</form>
<div class="product-info">
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
    <h3 class="product-name"><a href="{{ route('front.show-product-detail', $product->slug) }}"
            title="{{ $product->name }}">{{ $product->name }}</a></h3>
    <div class="price-box">
        <span class="price">{{ formatCurrency($product->price) }}₫</span>
        @if ($product->base_price > 0)
        <span class="compare-price">{{ formatCurrency($product->base_price) }}₫</span>
        @endif
    </div>
    <div style="font-size: 16px">
        <span><i class="fa fa-tag" style="color: #f69326"></i><i style="font-size: 14px">Thưởng hoa hồng</i> <span style="color: #0974ba">{{ formatCurrency($product->revenue_price) }}₫</span></span>
    </div>
</div>

