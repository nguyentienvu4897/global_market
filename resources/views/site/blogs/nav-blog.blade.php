<div class="side-right-stick">
    <div class="blog_noibat">
        <h2 class="h2_sidebar_blog">
            <a href="javascript:void(0)" title="Tin tức nổi bật">Tin tức nổi bật</a>
        </h2>
        <div class="blog_content">
            @foreach($newBlogs as $item)
            <div class="item clearfix">
                <div class="post-thumb">
                    <a class="image-blog scale_hover"
                        href="{{ route('front.detail-blog', $item->slug) }}"
                        title="{{ $item->name }}">
                        <img width="600" height="380" class="img_blog lazyload"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                            data-src="{{ $item->image->path }}"
                            alt="{{ $item->name }}">
                    </a>
                </div>
                <div class="contentright">
                    <h3><a title="{{ $item->name }}"
                            href="{{ route('front.detail-blog', $item->slug) }}">{{ $item->name }}</a></h3>
                    <p class="time-post">
                        <span>{{ date('d/m/Y', strtotime($item->created_at)) }}</span>
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="blog_tags">
        <div class="title-head">
            Tags
        </div>
        <ul class="list-tags">
            <li class="item_tag">
                <a href="/tin-tuc/an-vat" title="Ăn vặt">Ăn vặt</a>
            </li>
            <li class="item_tag">
                <a href="/tin-tuc/banh-trang" title="Bánh tráng">Bánh tráng</a>
            </li>
            <li class="item_tag">
                <a href="/tin-tuc/kho-ga" title="Khô gà">Khô gà</a>
            </li>
            <li class="item_tag">
                <a href="/tin-tuc/rong-bien" title="Rong biển">Rong biển</a>
            </li>
        </ul>
    </div>
</div>
