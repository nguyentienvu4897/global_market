<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label required-label">Tên khách hàng</label>
                    <input class="form-control " type="text" ng-model="form.name">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.name[0] %></strong>
                    </span>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label">Nội dung phản hồi</label>
                    <textarea id="my-textarea" class="form-control" ng-model="form.message" rows="3"></textarea>
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.message[0] %></strong>
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>
