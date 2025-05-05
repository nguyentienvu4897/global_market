@extends('layouts.main')

@section('css')
@endsection

@section('title')
    Cập nhật thông tin cơ bản
@endsection

@section('content')
<div ng-controller="SellerStore" ng-cloak>
	@include('admin.seller_stores.form')
</div>

@endsection

@section('script')
@include('admin.seller_stores.SellerStore')
<script>
app.controller('SellerStore', function ($scope, $http) {
	$scope.form = new SellerStore(@json($object), {scope: $scope});
    $scope.loading = {
        submit: false
    };

	@include('admin.seller_stores.formJs')

	$scope.submit = function() {
		$scope.loading.submit = true;
		let data = $scope.form.submit_data;
		$.ajax({
			type: 'POST',
			url: "{!! route('seller-stores.update', $object->id) !!}",
			headers: {
				'X-CSRF-TOKEN': CSRF_TOKEN
			},
			processData: false,
			contentType: false,
			data: data,
			success: function(response) {
				if (response.success) {
					toastr.success(response.message);
					window.location.href = "{{ route('seller-stores.index') }}";
				} else {
					toastr.warning(response.message);
					$scope.errors = response.errors;
				}
			},
			error: function(e) {
				toastr.error('Đã có lỗi xảy ra');
			},
			complete: function() {
				$scope.loading.submit = false;
				$scope.$applyAsync();
			}
		});
	}

});
</script>
@endsection
