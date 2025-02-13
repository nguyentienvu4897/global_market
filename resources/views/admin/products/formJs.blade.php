$scope.loading = {};
$scope.getFileName = getFileName;
$scope.config = @json($config);

$(document).on('change', '#gallery-chooser', function(e) {
    Array.from(this.files).forEach(file => {
        let item = $scope.form.addGallery({});
        console.log(item);
        setTimeout(() => {
            let e = document.getElementById(item.image.element_id);
            let dataTransfer = new DataTransfer()
            dataTransfer.items.add(file)
            e.files = dataTransfer.files
            $(e).trigger('change');
        })
    });
    $scope.$apply();
})


$scope.addition_attachments = [];

$scope.addFile = function() {
if (!$scope.addition_attachments) $scope.addition_attachments = [];
$scope.addition_attachments.push({});
}

$scope.removeFile = function(index) {
$scope.addition_attachments.splice(index, 1);
}

$(document).on('change', '.attachments', function (e) {
let index = $(this).data('index');
let filename = e.target.files[0].name;
$scope.addition_attachments[index].name = filename;
$scope.$apply();
})

$scope.checkHasRevenuePercent = true;
if(Number($scope.form.revenue_percent_5) == 0 && Number($scope.form.revenue_percent_4) == 0 && Number($scope.form.revenue_percent_3) == 0 && Number($scope.form.revenue_percent_2) == 0 && Number($scope.form.revenue_percent_1) == 0) {
    $scope.checkHasRevenuePercent = false;
}

if(!$scope.form.revenue_percent_5 || !$scope.checkHasRevenuePercent) {
    $scope.form.revenue_percent_5 = $scope.config.revenue_percent_5;
}
if(!$scope.form.revenue_percent_4 || !$scope.checkHasRevenuePercent) {
    $scope.form.revenue_percent_4 = $scope.config.revenue_percent_4;
}
if(!$scope.form.revenue_percent_3 || !$scope.checkHasRevenuePercent) {
    $scope.form.revenue_percent_3 = $scope.config.revenue_percent_3;
}
if(!$scope.form.revenue_percent_2 || !$scope.checkHasRevenuePercent) {
    $scope.form.revenue_percent_2 = $scope.config.revenue_percent_2;
}
if(!$scope.form.revenue_percent_1 || !$scope.checkHasRevenuePercent) {
    $scope.form.revenue_percent_1 = $scope.config.revenue_percent_1;
}

