@extends('layouts.main')

@section('css')
@endsection

@section('title')
    Quản lý dự án
@endsection

@section('page_title')
    Quản lý dự án
@endsection

@section('content')
    <div  ng-cloak>
        <div class="row" ng-controller="Posts">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="table-list">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let datatable = new DATATABLE('table-list', {
            ajax: {
                url: '{!! route('Project.searchData') !!}',
                data: function (d, context) {
                    DATATABLE.mergeSearch(d, context);
                }
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, title: "STT"},
                {data: 'title',title: 'Tên dự án'},
                {data: 'address', title: 'Địa điểm'},
                {data: 'created_at', title: "Ngày cập nhật"},
                {data: 'updated_by', title: "Người cập nhật"},
                {
                    data: 'image', title: "Hình ảnh", orderable: false, className: "text-center",
                    render: function (data) {
                        return `<img src="${data.path}" style="max-width: 55px !important">`;
                    }
                },
                {data: 'action', orderable: false, title: "Hành động"}
            ],
            search_columns: [
                {data: 'title', search_type: "text", placeholder: "Tên dự án"},
            ],
            search_by_time: false,
            @if(Auth::guard('admin')->user()->type == App\Model\Common\User::SUPER_ADMIN || Auth::guard('admin')->user()->type == App\Model\Common\User::QUAN_TRI_VIEN)
            create_link: "{{ route('Project.create') }}"
            @endif
        }).datatable;

        app.controller('Posts', function ($scope, $rootScope, $http) {

            $scope.categorieSpeicals = @json(\App\Model\Admin\CategorySpecial::getForSelectForPost());
            $scope.arrayInclude = arrayInclude;
            $scope.loading = {};
        })
    </script>
    @include('partial.confirm')
@endsection
