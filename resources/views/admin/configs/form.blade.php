<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-8 col-xs-12">
				<div class="form-group custom-group">
					<label class="form-label required-label">Tiêu đề website</label>
					<input class="form-control" ng-model="form.web_title" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.web_title[0] %></strong>
					</span>
				</div>
                <div class="form-group custom-group">
                    <label class="form-label">Tên công ty viết gọn</label>
                    <input class="form-control" ng-model="form.short_name_company" type="text">
                    <span class="invalid-feedback d-block" role="alert">
						<strong><% errors.web_title[0] %></strong>
					</span>
                </div>
				<div class="form-group custom-group">
					<label class="form-label required-label">Số hotline</label>
					<input class="form-control" ng-model="form.hotline" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.hotline[0] %></strong>
					</span>
				</div>
                <div class="form-group custom-group">
                    <label class="form-label">Số tổng đài</label>
                    <input class="form-control" ng-model="form.phone_switchboard" type="text">
                </div>
				<div class="form-group custom-group">
					<label class="form-label required-label">Số Zalo</label>
					<input class="form-control" ng-model="form.zalo" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.zalo[0] %></strong>
					</span>
				</div>
                <div class="form-group custom-group">
                    <label class="form-label">Địa chỉ công ty</label>
                    <input class="form-control" ng-model="form.address_company" type="text">
                </div>
                <div class="form-group custom-group">
                    <label class="form-label">Địa chỉ sản xuất</label>
                    <input class="form-control" ng-model="form.address_center_insurance" type="text">
                </div>
                <div class="form-group custom-group">
                    <label class="form-label">Mã số thuế</label>
                    <input class="form-control" ng-model="form.tax_code" type="text">
                </div>
				<div class="form-group custom-group">
					<label class="form-label required-label">Email</label>
					<input class="form-control" ng-model="form.email" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.email[0] %></strong>
					</span>
				</div>
				<div class="form-group custom-group">
					<label class="form-label required-label">Fanpage Facebook</label>
					<input class="form-control" ng-model="form.facebook" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.facebook[0] %></strong>
					</span>
				</div>
                <div class="form-group custom-group">
                    <label class="form-label">Twitter</label>
                    <input class="form-control" ng-model="form.twitter" type="text">
                </div>
                <div class="form-group custom-group">
                    <label class="form-label">Instagram</label>
                    <input class="form-control" ng-model="form.instagram" type="text">
                </div>
                <div class="form-group custom-group">
                    <label class="form-label">Youtube</label>
                    <input class="form-control" ng-model="form.youtube" type="text">
                </div>
				<div class="form-group custom-group">
					<label class="form-label">Link map</label>
					<input class="form-control" ng-model="form.location" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.location[0] %></strong>
					</span>
				</div>
				{{-- <div class="form-group">
					<label class="form-label">Cấu hình phần trăm hoa hồng hệ thống</label>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group custom-group">
                                <label class="form-label">Người mua hàng (%)</label>
                                <input class="form-control" ng-model="form.revenue_percent_5" type="text">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group custom-group">
                                <label class="form-label">Cấp 4 (%)</label>
                                <input class="form-control" ng-model="form.revenue_percent_4" type="text">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group custom-group">
                                <label class="form-label">Cấp 3 (%)</label>
                                <input class="form-control" ng-model="form.revenue_percent_3" type="text">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group custom-group">
                                <label class="form-label">Cấp 2 (%)</label>
                                <input class="form-control" ng-model="form.revenue_percent_2" type="text">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group custom-group">
                                <label class="form-label">Cấp 1 (%)</label>
                                <input class="form-control" ng-model="form.revenue_percent_1" type="text">
                            </div>
                        </div>
                    </div>
				</div> --}}
				{{-- <div class="form-group">
					<label class="form-label">Tùy chọn khác</label>
					<div class="custom-control custom-checkbox">
						<input id="call" class="custom-control-input" type="checkbox" ng-model="form.click_call" ng-true-value="1" ng-false-value="0">
						<label for="call" class="custom-control-label">Click call</label>
					</div>
					<div class="custom-control custom-checkbox">
						<input id="face-chat" class="custom-control-input" type="checkbox" ng-model="form.facebook_chat"  ng-true-value="1" ng-false-value="0">
						<label for="face-chat" class="custom-control-label">Chatbox Facebook</label>
					</div>
					<div class="custom-control custom-checkbox">
						<input id="zalo-chat" class="custom-control-input" type="checkbox" ng-model="form.zalo_chat"  ng-true-value="1" ng-false-value="0">
						<label for="zalo-chat" class="custom-control-label">Zalo chat</label>
					</div>
				</div> --}}
				<div class="form-group custom-group">
					<label class="form-label required-label">Mô tả web</label>
					<textarea id="my-textarea" class="form-control" ng-model="form.web_des" rows="3"></textarea>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.web_des[0] %></strong>
					</span>
				</div>
                <div class="form-group custom-group">
                    <label class="form-label">Bài viết giới thiệu</label>
                    <textarea class="form-control ck-editor" ck-editor rows="5" ng-model="form.introduction"></textarea>
                </div>
			</div>
			<div class="col-md-4 col-xs-12">
				<div class="form-group text-center mb-4">
					<label class="form-label required-label">Logo</label>
					<div class="main-img-preview">
						<p class="help-block-img">* Ảnh định dạng: jpg, png không quá 1MB.</p>
						<img class="thumbnail img-preview" ng-src="<% form.image.path %>">
					</div>
					<div class="input-group" style="width: 100%; text-align: center">
						<div class="input-group-btn" style="margin: 0 auto">
							<div class="fileUpload fake-shadow cursor-pointer">
								<label class="mb-0" for="<% form.image.element_id %>">
									<i class="glyphicon glyphicon-upload"></i> Chọn ảnh
								</label>
								<input class="d-none" id="<% form.image.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
							</div>
						</div>
					</div>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.image[0] %></strong>
					</span>
				</div>

                <div style=""></div>

                <div class="form-group text-center mb-4">
                    <label class="form-label required-label">Favicon</label>
                    <div class="main-img-preview">
                        <p class="help-block-img">* Ảnh định dạng: jpg, png không quá 1MB, kích thước 16x16 </p>
                        <img class="thumbnail img-preview" ng-src="<% form.favicon.path %>">
                    </div>
                    <div class="input-group" style="width: 100%; text-align: center">
                        <div class="input-group-btn" style="margin: 0 auto">
                            <div class="fileUpload fake-shadow cursor-pointer">
                                <label class="mb-0" for="<% form.favicon.element_id %>">
                                    <i class="glyphicon glyphicon-upload"></i> Chọn ảnh
                                </label>
                                <input class="d-none" id="<% form.favicon.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                    </div>
                    <span class="invalid-feedback d-block" role="alert">
						<strong><% errors.favicon[0] %></strong>
					</span>
                </div>


