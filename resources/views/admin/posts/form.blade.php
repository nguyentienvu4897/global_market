<div class="row">
	<div class="col-md-9 col-sm-8 col-xs-12">
		<div class="form-group custom-group mb-4">
            <label class="form-label required-label">Danh mục</label>
            <ui-select class="" remove-selected="true" ng-model="form.cate_id" theme="select2">
                <ui-select-match placeholder="Chọn danh mục">
                    <% $select.selected.name %>
                </ui-select-match>
                <ui-select-choices repeat="t.id as t in (form.all_categories | filter: $select.search)">
                    <span ng-bind="t.name"></span>
                </ui-select-choices>
            </ui-select>
            <span class="invalid-feedback d-block" role="alert">
                <strong><% errors.cate_id[0] %></strong>
            </span>
        </div>

		<div class="form-group custom-group mb-4">
			<label class="form-label required-label">Tiêu đề bài viết</label>
			<input class="form-control" ng-model="form.name" type="text">
			<span class="invalid-feedback d-block" role="alert">
				<strong><% errors.name[0] %></strong>
			</span>
		</div>
		<div class="form-group custom-group mb-4">
			<label class="form-label">Tóm tắt nội dung</label>
			<textarea id="my-textarea" class="form-control" ng-model="form.intro" rows="3"></textarea>
			<span class="invalid-feedback d-block" role="alert">
				<strong><% errors.intro[0] %></strong>
			</span>
		</div>
		<div class="form-group custom-group mb-4">
			<label class="form-label required-label">Nội dung bài viết</label>
			<textarea id="editor" class="form-control" ck-editor ng-model="form.body" rows="7"></textarea>
			<span class="invalid-feedback d-block" role="alert">
				<strong><% errors.body[0] %></strong>
			</span>
		</div>
	</div>
	<div class="col-md-3 col-sm-4 col-xs-12">
		<div class="form-group custom-group mb-4">
			<label class="form-label required-label">Trạng thái</label>
			<select id="my-select" class="form-control custom-select" ng-model="form.status">
				<option value="">Chọn trạng thái</option>
				<option ng-repeat="s in form.statuses" ng-value="s.id" ng-selected="form.status == s.id"><% s.name %></option>
			</select>
		</div>
		<div class="form-group text-center mb-4">
			<div class="main-img-preview">
				<p class="help-block-img">* Ảnh định dạng: jpg, png không quá 2MB.</p>
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

	</div>
</div>

<hr>
<div class="text-right">
	<button type="submit" class="btn btn-success btn-cons" ng-click="submit(0)" ng-disabled="loading.submit">
		<i ng-if="!loading.submit" class="fa fa-save"></i>
		<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
		Lưu
	</button>
	<a href="{{ route('Post.index') }}" class="btn btn-danger btn-cons">
		<i class="fa fa-remove"></i> Hủy
	</a>
</div>
