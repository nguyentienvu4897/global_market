@extends('site.layouts.master')
@section('title')
    Quản lý cấp bậc
@endsection
@section('description')
    {{ $config->web_des }}
@endsection
@section('image')
@endsection
@section('css')
    <link href="{{ asset('site/css/account_oder_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('site/css/breadcrumb_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <!-- DataTables -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('site/css/custom_datatables.css') }}">

@endsection
@section('content')
    <div ng-controller="UserLevelController" ng-cloak>
        <section class="signup page_customer_account">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="table-list">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Cấp bậc</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat-start="(index, user) in users track by $index" style="font-size: 18px; font-weight: 600;">
                                    <td><% $index + 1 %></td>
                                    <td><% user.name %></td>
                                    <td><% user.email %></td>
                                    <td><% user.phone %></td>
                                    <td>Cấp 1</td>
                                </tr>
                                    <tr ng-repeat-start="(index1, user1) in user.childs track by $index" style="font-size: 15px;">
                                        <td><% index + 1 %>.<% index1 + 1 %></td>
                                        <td><% user1.name %></td>
                                        <td><% user1.email %></td>
                                        <td><% user1.phone %></td>
                                        <td>Cấp 2</td>
                                    </tr>
                                        <tr ng-repeat-start="(index2, user2) in user1.childs track by $index" style="font-size: 15px;">
                                            <td><% index + 1 %>.<% index1 + 1 %>.<% index2 + 1 %></td>
                                            <td><% user2.name %></td>
                                            <td><% user2.email %></td>
                                            <td><% user2.phone %></td>
                                            <td>Cấp 3</td>
                                        </tr>
                                            <tr ng-repeat="(index3, user3) in user2.childs track by $index" style="font-size: 15px;">
                                                <td><% index + 1 %>.<% index1 + 1 %>.<% index2 + 1 %>.<% index3 + 1 %></td>
                                                <td><% user3.name %></td>
                                                <td><% user3.email %></td>
                                                <td><% user3.phone %></td>
                                                <td>Cấp 4</td>
                                            </tr>
                                        <tr ng-repeat-end></tr>
                                    <tr ng-repeat-end></tr>
                                <tr ng-repeat-end></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')

    <!-- DataTables -->
    {{-- <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/datepicker.full.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('js/constant.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    <script src="{{ asset('js/custom.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    @include('partial.classes.base.Datatable') --}}

    <script>
        app.controller('UserLevelController', function($scope) {
            $scope.users = @json($users);
        })
    </script>
@endpush
