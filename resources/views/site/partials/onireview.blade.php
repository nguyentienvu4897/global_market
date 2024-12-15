<div class="onireviewapp-container" ng-controller="OniReviewController">
    <h3 class="onirvapp-detail-title">Đánh giá, nhận xét khách hàng</h3>
    <div id="onireviewapp">
        <div class="onirvapp-detail">
            <div id="onirvapp-detail-header">
                <div class="onirvapp-detail-headersummary-container">
                    <div class="onirvapp-detail-summary">
                    <div class="onirvapp-detail-summary-info">
                        <div class="onirvapp-detail-summary-info-stars">
                            <div class="onirvapp-detail-summary-info-stars-container">
                                <div class="onirvapp--shape-lg">
                                <div class="onirvapp--shape-container">
                                    <div class="onirvapp--shape-background"></div>
                                    <div class="onirvapp--shape-solid" style="width: 99%;"></div>
                                </div>
                                </div>
                            </div>
                            <span class="onirvapp-detail-summary-info-stars-text">( <% product.product_rates.length | number %> đánh giá)</span>
                        </div>
                        <div class="onirvapp-detail-summary-info-avg"><% total_current_rating | number:1  %>/5</div>
                    </div>
                    <div class="onirvapp-detail-summary-lines">
                        <div class="onirvapp-detail-summary-line">
                            <div class="onirvapp-detail-summary-line-icon">
                                <div class="onirvapp--shape-xs">
                                <div class="onirvapp--shape-container">
                                    <div class="onirvapp--shape-background"></div>
                                    <div class="onirvapp--shape-solid" style="width: 100%;"></div>
                                </div>
                                </div>
                            </div>
                            <div class="onirvapp-detail-summary-line-bar">
                                <div class="onirvapp-processline">
                                <div class="onirvapp-processline-item" style="width: <% five_star_rate_percent | number %>%;"></div>
                                </div>
                            </div>
                            <div class="onirvapp-detail-summary-line-text"><% five_star_rate | number %></div>
                        </div>
                        <div class="onirvapp-detail-summary-line">
                            <div class="onirvapp-detail-summary-line-icon">
                                <div class="onirvapp--shape-xs">
                                <div class="onirvapp--shape-container">
                                    <div class="onirvapp--shape-background"></div>
                                    <div class="onirvapp--shape-solid" style="width: 80%;"></div>
                                </div>
                                </div>
                            </div>
                            <div class="onirvapp-detail-summary-line-bar">
                                <div class="onirvapp-processline">
                                <div class="onirvapp-processline-item" style="width: <% four_star_rate_percent | number %>%;"></div>
                                </div>
                            </div>
                            <div class="onirvapp-detail-summary-line-text"><% four_star_rate | number %></div>
                        </div>
                        <div class="onirvapp-detail-summary-line">
                            <div class="onirvapp-detail-summary-line-icon">
                                <div class="onirvapp--shape-xs">
                                <div class="onirvapp--shape-container">
                                    <div class="onirvapp--shape-background"></div>
                                    <div class="onirvapp--shape-solid" style="width: 60%;"></div>
                                </div>
                                </div>
                            </div>
                            <div class="onirvapp-detail-summary-line-bar">
                                <div class="onirvapp-processline">
                                <div class="onirvapp-processline-item" style="width: <% three_star_rate_percent | number %>%;"></div>
                                </div>
                            </div>
                            <div class="onirvapp-detail-summary-line-text"><% three_star_rate | number %></div>
                        </div>
                        <div class="onirvapp-detail-summary-line">
                            <div class="onirvapp-detail-summary-line-icon">
                                <div class="onirvapp--shape-xs">
                                <div class="onirvapp--shape-container">
                                    <div class="onirvapp--shape-background"></div>
                                    <div class="onirvapp--shape-solid" style="width: 40%;"></div>
                                </div>
                                </div>
                            </div>
                            <div class="onirvapp-detail-summary-line-bar">
                                <div class="onirvapp-processline">
                                <div class="onirvapp-processline-item" style="width: <% two_star_rate_percent | number %>%;"></div>
                                </div>
                            </div>
                            <div class="onirvapp-detail-summary-line-text"><% two_star_rate | number %></div>
                        </div>
                        <div class="onirvapp-detail-summary-line">
                            <div class="onirvapp-detail-summary-line-icon">
                                <div class="onirvapp--shape-xs">
                                <div class="onirvapp--shape-container">
                                    <div class="onirvapp--shape-background"></div>
                                    <div class="onirvapp--shape-solid" style="width: 20%;"></div>
                                </div>
                                </div>
                            </div>
                            <div class="onirvapp-detail-summary-line-bar">
                                <div class="onirvapp-processline">
                                <div class="onirvapp-processline-item" style="width: <% one_star_rate_percent | number %>%;"></div>
                                </div>
                            </div>
                            <div class="onirvapp-detail-summary-line-text"><% one_star_rate | number %></div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="onirvapp-detail-headerimages-container">
                    <div class="onirvapp-detail-headerimages-title">Tất cả hình ảnh</div>
                    <div class="onirvapp-detail-headerimages-list">
                    <div class="onirvapp-images owl-carousel owl-theme owl-nav-style-1" data-lg-items="6" data-md-items="3"
            data-sm-items="2.5" data-xs-items="1.8" data-dot="false" data-nav="false" data-autoplay="true" data-autoplay-timeout="10000" data-autoplay-hover-pause="true" data-lazy-load="true">
                        @foreach ($arr_product_rate_images as $image)
                            <div class="onirvapp-imageitem" style="width: 120px; height: 140px">
                                <button type="button" class="onirvapp-imageitem-container" data-fancybox="gallery" data-src="{{ $image }}">
                                    <img src="{{ $image }}" alt="" class="onirvapp-image-img">
                                </button>
                            </div>
                        @endforeach
                    </div>
                    </div>
                    {{-- <div class="onirvapp-filters">
                    <span class="onirvapp-filters-title">Lọc theo:</span>
                    <div class="onirvapp-filters-list">
                        <button type="button" class="onirvapp-filters-btn">Mới nhất</button><button type="button" class="onirvapp-filters-btn">Cũ nhất</button><button type="button" class="onirvapp-filters-btn">Lượt thích</button>
                        <button type="button" class="onirvapp-filters-btn">
                            5&nbsp;
                            <div class="onirvapp--shape-single onirvapp--shape-xs">
                                <div class="onirvapp--shape-container">
                                <div class="onirvapp--shape-outline"></div>
                                </div>
                            </div>
                        </button>
                        <button type="button" class="onirvapp-filters-btn">
                            4&nbsp;
                            <div class="onirvapp--shape-single onirvapp--shape-xs">
                                <div class="onirvapp--shape-container">
                                <div class="onirvapp--shape-outline"></div>
                                </div>
                            </div>
                        </button>
                        <button type="button" class="onirvapp-filters-btn">
                            3&nbsp;
                            <div class="onirvapp--shape-single onirvapp--shape-xs">
                                <div class="onirvapp--shape-container">
                                <div class="onirvapp--shape-outline"></div>
                                </div>
                            </div>
                        </button>
                        <button type="button" class="onirvapp-filters-btn">
                            2&nbsp;
                            <div class="onirvapp--shape-single onirvapp--shape-xs">
                                <div class="onirvapp--shape-container">
                                <div class="onirvapp--shape-outline"></div>
                                </div>
                            </div>
                        </button>
                        <button type="button" class="onirvapp-filters-btn">
                            1&nbsp;
                            <div class="onirvapp--shape-single onirvapp--shape-xs">
                                <div class="onirvapp--shape-container">
                                <div class="onirvapp--shape-outline"></div>
                                </div>
                            </div>
                        </button>
                    </div>
                    </div> --}}
                </div>
            </div>
            <div id="onirvapp-detail-body">
                <div class="onirvapp-detail-tabs">
                    <div class="onirvapp-tab"><button type="button" class="onirvapp-tab-btn-active onirvapp-tab-btn">Danh sách đánh giá (<% product.product_rates.length | number %>)</button></div>
                    <div class="onirvapp-tab-action"><button type="button" class="onirvapp-btn onirvapp-btn-primary" ng-click="writeReview()">Viết đánh giá mới</button></div>
                </div>
                <div id="onirvapp-review-list" class="onirvapp-comments-list">
                    <div class="onirvapp-comment-item" ng-repeat="rate in product.product_rates track by $index">
                        <div class="onirvapp-comment-item-avatar">
                            <div class="onirvapp-avatar"><i class="fa fa-user"></i></div>
                        </div>
                        <div class="onirvapp-comment-item-content">
                            <div class="onirvapp-comment-item-content-info">
                                <div class="onirvapp-comment-item-content-person">
                                    <div class="onirvapp-comment-item-content-info-container">
                                    <div class="onirvapp-comment-item-content-info-name"><% rate.name %></div>
                                    </div>
                                </div>
                                <div class="onirvapp-comment-item-content-info-shape">
                                    <div class="onirvapp--shape-sm">
                                    <div class="onirvapp--shape-container">
                                        <div class="onirvapp--shape-background"></div>
                                        <div class="onirvapp--shape-solid" style="width: <% (rate.rating / 5 * 100) | number %>%;"></div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="onirvapp-comment-item-content-desc">
                                <div class="onirvapp-comment-item-content-desc-container">
                                    <div class="onirvapp-comment-item-content-desc-title"><% rate.title %></div>
                                    <div class="onirvapp-comment-item-content-desc-detail"><% rate.desc %></div>
                                    <div class="onirvapp-comment-item-content-images">
                                    <div class="onirvapp-images">
                                        <div class="onirvapp-imageitem" style="width: 100px; height: 100px;" ng-repeat="image in rate.images">
                                            <button type="button" class="onirvapp-imageitem-container" data-fancybox="gallery" data-src="<% image.path %>">
                                                <img ng-src="<% image.path %>" alt="" class="onirvapp-image-img">
                                            </button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <ul class="onirvapp-paginate" role="navigation" aria-label="Pagination">
                    <li class="onirvapp-hidden disabled"><a class=" " tabindex="-1" role="button" aria-disabled="true" aria-label="Previous page" rel="prev">Previous</a></li>
                    <li class="selected"><a rel="canonical" role="button" class="onirvapp-paginate-item onirvapp-paginate-item-active" tabindex="-1" aria-label="Page 1 is your current page" aria-current="page">1</a></li>
                    <li><a rel="next" role="button" class="onirvapp-paginate-item" tabindex="0" aria-label="Page 2">2</a></li>
                    <li class="onirvapp-hidden"><a class="" tabindex="0" role="button" aria-disabled="false" aria-label="Next page" rel="next">Next</a></li>
                    </ul> --}}
                </div>
            </div>
        </div>
    </div>
    <div id="headlessui-portal-root" class="hidden">
        <div data-headlessui-portal="">
        <button type="button" aria-hidden="true" style="position: fixed; top: 1px; left: 1px; width: 1px; height: 0px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border-width: 0px;"></button>
        <div>
            <div class="onirvapp-dialog" id="headlessui-dialog-:r2:" role="dialog" aria-modal="true" data-headlessui-state="open">
                <div class="onirvapp-dialog-overlay onirvapp-opacity-100"></div>
                <div class="onirvapp-dialog-content">
                    <div class="onirvapp-dialog-content-container">
                    <div class="onirvapp-dialog-content-panel onirvapp-dialog-content-panel-form onirvapp-opacity-100 onirvapp-scale-100" id="headlessui-dialog-panel-:r3:" data-headlessui-state="open">
                        <button type="button" class="onirvapp-btn onirvapp-btn-icon onirvapp-btn-close" tabindex="0" ng-click="closeWriteReview()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <form>
                            <div class="onirvapp-form-container">
                                <h3 class="onirvapp-form-container-title">Viết đánh giá mới</h3>
                                <div class="onirvapp-form-content">
                                <div class="onirvapp-form-group">
                                    <label class="onirvapp-form-label">Tên của bạn<span>*</span></label>
                                    <input type="text" class="onirvapp-form-input" ng-model="review.name">
                                    <span class="invalid-feedback d-block" role="alert"
                                        ng-if="errors && errors['name']">
                                        <strong><% errors['name'][0] %></strong>
                                    </span>
                                </div>
                                <div class="onirvapp-form-group">
                                    <label class="onirvapp-form-label">Email<span>*</span></label>
                                    <input type="text" class="onirvapp-form-input" ng-model="review.email">
                                    <span class="invalid-feedback d-block" role="alert"
                                        ng-if="errors && errors['email']">
                                        <strong><% errors['email'][0] %></strong>
                                    </span>
                                </div>
                                <div class="onirvapp-form-group">
                                    <label class="onirvapp-form-label">Số điện thoại<span>*</span></label>
                                    <input type="text" class="onirvapp-form-input" ng-model="review.phone">
                                    <span class="invalid-feedback d-block" role="alert"
                                        ng-if="errors && errors['phone']">
                                        <strong><% errors['phone'][0] %></strong>
                                    </span>
                                </div>
                                <div class="onirvapp-form-group">
                                    <label class="onirvapp-form-label">Đánh giá<span>*</span></label>
                                    <div class="onirvapp-form-shape-container">
                                        <div class="onirvapp-shape-container">
                                            <div class="onirvapp--shape-select"><input id="onirvapp-shapeselect-1" type="radio" class="onirvapp-hidden" value="1"><label for="onirvapp-shapeselect-1" ng-click="selectRating(1)" class="onirvapp--shape-select-active"></label></div>
                                            <div class="onirvapp--shape-select"><input id="onirvapp-shapeselect-2" type="radio" class="onirvapp-hidden" value="2"><label for="onirvapp-shapeselect-2" ng-click="selectRating(2)" class="onirvapp--shape-select-active"></label></div>
                                            <div class="onirvapp--shape-select"><input id="onirvapp-shapeselect-3" type="radio" class="onirvapp-hidden" value="3"><label for="onirvapp-shapeselect-3" ng-click="selectRating(3)" class="onirvapp--shape-select-active"></label></div>
                                            <div class="onirvapp--shape-select"><input id="onirvapp-shapeselect-4" type="radio" class="onirvapp-hidden" value="4"><label for="onirvapp-shapeselect-4" ng-click="selectRating(4)" class="onirvapp--shape-select-active"></label></div>
                                            <div class="onirvapp--shape-select"><input id="onirvapp-shapeselect-5" type="radio" class="onirvapp-hidden" value="5"><label for="onirvapp-shapeselect-5" ng-click="selectRating(5)" class="onirvapp--shape-select-active"></label></div>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert"
                                        ng-if="errors && errors['rating']">
                                        <strong><% errors['rating'][0] %></strong>
                                    </span>
                                </div>
                                <div class="onirvapp-form-group">
                                    <label class="onirvapp-form-label">Tiêu đề</label>
                                    <input type="text" class="onirvapp-form-input" ng-model="review.title">
                                    <span class="invalid-feedback d-block" role="alert"
                                        ng-if="errors && errors['title']">
                                        <strong><% errors['title'][0] %></strong>
                                    </span>
                                    <div class="onirvapp-form-rating-container">
                                        <button type="button" ng-click="selectRatingTitle('Khá tệ')" class="onirvapp-btn onirvapp-form-rating-item">Khá tệ</button>
                                        <button type="button" ng-click="selectRatingTitle('Bình thường')" class="onirvapp-btn onirvapp-form-rating-item">Bình thường</button>
                                        <button type="button" ng-click="selectRatingTitle('Sản phẩm tốt')" class="onirvapp-btn onirvapp-form-rating-item">Sản phẩm tốt</button>
                                        <button type="button" ng-click="selectRatingTitle('Giá tốt')" class="onirvapp-btn onirvapp-form-rating-item">Giá tốt</button>
                                        <button type="button" ng-click="selectRatingTitle('Tuyệt vời')" class="onirvapp-btn onirvapp-form-rating-item">Tuyệt vời</button>
                                    </div>
                                </div>
                                <div class="onirvapp-form-group">
                                    <label class="onirvapp-form-label">Mô tả<span>*</span></label>
                                    <textarea ng-model="review.desc" class="onirvapp-form-input" rows="3"></textarea>
                                    <span class="invalid-feedback d-block" role="alert"
                                        ng-if="errors && errors['desc']">
                                        <strong><% errors['desc'][0] %></strong>
                                    </span>
                                </div>
                                {{-- <div class="onirvapp-form-group"><label class="onirvapp-form-label">Video<span class="onirvapp-form-label-desc">(Nhập link youtube, VD: https://www.youtube.com/watch?v=AjWfY7SnMBI)</span></label><input type="text" name="youtube" class="onirvapp-form-input"></div> --}}
                                <div class="onirvapp-form-group">
                                    <label class="onirvapp-form-label">Hình ảnh<span class="onirvapp-form-label-desc">(Tối đa 5 hình, mỗi hình không quá 5mb)</span></label>
                                    <div class="onirvapp-form-images">
                                        <div class="onirvapp-images-withupload">
                                            <div class="onirvapp-images-withupload-list">
                                                <div class="onirvapp-images-withupload-item" ng-repeat="gallery in galleries">
                                                    <a href="blob:<% gallery.image.path %>" target="_blank" rel="noreferrer" class="onirvapp-images-withupload-item-container">
                                                        <img ng-src="<% gallery.image.path %>" alt="" class="onirvapp-images-withupload-item-img">
                                                        <input class="d-none" type="file" accept=".jpg,.png,.jpeg" id="<% gallery.image.element_id %>">
                                                    </a>
                                                    <button type="button" class="onirvapp-btn onirvapp-images-withupload-item-btn" ng-click="removeGallery($index)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="onirvapp-images-withupload-action">
                                                <input class="onirvapp-hidden" type="file" id="gallery-chooser" accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <label for="gallery-chooser" class="onirvapp-images-withupload-action-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                    </svg>
                                                    <span class="onirvapp-images-withupload-action-labeltext">Tải lên</span>
                                                </label>
                                            </div>
                                            <span class="invalid-feedback d-block" role="alert"
                                                ng-if="errors && errors['galleries']">
                                                <strong><% errors['galleries'][0] %></strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="onirvapp-form-action">
                                    <button type="button" class="onirvapp-btn onirvapp-btn-default" ng-click="closeWriteReview()">Hủy</button>
                                    <button type="submit" class="onirvapp-btn onirvapp-btn-primary" ng-click="submitReview()">Gửi đánh giá</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" aria-hidden="true" style="position: fixed; top: 1px; left: 1px; width: 1px; height: 0px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border-width: 0px;"></button>
        </div>
    </div>
</div>
<script src="{{ asset('js/custom.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

@include('partial.classes.base.BaseClass')
@include('partial.classes.base.BaseChildClass')
@include('partial.classes.base.File')
@include('partial.classes.base.Image')
@include('partial.classes.base.BaseClassWithFile')
@include('partial.classes.base.BaseChildClassWithFile')
@include('site.partials.ReviewGallery')
<script>
    app.controller('OniReviewController', function($scope, $http) {
        $scope.product = @json($product);
        $scope.total_current_rating = $scope.product.product_rates.reduce((total, rate) => total + rate.rating, 0) / $scope.product.product_rates.length || 0;

        $scope.five_star_rate = $scope.product.product_rates.filter(rate => rate.rating == 5).length;
        $scope.four_star_rate = $scope.product.product_rates.filter(rate => rate.rating == 4).length;
        $scope.three_star_rate = $scope.product.product_rates.filter(rate => rate.rating == 3).length;
        $scope.two_star_rate = $scope.product.product_rates.filter(rate => rate.rating == 2).length;
        $scope.one_star_rate = $scope.product.product_rates.filter(rate => rate.rating == 1).length;

        $scope.five_star_rate_percent = ($scope.five_star_rate / $scope.product.product_rates.length) * 100;
        $scope.four_star_rate_percent = ($scope.four_star_rate / $scope.product.product_rates.length) * 100;
        $scope.three_star_rate_percent = ($scope.three_star_rate / $scope.product.product_rates.length) * 100;
        $scope.two_star_rate_percent = ($scope.two_star_rate / $scope.product.product_rates.length) * 100;
        $scope.one_star_rate_percent = ($scope.one_star_rate / $scope.product.product_rates.length) * 100;

        $scope.product_id = '{{ $product->id }}';
        $scope.review = {
            name: '',
            email: '',
            phone: '',
            title: '',
            desc: '',
            rating: 5,
        };
        $scope.galleries = [];
        $scope.writeReview = function() {
            $('#headlessui-portal-root').removeClass('hidden');
        }
        $scope.closeWriteReview = function() {
            $('#headlessui-portal-root').addClass('hidden');
        }
        $scope.selectRating = function(rating) {
            let total_rating = 5;
            $scope.review.rating = rating;
            for (let i = 1; i <= total_rating; i++) {
                if (i <= rating) {
                    $(`label[for="onirvapp-shapeselect-${i}"]`).addClass('onirvapp--shape-select-active');
                } else {
                    $(`label[for="onirvapp-shapeselect-${i}"]`).removeClass('onirvapp--shape-select-active');
                }
            }
        }
        $scope.selectRatingTitle = function(title) {
            $scope.review.title = title;
        }

        $(document).on('change', '#gallery-chooser', function(e) {
            Array.from(this.files).forEach(file => {
                let new_gallery = new ReviewGallery({}, $scope);
                $scope.galleries.push(new_gallery);
                console.log($scope.galleries[0]);
                setTimeout(() => {
                    let e = document.getElementById(`${new_gallery.image.element_id}`);
                    let dataTransfer = new DataTransfer()
                    dataTransfer.items.add(file)
                    e.files = dataTransfer.files
                    $(e).trigger('change');
                    $scope.$apply();
                });
            });
            $scope.$apply();
        })

        $scope.removeGallery = function(index) {
            $scope.galleries.splice(index, 1);
        }

        $scope.errors = {};
        $scope.submitReview = function() {
            let data = $scope.review;
            data.product_id = $scope.product_id;
            data = jsonToFormData(data);
            $scope.galleries.forEach((g, i) => {
                data.append(`galleries[${i}][image]`, g.image.submit_data);
            })
            $.ajax({
                url: '{{ route('front.submit-review') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        $scope.closeWriteReview();
                        toastr.success(res.message);
                    } else {
                        $scope.errors = res.errors;
                        toastr.error(res.message);
                    }
                },
                error: function(res) {
                    $scope.errors = res.errors;
                    toastr.error(res.message);
                },
                complete: function() {
                    $scope.$applyAsync();
                }
            })
        }
    });
</script>

