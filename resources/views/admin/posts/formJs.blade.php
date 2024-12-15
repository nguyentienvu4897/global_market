$scope.loading = {};

let product_options = {
    title: "Vật tư",
    ajax: {
        url: "{!! route('Product.searchData') !!}",
        data: function (d, context) {
            DATATABLE.mergeSearch(d, context);
            d.status = 1;
        }
    },
    columns: [
        {data: 'DT_RowIndex', orderable: false, title: "STT"},
        {data: 'name', title: "Tên vật tư"},
        {data: 'category', title: "Loại vật tư"},
        {data: 'created_by', title: "Người tạo"},
        {data: 'created_at', title: "Ngày tạo"},
    ],
    search_columns: [
        {data: 'name', search_type: "text", placeholder: "Tên vật tư"},
        {
            data: 'product_category_id', search_type: "select", placeholder: "Loại vật tư",
            column_data: @json(\App\Model\Common\ProductCategory::getForSelect())
        }
    ]
};

$scope.searchProduct = new BaseSearchModal(
    product_options,
    function(obj) {
        $scope.chooseProduct(obj);
    }
);

$scope.searchVehicleCategoryProductModal = new BaseSearchModal(
    product_options,
    function(obj) {
        $scope.chooseVehicleCategoryProduct(obj);
    }
);

$scope.chooseProduct = function(obj) {
    sendRequest({
        type: 'GET',
        url: `/common/products/${obj.id}/getData`,
        success: function(response) {
            if (response.success) {
                $scope.form.addProduct(response.data);
                toastr.success('Thêm thành công');
                $scope.$applyAsync();
            }
        }
    });
}

$scope.searchVehicleCategoryProduct = function(v) {
    $scope.currentVehicleCategory = v;
    $scope.searchVehicleCategoryProductModal.open();
}

$scope.chooseVehicleCategoryProduct = function(obj) {
    if (!$scope.currentVehicleCategory) return;
    sendRequest({
        type: 'GET',
        url: `/common/products/${obj.id}/getData`,
        success: function(response) {
            if (response.success) {
                $scope.currentVehicleCategory.addProduct(response.data);
                toastr.success('Thêm thành công');
                $scope.$applyAsync();
            }
        }
    });
}
