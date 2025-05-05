<?php

use App\Model\Common\User;

Route::get('/dang-nhap', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::group(['prefix' => 'admin'], function () {
    Route::get('dang-xuat', 'Auth\LoginController@logout')->name('logout');
    Route::get('/login-page', function () {
        return view('layouts.login');
    });
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/', function () {
        if (!Auth::guard('admin')->guest()) {
            return redirect()->route('dash');
        } else {
            return redirect()->route('login');
        }
    })->name('index');

    Route::middleware('auth:admin')->group(function () {
        // Cấu hình chung
        Route::group(['prefix' => 'configs', 'middleware' => 'checkPermission:Cập nhật cấu hình'], function () {
            Route::get('/', 'Admin\ConfigController@edit')->name('Config.edit')->middleware('checkPermission:Cập nhật cấu hình');
            Route::post('/update', 'Admin\ConfigController@update')->name('Config.update')->middleware('checkPermission:Cập nhật cấu hình');
        });

        // Menu Catalog
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/create', 'Admin\CategoryController@create')->name('Category.create')->middleware('checkPermission:Thêm danh mục hàng hóa');
            Route::post('/', 'Admin\CategoryController@store')->name('Category.store')->middleware('checkPermission:Thêm danh mục hàng hóa');
            Route::post('/{id}/update', 'Admin\CategoryController@update')->name('Category.update')->middleware('checkPermission:Sửa danh mục hàng hóa');
            Route::get('/{id}/edit', 'Admin\CategoryController@edit')->name('Category.edit')->middleware('checkPermission:Sửa danh mục hàng hóa');
            Route::get('/{id}/delete', 'Admin\CategoryController@delete')->name('Category.delete')->middleware('checkPermission:Xóa danh mục hàng hóa');
            Route::get('/', 'Admin\CategoryController@index')->name('Category.index');
            Route::get('/searchData', 'Admin\CategoryController@searchData')->name('Category.searchData');
            Route::post('/nested-sort', 'Admin\CategoryController@nestedSort')->name('Category.nestedSort');
            Route::get('/{id}/getDataForEdit', 'Admin\CategoryController@getDataForEdit')->name('Category.get.data.edit');
            Route::post('add-to-home-page', 'Admin\CategoryController@addToHomePage')->name('Category.add.homepage');
            Route::get('/get-parent', 'Admin\CategoryController@getParentCategory')->name('Category.get.parent');
        });

        Route::group(['prefix' => 'products'], function () {
            Route::get('/', 'Admin\ProductController@index')->name('Product.index');
            Route::get('/create', 'Admin\ProductController@create')->name('Product.create')->middleware('checkPermission:Thêm hàng hóa');
            Route::post('/', 'Admin\ProductController@store')->name('Product.store')->middleware('checkPermission:Thêm hàng hóa');
            Route::post('/{id}/update', 'Admin\ProductController@update')->name('Product.update')->middleware('checkPermission:Sửa hàng hóa');
            Route::get('/{id}/edit', 'Admin\ProductController@edit')->name('Product.edit')->middleware('checkPermission:Sửa hàng hóa');
            Route::get('/{id}/delete', 'Admin\ProductController@delete')->name('Product.delete')->middleware('checkPermission:Xóa hàng hóa');
            Route::get('/searchData', 'Admin\ProductController@searchData')->name('Product.searchData');
            Route::get('/filterDataForBill', 'Admin\ProductController@filterDataForBill')->name('Product.filterDataForBill');
            Route::get('/{id}/getData', 'Admin\ProductController@getData')->name('Product.getData');
            Route::get('/exportExcel', 'Admin\ProductController@exportExcel')->name('Product.exportExcel')->middleware('checkPermission:Xuất excel sản phẩm');
            Route::get('/exportPDF', 'Admin\ProductController@exportPDF')->name('Product.exportPDF')->middleware('checkPermission:Xuất pdf sản phẩm');
            Route::post('/add-category-special', 'Admin\ProductController@addToCategorySpecial')->name('Product.add.category.special');

            Route::get('/act-delete', 'Admin\ProductController@actDelete')->name('products.delete.multi');
            Route::post('/{id}/deleteFile', 'Admin\ProductController@deleteFile')->name('products.deleteFile');
        });

        // Đánh giá sản phẩm
        Route::group(['prefix' => 'product-rates'], function () {
            Route::get('/', 'Admin\ProductRateController@index')->name('product_rates.index');
            Route::get('/searchData', 'Admin\ProductRateController@searchData')->name('product_rates.searchData');
            Route::get('/{id}/show', 'Admin\ProductRateController@show')->name('product_rates.show');
            Route::post('/update-status', 'Admin\ProductRateController@updateStatus')->name('product_rates.update.status');
            Route::get('/{id}/getDataForEdit', 'Admin\ProductRateController@getDataForEdit')->name('product_rates.getDataForEdit');
        });

        Route::group(['prefix' => 'post-categories'], function () {
            Route::get('/create', 'Admin\PostCategoryController@create')->name('PostCategory.create')->middleware('checkPermission:Thêm danh mục bài viết');
            Route::post('/', 'Admin\PostCategoryController@store')->name('PostCategory.store')->middleware('checkPermission:Thêm danh mục bài viết');
            Route::post('/{id}/update', 'Admin\PostCategoryController@update')->name('PostCategory.update')->middleware('checkPermission:Sửa danh mục bài viết');
            Route::get('/{id}/edit', 'Admin\PostCategoryController@edit')->name('PostCategory.edit')->middleware('checkPermission:Sửa danh mục bài viết');
            Route::get('/{id}/getDataForEdit', 'Admin\PostCategoryController@getDataForEdit');
            Route::get('/{id}/delete', 'Admin\PostCategoryController@delete')->name('PostCategory.delete')->middleware('checkPermission:Xóa danh mục bài viết');
            Route::get('/', 'Admin\PostCategoryController@index')->name('PostCategory.index');
            Route::get('/searchData', 'Admin\PostCategoryController@searchData')->name('PostCategory.searchData');
            Route::post('/nested-sort', 'Admin\PostCategoryController@nestedSort')->name('PostCategory.nestedSort');
            Route::post('/add-home-page', 'Admin\PostCategoryController@addToHomepage')->name('PostCategory.add.home.page');
        });

        // danh mục liên hệ
        Route::group(['prefix' => 'contacts'], function () {
            Route::get('/', 'Admin\ContactController@index')->name('contacts.index')->middleware('checkPermission:Quản lý danh mục khách hàng liên hệ');
            Route::get('/searchData', 'Admin\ContactController@searchData')->name('contacts.searchData');
            Route::get('/{id}/detail', 'Admin\ContactController@getContactDetail')->name('contacts.detail');
            Route::get('/{id}/delete', 'Admin\ContactController@delete')->name('contacts.delete')->middleware('checkPermission:Quản lý danh mục khách hàng liên hệ');
        });

        Route::group(['prefix' => 'apply-recruitments'], function () {
            Route::get('/', 'Admin\ApplyRecruitmentsController@index')->name('apply-recruitments.index');
            Route::get('/searchData', 'Admin\ApplyRecruitmentsController@searchData')->name('apply-recruitments.searchData');
            Route::get('/{id}/detail', 'Admin\ApplyRecruitmentsController@getDetail')->name('apply-recruitments.detail');
            Route::get('/{id}/delete', 'Admin\ApplyRecruitmentsController@delete')->name('apply-recruitments.delete');
        });

        Route::group(['prefix' => 'showrooms'], function () {
            Route::get('/', 'Admin\ShowroomController@index')->name('showrooms.index');
            Route::get('/searchData', 'Admin\ShowroomController@searchData')->name('showrooms.searchData');
            Route::get('/{id}/show', 'Admin\ShowroomController@show')->name('showrooms.show');
            Route::get('/create', 'Admin\ShowroomController@create')->name('showrooms.create');
            Route::post('/', 'Admin\ShowroomController@store')->name('showrooms.store');
            Route::post('/{id}/update', 'Admin\ShowroomController@update')->name('showrooms.update');
            Route::post('/updateOrderShowroom', 'Admin\ShowroomController@updateOrderShowroom')->name('showrooms.updateOrderShowroom');
            Route::get('/{id}/delete', 'Admin\ShowroomController@delete')->name('showrooms.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\ShowroomController@getDataForEdit')->name('showrooms.getDataForEdit');
        });

        Route::group(['prefix' => 'e-brochure'], function () {
            Route::get('/', 'Admin\EBrochureController@index')->name('e-brochure.index');
            Route::get('/searchData', 'Admin\EBrochureController@searchData')->name('e-brochure.searchData');
            Route::get('/{id}/show', 'Admin\EBrochureController@show')->name('e-brochure.show');
            Route::get('/create', 'Admin\EBrochureController@create')->name('e-brochure.create');
            Route::post('/', 'Admin\EBrochureController@store')->name('e-brochure.store');
            Route::post('/{id}/update', 'Admin\EBrochureController@update')->name('e-brochure.update');
            Route::post('/updateOrderShowroom', 'Admin\EBrochureController@updateOrderShowroom')->name('e-brochure.updateOrderShowroom');
            Route::get('/{id}/delete', 'Admin\EBrochureController@delete')->name('e-brochure.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\EBrochureController@getDataForEdit')->name('e-brochure.getDataForEdit');
        });

        // Bài viết
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', 'Admin\PostController@index')->name('Post.index');
            Route::get('/searchData', 'Admin\PostController@searchData')->name('Post.searchData');
            Route::get('/{id}/show', 'Admin\PostController@show')->name('Post.show');
            Route::get('/{id}/getData', 'Admin\PostController@getData')->name('Post.getData');
            Route::get('/create', 'Admin\PostController@create')->name('Post.create')->middleware('checkPermission:Thêm bài viết');
            Route::post('/', 'Admin\PostController@store')->name('Post.store')->middleware('checkPermission:Thêm bài viết');
            Route::post('/{id}/update', 'Admin\PostController@update')->name('Post.update')->middleware('checkPermission:Sửa bài viết');
            Route::get('/{id}/edit', 'Admin\PostController@edit')->name('Post.edit')->middleware('checkPermission:Sửa bài viết');
            Route::get('/{id}/delete', 'Admin\PostController@delete')->name('Post.delete')->middleware('checkPermission:Xóa bài viết');
            Route::get('/exportExcel', 'Admin\PostController@exportExcel')->name('Post.exportExcel');
            Route::post('/add-to-category-special', 'Admin\PostController@addToCategorySpecial')->name('Post.add.category.special');
        });

        // HTML Block
        Route::group(['prefix' => 'blocks'], function () {
            Route::get('/', 'Admin\BlockController@index')->name('Block.index');
            Route::get('/searchData', 'Admin\BlockController@searchData')->name('Block.searchData');
            Route::get('/{id}/show', 'Admin\BlockController@show')->name('Block.show');
            Route::get('/create', 'Admin\BlockController@create')->name('Block.create');
            Route::post('/', 'Admin\BlockController@store')->name('Block.store');
            Route::post('/{id}/update', 'Admin\BlockController@update')->name('Block.update');
            Route::get('/{id}/edit', 'Admin\BlockController@edit')->name('Block.edit');
            Route::get('/{id}/delete', 'Admin\BlockController@delete')->name('Block.delete');
            Route::get('/exportExcel', 'Admin\BlockController@exportExcel')->name('Block.exportExcel');
        });

        // Customer Review
        Route::group(['prefix' => 'reviews'], function () {
            Route::get('/', 'Admin\ReviewController@index')->name('Review.index');
            Route::get('/searchData', 'Admin\ReviewController@searchData')->name('Review.searchData');
            Route::get('/{id}/show', 'Admin\ReviewController@show')->name('Review.show');
            Route::get('/create', 'Admin\ReviewController@create')->name('Review.create');
            Route::post('/', 'Admin\ReviewController@store')->name('Review.store');
            Route::post('/{id}/update', 'Admin\ReviewController@update')->name('Review.update');
            Route::get('/{id}/delete', 'Admin\ReviewController@delete')->name('Review.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\ReviewController@getDataForEdit');
            Route::get('/exportExcel', 'Admin\ReviewController@exportExcel')->name('Review.exportExcel');
        });

        // Manufacturers (hãng sản xuất)
        Route::group(['prefix' => 'manufacturers'], function () {
            Route::get('/', 'Admin\ManufacturerController@index')->name('manufacturers.index');
            Route::get('/searchData', 'Admin\ManufacturerController@searchData')->name('manufacturers.searchData');
            Route::get('/{id}/show', 'Admin\ManufacturerController@show')->name('Review.show');
            Route::get('/create', 'Admin\ManufacturerController@create')->name('manufacturers.create');
            Route::post('/', 'Admin\ManufacturerController@store')->name('manufacturers.store');
            Route::post('/{id}/update', 'Admin\ManufacturerController@update')->name('manufacturers.update');
            Route::get('/{id}/delete', 'Admin\ManufacturerController@delete')->name('manufacturers.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\ManufacturerController@getDataForEdit');
            Route::get('/exportExcel', 'Admin\ManufacturerController@exportExcel')->name('manufacturers.exportExcel');

            Route::get('/act-delete', 'Admin\ManufacturerController@actDelete')->name('manufacturers.delete.multi');
            Route::get('/check-act-delete', 'Admin\ManufacturerController@checkActDelete')->name('manufacturers.check.delete.multi');
        });

        // Origins (xuất xứ)
        Route::group(['prefix' => 'origins'], function () {
            Route::get('/', 'Admin\OriginController@index')->name('origins.index');
            Route::get('/searchData', 'Admin\OriginController@searchData')->name('origins.searchData');
            Route::get('/{id}/show', 'Admin\OriginController@show')->name('origins.show');
            Route::get('/create', 'Admin\OriginController@create')->name('origins.create');
            Route::post('/', 'Admin\OriginController@store')->name('origins.store');
            Route::post('/{id}/update', 'Admin\OriginController@update')->name('origins.update');
            Route::get('/{id}/delete', 'Admin\OriginController@delete')->name('origins.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\OriginController@getDataForEdit');
            Route::get('/exportExcel', 'Admin\OriginController@exportExcel')->name('origins.exportExcel');
        });

        // Dự án
        Route::group(['prefix' => 'projects'], function () {
            Route::get('/', 'Admin\ProjectController@index')->name('Project.index');
            Route::get('/searchData', 'Admin\ProjectController@searchData')->name('Project.searchData');
            Route::get('/{id}/show', 'Admin\ProjectController@show')->name('Project.show');
            Route::get('/{id}/getData', 'Admin\ProjectController@getData')->name('Project.getData');
            Route::get('/create', 'Admin\ProjectController@create')->name('Project.create')->middleware('checkPermission:Thêm bài viết');
            Route::post('/', 'Admin\ProjectController@store')->name('Project.store')->middleware('checkPermission:Thêm bài viết');
            Route::post('/{id}/update', 'Admin\ProjectController@update')->name('Project.update')->middleware('checkPermission:Sửa bài viết');
            Route::get('/{id}/edit', 'Admin\ProjectController@edit')->name('Project.edit')->middleware('checkPermission:Sửa bài viết');
            Route::get('/{id}/delete', 'Admin\ProjectController@delete')->name('Project.delete')->middleware('checkPermission:Xóa bài viết');
            Route::get('/exportExcel', 'Admin\ProjectController@exportExcel')->name('Project.exportExcel');
            Route::post('/add-to-category-special', 'Admin\ProjectController@addToCategorySpecial')->name('Project.add.category.special');
        });

        Route::group(['prefix' => 'recruitment'], function () {
            Route::get('/', 'Admin\RecruitmentController@index')->name('recruitments.index');
            Route::get('/searchData', 'Admin\RecruitmentController@searchData')->name('recruitments.searchData');
            Route::get('/{id}/show', 'Admin\RecruitmentController@show')->name('recruitments.show');
            Route::get('/{id}/getData', 'Admin\RecruitmentController@getData')->name('recruitments.getData');
            Route::get('/create', 'Admin\RecruitmentController@create')->name('recruitments.create');
            Route::post('/', 'Admin\RecruitmentController@store')->name('recruitments.store');
            Route::post('/{id}/update', 'Admin\RecruitmentController@update')->name('recruitments.update');
            Route::get('/{id}/edit', 'Admin\RecruitmentController@edit')->name('recruitments.edit');
            Route::get('/{id}/delete', 'Admin\RecruitmentController@delete')->name('recruitments.delete');
            Route::get('/exportExcel', 'Admin\RecruitmentController@exportExcel')->name('recruitments.exportExcel');
            Route::post('/add-to-category-special', 'Admin\RecruitmentController@addToCategorySpecial')->name('recruitments.add.category.special');
        });

        // đối tác
        Route::group(['prefix' => 'partners'], function () {
            Route::get('/', 'Admin\PartnerController@index')->name('partners.index');
            Route::get('/searchData', 'Admin\PartnerController@searchData')->name('partners.searchData');
            Route::get('/{id}/show', 'Admin\PartnerController@show')->name('partners.show');
            Route::get('/create', 'Admin\PartnerController@create')->name('partners.create');
            Route::post('/', 'Admin\PartnerController@store')->name('partners.store');
            Route::post('/{id}/update', 'Admin\PartnerController@update')->name('partners.update');
            Route::get('/{id}/delete', 'Admin\PartnerController@delete')->name('partners.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\PartnerController@getDataForEdit');
            Route::get('/exportExcel', 'Admin\PartnerController@exportExcel')->name('partners.exportExcel');
        });

        // cấu hình số liệu thống kê
        Route::group(['prefix' => 'configStatistic'], function () {
            Route::get('/', 'Admin\ConfigStatisticController@index')->name('configStatistic.index');
            Route::get('/searchData', 'Admin\ConfigStatisticController@searchData')->name('configStatistic.searchData');
            Route::get('/{id}/show', 'Admin\ConfigStatisticController@show')->name('configStatistic.show');
            Route::get('/create', 'Admin\ConfigStatisticController@create')->name('configStatistic.create');
            Route::post('/', 'Admin\ConfigStatisticController@store')->name('configStatistic.store');
            Route::post('/{id}/update', 'Admin\ConfigStatisticController@update')->name('configStatistic.update');
            Route::get('/{id}/delete', 'Admin\ConfigStatisticController@delete')->name('configStatistic.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\ConfigStatisticController@getDataForEdit');
            Route::get('/exportExcel', 'Admin\ConfigStatisticController@exportExcel')->name('configStatistic.exportExcel');
        });

        // nhân viên tư vấn
        Route::group(['prefix' => 'consultants'], function () {
            Route::get('/', 'Admin\ConsultantController@index')->name('consultants.index');
            Route::get('/searchData', 'Admin\ConsultantController@searchData')->name('consultants.searchData');
            Route::get('/{id}/show', 'Admin\ConsultantController@show')->name('consultants.show');
            Route::get('/create', 'Admin\ConsultantController@create')->name('consultants.create');
            Route::post('/', 'Admin\ConsultantController@store')->name('consultants.store');
            Route::post('/{id}/update', 'Admin\ConsultantController@update')->name('consultants.update');
            Route::get('/{id}/delete', 'Admin\ConsultantController@delete')->name('consultants.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\ConsultantController@getDataForEdit');
        });

        // Danh mục đặc biệt
        Route::group(['prefix' => 'category-special'], function () {
            Route::get('/', 'Admin\CategorySpecialController@index')->name('category_special.index');
            Route::get('/searchData', 'Admin\CategorySpecialController@searchData')->name('category_special.searchData');
            Route::get('/{id}/show', 'Admin\CategorySpecialController@show')->name('category_special.show');
            Route::get('/create', 'Admin\CategorySpecialController@create')->name('category_special.create')->middleware('checkPermission:Thêm danh mục đặc biệt');
            Route::post('/', 'Admin\CategorySpecialController@store')->name('category_special.store')->middleware('checkPermission:Thêm danh mục đặc biệt');
            Route::post('/{id}/update', 'Admin\CategorySpecialController@update')->name('category_special.update')->middleware('checkPermission:Sửa danh mục đặc biệt');
            Route::get('/{id}/delete', 'Admin\CategorySpecialController@delete')->name('category_special.delete')->middleware('checkPermission:Xóa danh mục đặc biệt');
            Route::get('/{id}/getDataForEdit', 'Admin\CategorySpecialController@getDataForEdit');
            Route::get('/exportExcel', 'Admin\CategorySpecialController@exportExcel')->name('category_special.exportExcel');
        });

        // Danh mục vouchers
        Route::group(['prefix' => 'vouchers'], function () {
            Route::get('/', 'Admin\VoucherController@index')->name('vouchers.index');
            Route::get('/searchData', 'Admin\VoucherController@searchData')->name('vouchers.searchData');
            Route::get('/{id}/show', 'Admin\VoucherController@show')->name('vouchers.show');
            Route::get('/create', 'Admin\VoucherController@create')->name('vouchers.create')->middleware('checkPermission:Thêm mã giảm giá');
            Route::post('/', 'Admin\VoucherController@store')->name('vouchers.store')->middleware('checkPermission:Thêm mã giảm giá');
            Route::post('/{id}/update', 'Admin\VoucherController@update')->name('vouchers.update')->middleware('checkPermission:Sửa mã giảm giá');
            Route::get('/{id}/delete', 'Admin\VoucherController@delete')->name('vouchers.delete')->middleware('checkPermission:Xóa mã giảm giá');
            Route::get('/{id}/getDataForEdit', 'Admin\VoucherController@getDataForEdit');
        });

        // Attributes (thuộc tính sản phẩm)
        Route::group(['prefix' => 'attributes'], function () {
            Route::get('/', 'Admin\AttributeController@index')->name('attributes.index');
            Route::get('/searchData', 'Admin\AttributeController@searchData')->name('attributes.searchData');
            Route::get('/{id}/show', 'Admin\AttributeController@show')->name('attributes.show');
            Route::get('/create', 'Admin\AttributeController@create')->name('attributes.create')->middleware('checkPermission:Thêm thuộc tính hàng hóa');
            Route::post('/', 'Admin\AttributeController@store')->name('attributes.store')->middleware('checkPermission:Thêm thuộc tính hàng hóa');
            Route::post('/{id}/update', 'Admin\AttributeController@update')->name('attributes.update')->middleware('checkPermission:Sửa thuộc tính hàng hóa');
            Route::get('/{id}/delete', 'Admin\AttributeController@delete')->name('attributes.delete')->middleware('checkPermission:Xóa thuộc tính hàng hóa');
            Route::get('/{id}/getDataForEdit', 'Admin\AttributeController@getDataForEdit');
            Route::get('/exportExcel', 'Admin\AttributeController@exportExcel')->name('attributes.exportExcel');
        });

        // ql đơn hàng
        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', 'Admin\OrderController@index')->name('orders.index')->middleware('checkPermission:Quản lý đơn hàng');
            Route::get('/searchData', 'Admin\OrderController@searchData')->name('orders.searchData')->middleware('checkPermission:Quản lý đơn hàng');
            Route::get('/{id}/show', 'Admin\OrderController@show')->name('orders.show')->middleware('checkPermission:Xem chi tiết đơn hàng');
            Route::post('/update-status', 'Admin\OrderController@updateStatus')->name('orders.update.status')->middleware('checkPermission:Cập nhật trạng thái đơn hàng');
            Route::get('/exportList', 'Admin\OrderController@exportList')->name('orders.exportList')->middleware('checkPermission:Xuất excel đơn hàng');
            Route::post('/importExcel', 'Admin\OrderController@importExcel')->name('orders.importExcel')->middleware('checkPermission:Import excel đơn hàng');
        });

        // banner trang chủ
        Route::group(['prefix' => 'banner'], function () {
            Route::get('/', 'Admin\BannerController@index')->name('banners.index');
            Route::get('/searchData', 'Admin\BannerController@searchData')->name('banners.searchData');
            Route::get('/{id}/show', 'Admin\BannerController@show')->name('banners.show');
            Route::get('/create', 'Admin\BannerController@create')->name('banners.create')->middleware('checkPermission:Thêm danh mục banner trang chủ');
            Route::post('/', 'Admin\BannerController@store')->name('banners.store')->middleware('checkPermission:Thêm danh mục banner trang chủ');
            Route::post('/{id}/update', 'Admin\BannerController@update')->name('banners.update')->middleware('checkPermission:Sửa danh mục banner trang chủ');
            Route::get('/{id}/delete', 'Admin\BannerController@delete')->name('banners.delete')->middleware('checkPermission:Xóa danh mục banner trang chủ');
            Route::get('/{id}/getDataForEdit', 'Admin\BannerController@getDataForEdit')->name('banners.getDataForEdit');
        });

        // tags
        Route::group(['prefix' => 'tags'], function () {
            Route::get('/', 'Admin\TagController@index')->name('tags.index');
            Route::get('/searchData', 'Admin\TagController@searchData')->name('tags.searchData');
            Route::post('', 'Admin\TagController@store')->name('tags.store')->middleware('checkPermission:Thêm danh mục tag');
            Route::get('/{id}/getDataForEdit/', 'Admin\TagController@getDataForEdit')->name('tags.edit')->middleware('checkPermission:Sửa danh mục tag');
            Route::put('/{id}/update', 'Admin\TagController@update')->name('tags.update')->middleware('checkPermission:Sửa danh mục tag');
            Route::get('/{id}/delete', 'Admin\TagController@delete')->name('tags.delete')->middleware('checkPermission:Xóa danh mục tag');
        });

        // quản lý cửa hàng
        Route::group(['prefix' => 'stores'], function () {
            Route::get('/', 'Admin\StoreController@index')->name('stores.index');
            Route::get('/searchData', 'Admin\StoreController@searchData')->name('stores.searchData');
            Route::get('/{id}/show', 'Admin\StoreController@show')->name('stores.show');
            Route::get('/{id}/edit', 'Admin\StoreController@edit')->name('stores.edit');
            Route::get('/create', 'Admin\StoreController@create')->name('stores.create');
            Route::post('/', 'Admin\StoreController@store')->name('stores.store');
            Route::post('/{id}/update', 'Admin\StoreController@update')->name('stores.update');
            Route::get('/{id}/delete', 'Admin\StoreController@delete')->name('stores.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\StoreController@getDataForEdit');
        });

        // quản lý chính sách
        Route::group(['prefix' => 'policies'], function () {
            Route::get('/', 'Admin\PolicyController@index')->name('policies.index');
            Route::get('/searchData', 'Admin\PolicyController@searchData')->name('policies.searchData');
            Route::get('/{id}/show', 'Admin\PolicyController@show')->name('policies.show');
            Route::get('/{id}/edit', 'Admin\PolicyController@edit')->name('policies.edit')->middleware('checkPermission:Sửa danh mục chính sách');
            Route::get('/create', 'Admin\PolicyController@create')->name('policies.create')->middleware('checkPermission:Thêm danh mục chính sách');
            Route::post('/', 'Admin\PolicyController@store')->name('policies.store')->middleware('checkPermission:Thêm danh mục chính sách');
            Route::post('/{id}/update', 'Admin\PolicyController@update')->name('policies.update')->middleware('checkPermission:Sửa danh mục chính sách');
            Route::get('/{id}/delete', 'Admin\PolicyController@delete')->name('policies.delete')->middleware('checkPermission:Xóa danh mục chính sách');
            Route::get('/{id}/getDataForEdit', 'Admin\PolicyController@getDataForEdit');
        });

        // quản lý yêu cầu affiliate link
        Route::group(['prefix' => 'affiliate-link-requests'], function () {
            Route::get('/', 'Admin\AffiliateLinkRequestController@index')->name('affiliate-link-requests.index');
            Route::get('/searchData', 'Admin\AffiliateLinkRequestController@searchData')->name('affiliate-link-requests.searchData');
            Route::post('/update-status', 'Admin\AffiliateLinkRequestController@updateStatus')->name('affiliate-link-requests.update.status');
        });

        // quản lý yêu cầu seller
        Route::group(['prefix' => 'seller-requests'], function () {
            Route::get('/', 'Admin\SellerRequestController@index')->name('seller-requests.index');
            Route::get('/searchData', 'Admin\SellerRequestController@searchData')->name('seller-requests.searchData');
            Route::post('/update-status', 'Admin\SellerRequestController@updateStatus')->name('seller-requests.update.status');
        });

        // quản lý seller stores
        Route::group(['prefix' => 'seller-stores'], function () {
            Route::get('/', 'Admin\SellerStoreController@index')->name('seller-stores.index');
            Route::get('/searchData', 'Admin\SellerStoreController@searchData')->name('seller-stores.searchData');
            Route::get('/{id}/edit', 'Admin\SellerStoreController@edit')->name('seller-stores.edit');
            Route::get('/{id}/edit_decoration', 'Admin\SellerStoreController@editDecoration')->name('seller-stores.edit_decoration');
            Route::post('/{id}/update', 'Admin\SellerStoreController@update')->name('seller-stores.update');
            Route::get('/{id}/delete', 'Admin\SellerStoreController@delete')->name('seller-stores.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\SellerStoreController@getDataForEdit')->name('seller-stores.getDataForEdit');
        });

        Route::group(['prefix' => 'common'], function () {
            Route::get('/dashboard', 'Common\DashboardController@index')->name('dash');

            Route::get('/{id}/checkprint', 'G7\BillController@checkPrint');

            // Role Uptek
            Route::group(['prefix' => 'roles', 'middleware' => 'checkType:' . User::SUPER_ADMIN . ',' . User::QUAN_TRI_VIEN], function () {
                Route::get('/create', 'Common\RoleController@create')->name('Role.create')->middleware('checkPermission:Thêm chức vụ');
                Route::post('/', 'Common\RoleController@store')->name('Role.store')->middleware('checkPermission:Thêm chức vụ');
                Route::get('/', 'Common\RoleController@index')->name('Role.index')->middleware('checkPermission:Quản lý chức vụ');
                Route::get('/{id}/edit', 'Common\RoleController@edit')->name('Role.edit')->middleware('checkPermission:Cập nhật chức vụ');
                Route::get('/{id}/delete', 'Common\RoleController@delete')->name('Role.delete')->middleware('checkPermission:Xóa chức vụ');
                Route::post('/{id}/update', 'Common\RoleController@update')->name('Role.update')->middleware('checkPermission:Cập nhật chức vụ');
                Route::get('/searchData', 'Common\RoleController@searchData')->name('Role.searchData');
            });

            Route::group(['prefix' => 'users', 'middleware' => 'checkType:' . User::SUPER_ADMIN . ',' . User::QUAN_TRI_VIEN], function () {
                Route::get('/create', 'Common\UserController@create')->name('User.create')->middleware('checkPermission:Thêm mới tài khoản người dùng');
                Route::post('/', 'Common\UserController@store')->name('User.store')->middleware('checkPermission:Thêm mới tài khoản người dùng');
                Route::get('/', 'Common\UserController@index')->name('User.index')->middleware('checkPermission:Quản lý tài khoản người dùng');
                Route::get('/{id}/edit', 'Common\UserController@edit')->name('User.edit')->middleware('checkPermission:Cập nhật tài khoản người dùng');
                Route::get('/{id}/delete', 'Common\UserController@delete')->name('User.delete')->middleware('checkPermission:Xóa tài khoản người dùng');
                Route::post('/{id}/update', 'Common\UserController@update')->name('User.update')->middleware('checkPermission:Cập nhật tài khoản người dùng');
                Route::get('/searchData', 'Common\UserController@searchData')->name('User.searchData');
                Route::get('/exportExcel', 'Common\UserController@exportExcel')->name('User.exportExcel');
                Route::get('/exportPdf', 'Common\UserController@exportPDF')->name('User.exportPDF');
            });


            Route::group(['prefix' => 'notifications'], function () {
                Route::get('/', 'Common\NotificationsController@index')->name('Notification.index');
                Route::get('/{id}/read', 'Common\NotificationsController@read')->name('Notification.read');
                Route::get('/searchData', 'Common\NotificationsController@searchData')->name('Notification.searchData');
            });

            Route::group(['prefix' => 'reports', 'middleware' => 'checkType:' . User::SUPER_ADMIN . ',' . User::QUAN_TRI_VIEN], function () {
                Route::get('/promoReport', 'Common\ReportController@promoReport')->name('Report.promoReport')->middleware('checkPermission:Xem báo cáo khuyến mãi chiết khấu');
                Route::get('/promoReportSearchData', 'Common\ReportController@promoReportSearchData')->name('Report.promoReportSearchData');
                Route::get('/promoReportPrint', 'Common\ReportController@promoReportPrint')->name('Report.promoReportPrint');
                Route::get('/promoProductReport', 'Common\ReportController@promoProductReport')->name('Report.promoProductReport')->middleware('checkPermission:Xem báo cáo khuyến mãi theo hàng hóa');
                Route::get('/promoProductReportSearchData', 'Common\ReportController@promoProductReportSearchData')->name('Report.promoProductReportSearchData');
                Route::get('/promoProductReportPrint', 'Common\ReportController@promoProductReportPrint')->name('Report.promoProductReportPrint');
                Route::get('/customerSaleReport', 'Common\ReportController@customerSaleReport')->name('Report.customerSaleReport')->middleware('checkPermission:Xem báo cáo kinh doanh theo khách hàng');;
                Route::get('/customerSaleReportSearchData', 'Common\ReportController@customerSaleReportSearchData')->name('Report.customerSaleReportSearchData');
                Route::get('/customerSaleReportPrint', 'Common\ReportController@customerSaleReportPrint')->name('Report.customerSaleReportPrint');

                Route::get('/revenueReport', 'Common\ReportController@revenueReport')->name('Report.revenueReport')->middleware('checkPermission:Xem báo cáo thương hoa hồng');
                Route::get('/revenueReportSearchData', 'Common\ReportController@revenueReportSearchData')->name('Report.revenueReportSearchData')->middleware('checkPermission:Xem báo cáo thương hoa hồng');
                Route::post('/revenueReportSettlementUser', 'Common\ReportController@revenueReportSettlementUser')->name('Report.revenueReportSettlementUser');
                Route::get('/revenueReportPrint', 'Common\ReportController@revenueReportPrint')->name('Report.revenueReportPrint')->middleware('checkPermission:Xem báo cáo thương hoa hồng');
            });

            // Danh mục đơn vị
            Route::group(['prefix' => 'units', 'middleware' => 'checkType:' . User::QUAN_TRI_VIEN], function () {
                Route::get('/create', 'Common\UnitController@create')->name('Unit.create')->middleware('checkPermission:Thêm mới đơn vị');
                Route::post('/{id}/update', 'Common\UnitController@update')->name('Unit.update')->middleware('checkPermission:Cập nhật đơn vị');
                Route::post('/', 'Common\UnitController@store')->name('Unit.store')->middleware('checkPermission:Thêm mới đơn vị');
                Route::get('/', 'Common\UnitController@index')->name('Unit.index');
                Route::get('/{id}/edit', 'Common\UnitController@edit')->name('Unit.edit')->middleware('checkPermission:Cập nhật đơn vị tính');
                Route::get('/{id}/delete', 'Common\UnitController@delete')->name('Unit.delete')->middleware('checkPermission:Xóa đơn vị tính');
                Route::get('/searchData', 'Common\UnitController@searchData')->name('Unit.searchData');
                Route::get('/exportExcel', 'Common\UnitController@exportExcel')->name('Unit.exportExcel');
            });

            // Khách hàng
            Route::group(['prefix' => 'customers'], function () {
                Route::get('/create', 'Common\CustomerController@create')->name('Customer.create')->middleware('checkPermission:Thêm mới khách hàng');
                Route::post('/', 'Common\CustomerController@store')->name('Customer.store')->middleware('checkPermission:Thêm mới khách hàng');
                Route::get('/', 'Common\CustomerController@index')->name('Customer.index');
                Route::get('/{id}/edit', 'Common\CustomerController@edit')->name('Customer.edit')->middleware('checkPermission:Cập nhật khách hàng');
                Route::get('/{id}/delete', 'Common\CustomerController@delete')->name('Customer.delete')->middleware('checkPermission:Xóa khách hàng');
                Route::post('/{id}/update', 'Common\CustomerController@update')->name('Customer.update')->middleware('checkPermission:Cập nhật khách hàng');
                Route::get('/{id}/getDataForShow', 'Common\CustomerController@getDataForShow')->name('Customer.getDataForShow');
                Route::get('/{id}/getPoints', 'Common\CustomerController@getPoints')->name('Customer.getPoints');
                Route::get('/searchData', 'Common\CustomerController@searchData')->name('Customer.searchData');
                Route::get('/exportExcel', 'Common\CustomerController@exportExcel')->name('Customer.exportExcel');
                Route::get('/exportPDF', 'Common\CustomerController@exportPDF')->name('Customer.exportPDF');
            });
        });

        // Hãng xe
        Route::group(['prefix' => 'vehicle-manufacts', 'middleware' => 'checkType:' . User::SUPER_ADMIN . ',' . User::QUAN_TRI_VIEN], function () {
            Route::get('/create', 'Common\VehicleManufactController@create')->name('VehicleManufact.create')->middleware('checkPermission:Thêm mới hãng xe');
            Route::post('/', 'Common\VehicleManufactController@store')->name('VehicleManufact.store')->middleware('checkPermission:Thêm mới hãng xe');
            Route::get('/', 'Common\VehicleManufactController@index')->name('VehicleManufact.index');
            Route::get('/{id}/edit', 'Common\VehicleManufactController@edit')->name('VehicleManufact.edit')->middleware('checkPermission:Cập nhật hãng xe');
            Route::get('/{id}/delete', 'Common\VehicleManufactController@delete')->name('VehicleManufact.delete')->middleware('checkPermission:Xóa hãng xe');
            Route::post('/{id}/update', 'Common\VehicleManufactController@update')->name('VehicleManufact.update')->middleware('checkPermission:Cập nhật hãng xe');
            Route::get('/searchData', 'Common\VehicleManufactController@searchData')->name('VehicleManufact.searchData');
            Route::get('/exportExcel', 'Common\VehicleManufactController@exportExcel')->name('VehicleManufact.exportExcel');
        });
        // Loại xe
        Route::group(['prefix' => 'vehicle-types', 'middleware' => 'checkType:' . User::SUPER_ADMIN . ',' . User::QUAN_TRI_VIEN], function () {
            Route::get('/create', 'Common\VehicleTypeController@create')->name('VehicleType.create')->middleware('checkPermission:Thêm mới loại xe');
            Route::post('/', 'Common\VehicleTypeController@store')->name('VehicleType.store')->middleware('checkPermission:Thêm mới loại xe');
            Route::get('/', 'Common\VehicleTypeController@index')->name('VehicleType.index');
            Route::get('/{id}/edit', 'Common\VehicleTypeController@edit')->name('VehicleType.edit')->middleware('checkPermission:Cập nhật loại xe');
            Route::get('/{id}/delete', 'Common\VehicleTypeController@delete')->name('VehicleType.delete')->middleware('checkPermission:Xóa loại xe');
            Route::post('/{id}/update', 'Common\VehicleTypeController@update')->name('VehicleType.update')->middleware('checkPermission:Cập nhật loại xe');
            Route::get('/searchData', 'Common\VehicleTypeController@searchData')->name('VehicleType.searchData');
            Route::get('{id}/getDataForEdit', 'Common\VehicleTypeController@getDataForEdit')->name('VehicleType.getDataForEdit');
            Route::get('/exportExcel', 'Common\VehicleTypeController@exportExcel')->name('VehicleType.exportExcel');
            Route::get('/exportPDF', 'Common\VehicleTypeController@exportPDF')->name('VehicleType.exportPDF');
        });
        // Dòng xe
        Route::group(['prefix' => 'vehicle-categories', 'middleware' => 'checkType:' . User::SUPER_ADMIN . ',' . User::QUAN_TRI_VIEN], function () {
            Route::get('/create', 'Common\VehicleCategoryController@create')->name('VehicleCategory.create')->middleware('checkPermission:Thêm mới dòng xe');
            Route::post('/', 'Common\VehicleCategoryController@store')->name('VehicleCategory.store')->middleware('checkPermission:Thêm mới dòng xe');
            Route::get('/', 'Common\VehicleCategoryController@index')->name('VehicleCategory.index');
            Route::get('/{id}/edit', 'Common\VehicleCategoryController@edit')->name('VehicleCategory.edit')->middleware('checkPermission:Cập nhật dòng xe');
            Route::get('/{id}/delete', 'Common\VehicleCategoryController@delete')->name('VehicleCategory.delete')->middleware('checkPermission:Xóa dòng xe');
            Route::post('/{id}/update', 'Common\VehicleCategoryController@update')->name('VehicleCategory.update')->middleware('checkPermission:Cập nhật dòng xe');
            Route::get('/searchData', 'Common\VehicleCategoryController@searchData')->name('VehicleCategory.searchData');
            Route::get('/exportExcel', 'Common\VehicleCategoryController@exportExcel')->name('VehicleCategory.exportExcel');
            Route::get('/exportPDF', 'Common\VehicleCategoryController@exportPDF')->name('VehicleCategory.exportPDF');
        });

        // Nhóm khách hàng
        Route::group(['prefix' => 'customer-groups', 'middleware' => 'checkType:' . User::SUPER_ADMIN . ',' . User::QUAN_TRI_VIEN], function () {
            Route::get('/create', 'Common\CustomerGroupController@create')->name('CustomerGroup.create')->middleware('checkPermission:Thêm mới nhóm khách hàng');
            Route::post('/', 'Common\CustomerGroupController@store')->name('CustomerGroup.store')->middleware('checkPermission:Thêm mới nhóm khách hàng');
            Route::get('/', 'Common\CustomerGroupController@index')->name('CustomerGroup.index');
            Route::get('/{id}/edit', 'Common\CustomerGroupController@edit')->name('CustomerGroup.edit')->middleware('checkPermission:Cập nhật nhóm khách hàng');
            Route::get('/{id}/delete', 'Common\CustomerGroupController@delete')->name('CustomerGroup.delete')->middleware('checkPermission:Xóa nhóm khách hàng');
            Route::post('/{id}/update', 'Common\CustomerGroupController@update')->name('CustomerGroup.update')->middleware('checkPermission:Cập nhật nhóm khách hàng');
            Route::get('/searchData', 'Common\CustomerGroupController@searchData')->name('CustomerGroup.searchData');
            Route::get('/exportExcel', 'Common\CustomerGroupController@exportExcel')->name('CustomerGroup.exportExcel');
            Route::get('/exportPDF', 'Common\CustomerGroupController@exportPDF')->name('CustomerGroup.exportPDF');
        });

        // Route Tỉnh >> Huyện >> Xã
        Route::group(['prefix' => 'locations'], function () {
            Route::get('/{id}/districts', 'Common\LocationController@getDistricts')->name('getDistricts');
            Route::get('/{id}/wards', 'Common\LocationController@getWards')->name('getWards');
        });
    });
});

// route frontend 2
require(base_path() . '/routes/front/web.php');
