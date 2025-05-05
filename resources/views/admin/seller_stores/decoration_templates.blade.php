<!-- Templates -->
<script type="text/ng-template" id="templates/banner.html">
    <div class="banner-preview">
        <div class="row">
            <div class="col-md-4">
                <div class="position-relative">
                    <img ng-src="<% block.data.image %>" alt="" style="opacity: 0.5; border-radius: 5px;">
                    <div class="position-absolute">
                        <div class="logo-container">
                            <img ng-src="<% block.data.logo %>" alt="" class="img-fluid img-logo" width="40" height="40">
                        </div>
                        <div class="shop-name text-white">
                            <div><% object.shop_name %></div>
                            <div style="font-size: 0.4rem;">Online 5 phút trước</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 class-info">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <i style="width: 15px; color: #8f8e8e;" class="fa fa-shopping-cart"></i>
                    Sản phẩm: <span style="color: #ee4d2d;">100</span>
                </div>
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <i style="width: 15px; color: #8f8e8e;" class="fa fa-user"></i> Người theo dõi: <span style="color: #ee4d2d;">100</span>
                </div>
            </div>
            <div class="col-md-4 class-info">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <i style="width: 15px; color: #8f8e8e;" class="fa fa-star"></i> Đánh giá: <span style="color: #ee4d2d;">4.5</span>
                </div>
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <i style="width: 15px; color: #8f8e8e;" class="fa fa-clock"></i> Thời gian tham gia: <span style="color: #ee4d2d;">100 ngày</span>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex align-items-center" style="gap: 12px;">
                    <div style="border-bottom: 2px solid #ee4d2d;">Shop</div>
                    <div>Tất cả sản phẩm</div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .banner-preview {
            padding-top: 1%;
            padding-bottom: 1%;
        }
        .banner-preview .position-relative {
            background-color: rgba(0, 0, 0);
            border-radius: 5px;
        }
        .banner-preview .position-absolute {
            top: 5%;
            left: 5%;
            width: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 4%;
        }
        .banner-preview .logo-container {
            width: 25%;
            border-radius: 50%;
            padding: 3px;
            border: 3px solid #f5f5f5;
            background-color: #fff;
        }
        .banner-preview .img-logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }
        .banner-preview .shop-name {
            font-size: 0.7rem;
        }
        .banner-preview .class-info {
            font-size: 0.7rem;
        }
        .sidebar-menu {
            padding-top: 1%;
            padding-bottom: 1%;
            font-size: 0.7rem;
        }
    </style>
</script>

<script type="text/ng-template" id="templates/vouchers.html">
    <div class="voucher-preview">
        <div class="row no-voucher" ng-if="block.data.vouchers.length == 0">
            <div class="col-md-12">
                <div>
                    <i class="fa fa-ticket-alt"></i>
                    Thiết kế này sẽ ẩn nếu bạn chưa thiết lập mã giảm giá
                </div>
            </div>
        </div>
    </div>
    <style>
        .voucher-preview {
            padding-top: 1%;
            padding-bottom: 1%;
            font-size: 0.7rem;
        }
        .voucher-preview .no-voucher {
            opacity: 0.4;
        }
    </style>
</script>
