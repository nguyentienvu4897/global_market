<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h6>Thông tin cơ bản</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tên shop</label>
                            <span class="text-danger">(*)</span>
                            <input class="form-control" type="text" ng-model="form.shop_name">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.shop_name[0] %></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tên doanh nghiệp (nếu có)</label>
                            <input class="form-control" type="text" ng-model="form.company_name">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.company_name[0] %></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Hotline</label>
                            <input class="form-control" type="text" ng-model="form.hotline">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.hotline[0] %></strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Số điện thoại</label>
                            <input class="form-control" type="text" ng-model="form.phone">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.phone[0] %></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Địa chỉ</label>
                            <input class="form-control" type="text" ng-model="form.address">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.address[0] %></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Facebook</label>
                            <input class="form-control" type="text" ng-model="form.facebook">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Instagram</label>
                            <input class="form-control" type="text" ng-model="form.instagram">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tiktok</label>
                            <input class="form-control" type="text" ng-model="form.tiktok">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Zalo</label>
                            <input class="form-control" type="text" ng-model="form.zalo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Youtube</label>
                            <input class="form-control" type="text" ng-model="form.youtube">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h6>Logo cửa hàng </h6>
                <span style="font-size: 14px; opacity: 0.5">(Kích thước: 320x320px)</span>
            </div>
            <div class="card-body">
                <div class="img-chooser">
                    <label for="<% form.logo.element_id %>">
                        <img ng-src="<% form.logo.path %>">
                        <input class="d-none" type="file" accept=".jpg,.png,.jpeg"
                            id="<% form.logo.element_id %>">
                    </label>
                </div>
                <span class="invalid-feedback d-block" role="alert">
                    <strong><% errors['logo'][0] %></strong>
                </span>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6>Ảnh bìa</h6>
                <span style="font-size: 14px; opacity: 0.5">(Kích thước: 1260x518px)</span>
            </div>
            <div class="card-body">
                <div class="img-chooser">
                    <label for="<% form.banner.element_id %>">
                        <img ng-src="<% form.banner.path %>">
                        <input class="d-none" type="file" accept=".jpg,.png,.jpeg"
                            id="<% form.banner.element_id %>">
                    </label>
                </div>
                <span class="invalid-feedback d-block" role="alert">
                    <strong><% errors['banner'][0] %></strong>
                </span>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="text-right">
    <button type="submit" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
        <i ng-if="!loading.submit" class="fa fa-save"></i>
        <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
        Lưu
    </button>
    <a href="{{ route('User.index') }}" class="btn btn-danger btn-cons">
        <i class="fa fa-remove"></i> Hủy
    </a>
</div>
