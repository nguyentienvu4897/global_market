<!-- Forms -->
<script type="text/ng-template" id="forms/banner-form.html">
    <div class="card">
        <div class="card-header">
            <h6>Ảnh bìa</h6>
            <span style="font-size: 14px; opacity: 0.5">(Kích thước: 1260x518px)</span>
        </div>
        <div class="card-body">
            <div class="img-chooser">
                <label for="<% selectedBlock.data.image.element_id %>">
                    <img ng-src="<% selectedBlock.data.image %>">
                    <input class="d-none" type="file" accept=".jpg,.png,.jpeg"
                        id="<% selectedBlock.data.image.element_id %>">
                </label>
            </div>
            <span class="invalid-feedback d-block" role="alert">
                <strong><% errors['banner'][0] %></strong>
            </span>
        </div>
    </div>
</script>

<script type="text/ng-template" id="forms/products-form.html">
    <label>Tiêu đề:</label>
    <input type="text" ng-model="selectedBlock.data.title" class="form-control"><br>
    <label>Số sản phẩm hiển thị:</label>
    <input type="number" ng-model="selectedBlock.data.limit" min="1" class="form-control">
</script>