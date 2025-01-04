@extends('site.layouts.master')
@section('title')
    Chi tiết đơn hàng
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
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/css/custom_datatables.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/sweetalert/css/sweetalert.css') }}">

    <style>
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6 !important;
        }
        .text-right {
            text-align: right !important;
        }

        .table-bordered th, .table-bordered td {
            padding: 10px !important;
        }
        .table-bordered th {
            background-color: #f8f9fa !important;
        }
        .show-order-detail .btn.btn-danger {
            background-color: #f44336 !important;
            color: #fff !important;
        }
    </style>

@endsection
@section('content')
    <div ng-controller="UserOrderDetailController" ng-cloak>
        <section class="signup page_customer_account show-order-detail">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Chi tiết đơn hàng</h3>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Mã đơn hàng: <% form.code %> </label>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Địa chỉ giao hàng: <% form.customer_address %> </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tổng tiền: <% form.total_price | number %></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Phương thức thanh toán: <% form.payment_method_name %></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Trạng thái: <% getStatus(form.status) %></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Yêu cầu khác: </label>
                                    <textarea id="my-textarea" class="form-control" rows="2" style="height: 50px; min-height: 50px !important; padding: 0 15px;"><% form.customer_required %></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px">
                        <table class="table table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th><b>STT</b></th>
                                <th><b>Tên hàng hóa</b></th>
                                <th><b>Phân loại</b></th>
                                <th><b>Giá tiền</b></th>
                                <th><b>Số lượng đặt mua</b></th>
                                <th><b>Thành tiền</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="detail in form.details track by $index">
                                <td class="text-center"><% $index + 1 %></td>
                                <td class="text-center"><% detail.product.name %></td>
                                <td class="text-center">
                                    <div ng-repeat="attribute in detail.attributes">
                                        <% attribute.name %> : <span style="font-weight: 600; font-size: 14px;"><% attribute.value %></span>
                                    </div>
                                </td>
                                <td class="text-center"><% detail.product.price | number %></td>
                                <td class="text-center"><% detail.qty | number %></td>
                                <td class="text-right"><% (detail.qty * detail.price) | number %></td>

                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><b>Tổng thành tiền: </b></td>
                                <td class="text-right"><b><% form.total_before_discount | number %></b></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><b>Giảm giá: </b><br>
                                    <span ng-if="form.discount_code" class="text-danger">
                                        <i class="fa fa-tag"></i> <% form.discount_code ? 'Voucher: ' + form.discount_code : '' %>
                                    </span>
                                </td>
                                <td class="text-right"><b><% form.discount_value | number %></b></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><b>Thành tiền sau giảm: </b></td>
                                <td class="text-right"><b><% form.total_after_discount | number %></b></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 text-right">
                        <a href="{{ route('front.user-order') }}" class="btn btn-danger btn-cons">
                            <i class="fa fa-remove"></i> Hủy đơn hàng
                        </a>
                        <a href="{{ route('front.user-order') }}" class="btn btn-danger btn-cons">
                            <i class="fa fa-remove"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    @include('partial.classes.base.BaseClass')
    @include('admin.orders.Order')
    <script>
        app.controller('UserOrderDetailController', function($scope) {
            $scope.form = new Order(@json($order), {scope: $scope});
            $scope.statuses = @json(\App\Model\Admin\Order::STATUSES);
            $scope.$applyAsync();

            $scope.getStatus = function (status) {
                let obj = $scope.statuses.find(val => val.id == status);
                return obj.name;
            }

            $('#table-list').on('click', '.show-order-client', function () {
                event.preventDefault();
                $scope.data = datatable.row($(this).parents('tr')).data();
                console.log($scope.data);
                $scope.form.status = $scope.data.status;
                $scope.$apply();
                $('#update-status').modal('show');
            });
        })
    </script>
@endpush
