<?php


Route::group(['namespace' => 'Front'], function () {
    Route::group(['prefix' => 'client'], function () {
        Route::get('/login-client','ClientRegisterController@loginClient')->name('front.login-client');
        Route::post('/login-client','ClientRegisterController@loginClientSubmit')->name('front.login-client-submit');
        Route::post('/register-client','ClientRegisterController@registerClientSubmit')->name('front.register-client-submit');
        Route::get('/logout-client','ClientRegisterController@logoutClient')->name('front.logout-client');
        Route::middleware('auth:client')->group(function () {
            Route::get('/account', 'ClientRegisterController@account')->name('front.client-account');
            Route::get('/update-invite-code','ClientRegisterController@updateInviteCode')->name('front.update-invite-code');
            Route::get('/quan-ly-don-hang','ClientRegisterController@userOrder')->name('front.user-order');
            Route::get('/quan-ly-don-hang/search-data','ClientRegisterController@userOrderSearchData')->name('front.user-order-search-data');
            Route::get('/quan-ly-don-hang/cancel-order','ClientRegisterController@cancelOrder')->name('front.cancel-order');
            Route::get('/quan-ly-don-hang/{id}/xem-chi-tiet','ClientRegisterController@showOrderDetail')->name('front.show-order-detail');
            Route::get('/quan-ly-cap-bac','ClientRegisterController@userLevel')->name('front.user-level');
            Route::get('/bao-cao-hoa-hong','ClientRegisterController@userRevenue')->name('front.user-revenue');
            Route::get('/bao-cao-hoa-hong/search-data','ClientRegisterController@userRevenueSearchData')->name('front.user-revenue-search-data');
            Route::post('/{id}/update', 'ClientRegisterController@updateAccount')->name('front.client-update');
            Route::post('/{id}/change-password', 'ClientRegisterController@changePassword')->name('front.client-change-password');
        });
    });

    Route::get('/','FrontController@homePage')->name('front.home-page');
    Route::get('/san-pham/{productSlug}.html','FrontController@showProductDetail')->name('front.show-product-detail');
    // Route::get('/load-product-home-page','FrontController@loadProductHomePage')->name('front.load-product-home-page');
    Route::get('/danh-muc/{categorySlug}.html','FrontController@showProductCategory')->name('front.show-product-category');
    Route::get('/load-more/product','FrontController@loadMoreProduct')->name('front.product-load-more');
    Route::get('/get-product-quick-view','FrontController@getProductQuickView')->name('front.get-product-quick-view');

    // giỏ hàng
    Route::middleware('auth:client')->group(function () {
        Route::post('/{productId}/add-product-to-cart','CartController@addItem')->name('cart.add.item');
        Route::get('/remove-product-to-cart','CartController@removeItem')->name('cart.remove.item');
        Route::get('/gio-hang.html','CartController@index')->name('cart.index');
        Route::post('/update-cart','CartController@updateItem')->name('cart.update.item');
        Route::get('/thanh-toan.html','CartController@checkout')->name('cart.checkout');
        Route::post('/checkout','CartController@checkoutSubmit')->name('cart.submit.order');
        Route::get('/dat-hang-thanh-cong.html','CartController@checkoutSuccess')->name('cart.checkout.success');
        Route::post('/apply-voucher','CartController@applyVoucher')->name('cart.apply.voucher');
    });

    // Liên hệ
    Route::get('/dang-ky-cong-tac-vien.html','FrontController@connectUs')->name('front.connect-us');
    Route::get('/lien-he.html','FrontController@contactUs')->name('front.contact-us');
    Route::post('/lien-he','FrontController@postContact')->name('front.post-contact');

    // Blogs
    Route::get('/gioi-thieu.html','FrontController@aboutUs')->name('front.about-us');
    Route::get('/tin-tuc.html','FrontController@indexBlog')->name('front.index-blog');
    Route::get('/tin-tuc/{slug}.html','FrontController@listBlog')->name('front.list-blog');
    Route::get('/chi-tiet-tin-tuc/{slug}.html','FrontController@detailBlog')->name('front.detail-blog');

    // Tìm kiếm
    Route::post('/auto-search-complete','FrontController@autoSearchComplete')->name('front.auto-search-complete');
    Route::get('/search','FrontController@search')->name('front.search');


    // reset data
    Route::get('/reset-data','FrontController@resetData')->name('front.resetData');

    // laster buy products
    Route::get('/laster-buy-products','FrontController@lasterBuyProducts')->name('front.laster-buy-products');

    // review
    Route::post('/review/submit','FrontController@submitReview')->name('front.submit-review');

});



