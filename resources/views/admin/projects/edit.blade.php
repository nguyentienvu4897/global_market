@extends('layouts.main')

@section('css')

@endsection

@section('title')
Chỉnh sửa dự án
@endsection

@section('page_title')
Chỉnh sửa dự án
@endsection

@section('content')
<div ng-controller="Project" ng-cloak>
  @include('admin.projects.form')
</div>
@endsection
@section('script')
    @include('admin.projects.Project')
<script>
  app.controller('Project', function ($scope, $http) {
    $scope.form = new Project(@json($object), {scope: $scope});
      $scope.loading = {};
      $scope.submit = function(publish = 0) {
      $scope.loading.submit = true;
      let data = $scope.form.submit_data;
      data.append('publish', publish);
      $.ajax({
        type: 'POST',
        url: "{!! route('Project.update', $object->id) !!}",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            window.location.href = "{{ route('Project.index') }}";
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
