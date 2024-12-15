<div class="item-suggest">
    <span class="title_no_mis">SẢN PHẨM ĐỀ XUẤT</span>
    <div class="search-list">
        @foreach ($products as $product)
            <div class="product-smart">
                <a class="image_thumb" href="{{ route('front.show-product-detail', $product->slug) }}"
                    title="{{$product->name}}">
                    <img width="480" height="480" class="image1"
                        src="{{$product->image->path}}"
                        alt="{{$product->name}}" loading="lazy">
                </a>
                <div class="product-info">
                    <a class="product-name" href="{{ route('front.show-product-detail', $product->slug) }}"
                        title="{{$product->name}}">{{$product->name}}</a>
                    <span class="price">{{ formatCurrency($product->price) }}₫</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="list-search"></div>