{{--                <div class="form-group text-center">--}}
{{--                    <label for="">Chứng nhận</label>--}}
{{--                    <div class="row gallery-area border">--}}
{{--                        <div class="col-md-4 p-2" ng-repeat="g in form.galleries">--}}
{{--                            <div class="gallery-item">--}}
{{--                                <button class="btn btn-sm btn-danger remove" ng-click="form.removeGallery($index)">--}}
{{--                                    <i class="fa fa-times mr-0"></i>--}}
{{--                                </button>--}}
{{--                                <div class="form-group">--}}
{{--                                    <div class="img-chooser" title="Chọn ảnh">--}}
{{--                                        <label for="<% g.image.element_id %>">--}}
{{--                                            <img ng-src="<% g.image.path %>">--}}
{{--                                            <input class="d-none" type="file" accept=".jpg,.png,.jpeg" id="<% g.image.element_id %>">--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <span class="invalid-feedback d-block" role="alert" ng-if="!errors['galleries.' + $index + '.image_obj']">--}}
{{--                                <strong>--}}
{{--                                    <% errors['galleries.' + $index + '.image' ][0] %>--}}
{{--                                </strong>--}}
{{--                            </span>--}}
{{--                                    <span class="invalid-feedback">--}}
{{--                                <strong>--}}
{{--                                    <% errors['galleries.' + $index + '.image_obj' ][0] %>--}}
{{--                                </strong>--}}
{{--                            </span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 p-2">--}}
{{--                            <label class="gallery-item d-flex align-items-center justify-content-center cursor-pointer" for="gallery-chooser">--}}
{{--                                <i class="fa fa-plus fa-2x text-secondary"></i>--}}
{{--                            </label>--}}
{{--                            <input class="d-none" type="file" accept=".jpg,.png,.jpeg" id="gallery-chooser" multiple>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <span class="invalid-feedback">--}}
{{--                <strong>--}}
{{--                    <% errors.galleries[0] %>--}}
{{--                </strong>--}}
{{--            </span>--}}
{{--                </div>--}}

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
</div>

<style>
    .gallery-item {
        padding: 5px;
        padding-bottom: 0;
        border-radius: 2px;
        border: 1px solid #bbb;
        min-height: 100px;
        height: 100%;
        position: relative;
    }

    .gallery-item .remove {
        position: absolute;
        top: 5px;
        right: 5px;
    }

    .gallery-item .drag-handle {
        position: absolute;
        top: 5px;
        left: 5px;
        cursor: move;
    }

    .gallery-item:hover {
        background-color: #eee;
    }

    .gallery-item .image-chooser img {
        max-height: 150px;
    }

    .gallery-item .image-chooser:hover {
        border: 1px dashed green;
    }
</style>
