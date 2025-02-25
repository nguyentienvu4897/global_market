@extends('site.layouts.master')
@section('title')
    Quản lý hoa hồng
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
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('libs/datepicker/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/sweetalert/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('libs/angularjs/select.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.4.5/select2.css">

    <style>
        .table-responsive .form-control {
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px) !important;
            min-height: 38px !important;
            padding: 0 15px !important;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #ffffff;
            background-clip: padding-box;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem;
            box-shadow: inset 0 0 0 rgba(0, 0, 0, 0);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .table-responsive .select2-container .select2-selection--single {
            line-height: 1.5 !important;
            height: calc(2.25rem + 2px) !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 2.5 !important;
        }
        .select2-search--dropdown .select2-search__field {
            padding: 0 !important;
        }
        .select2-results__option {
            font-size: 14px !important;
        }
        .table-responsive .btn {
            height: 38px !important;
            line-height: 38px !important;
            padding: 0 12px !important;
            border-radius: 5px !important;
        }
        .table-responsive .btn.btn-success {
            background-color: #0974ba !important;
            color: #fff !important;
        }
        .table-responsive .btn.btn-danger {
            background-color: #f44336 !important;
            color: #fff !important;
        }
        .table-responsive .btn.btn-info {
            background-color: #0974ba !important;
            color: #fff !important;
        }
        .text-right {
            text-align: right !important;
        }
        .total-revenue {
            margin-bottom: 20px;
            background-color: #cccccc3d;
            padding: 20px;
            border-radius: 5px;
        }
        .total-revenue .total-revenue-item {
            font-size: 16px;
            font-weight: 600;
        }
        .total-revenue .total-revenue-item span {
            color: #0974ba;
            font-size: 18px;
        }
        .total-revenue .btn.btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
        }
        #modal-withdraw-money .modal-header .modal-title, #modal-check-order .modal-header .modal-title {
            font-size: 20px;
            font-weight: 600;
        }
        #modal-withdraw-money .modal-body .info-item, #modal-withdraw-money .modal-body label,
        #modal-check-order .modal-body .info-item, #modal-check-order .modal-body label {
            font-size: 16px;
            font-weight: 600;
        }
        #modal-withdraw-money .modal-body .info-item span, #modal-check-order .modal-body .info-item span {
            color: #0974ba;
        }
        #modal-withdraw-money .modal-body .form-group input, #modal-check-order .modal-body .form-group input {
            margin-bottom: 0px !important;
            padding: 0 15px !important;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px !important;
        }
        #modal-withdraw-money .modal-body button, #modal-check-order .modal-body button {
            background-color: #28a745 !important;
            color: #fff !important;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px !important;
        }
        #modal-check-order .modal-body .info-item span .badge {
            color: #fff;
        }
        #modal-otp .otp-group {
            margin: 20px 0;
            text-align: center;
        }
        #modal-otp .otp-group .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        #modal-otp .otp-group .otp-inputs input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 20px;
            border: 1px solid #636363;
            border-radius: 5px;
            padding: 0 !important;
        }

        #modal-otp .countdown-text {
            text-align: center;
            position: relative;
            padding-top: 26px;
            margin-bottom: 60px;
        }
        #modal-otp .countdown-text span{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px;
            font-weight: 600;
            background-color: #6baedb4a;
            border: 1px solid #0974ba;
            padding: 6px;
            border-radius: 5px;
            width: 22%;
        }
        #modal-otp .btn-resend-otp {
            background-color: #6baedb;
            border: 1px solid #0974ba;
            padding: 0 16px;
            border-radius: 5px;
            color: #fff;
        }
        #modal-otp .btn-submit-otp {
            background-color: #28a745 !important;
            color: #fff !important;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px !important;
            float: right;
        }
    </style>

@endsection
@section('content')
    <div ng-controller="UserRevenueController" ng-cloak>
        <section class="signup page_customer_account">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="total-revenue">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="total-revenue-item">Tổng hoa hồng : <span class="revenue-amount"><% revenueAmount | number: 0 %>₫</span></div>
                                    <div class="total-revenue-item">Đã quyết toán : <span class="revenue-amount"><% quyetToanAmount | number: 0 %>₫</span></div>
                                    <div class="total-revenue-item">Chưa quyết toán (số dư) : <span class="revenue-amount"><% waitingQuyetToanAmount | number: 0 %>₫</span></div>

                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-success" ng-click="showWithdrawMoneyModal()">Rút tiền</button>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" ng-click="showCheckOrderModal()">Tra soát đơn hàng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 table-responsive">
                        <table id="table-list">
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal" id="modal-withdraw-money">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Phiếu yêu cầu rút tiền</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" style="display: flex; gap: 20px; font-size: 14px; font-style: italic; margin-bottom: 20px;">
                                    <div style="width: 100px;"><span style="color: red;">*</span> Lưu ý: </div>
                                    <div>
                                        <span>- Số tiền rút tối thiểu là 100.000 VNĐ</span><br>
                                        <span>- Nếu chưa có thông tin chuyển khoản, vui lòng quay lại trang thông tin tài khoản để cập nhật</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">Họ tên: <span><% currentUser.name %></span></div>
                                    <div class="info-item">Số điện thoại: <span><% currentUser.phone_number %></span></div>
                                    <div class="info-item">Email: <span><% currentUser.email %></span></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">Chủ tài khoản: <span><% currentUser.bank_account_name %></span></div>
                                    <div class="info-item">Số tài khoản: <span><% currentUser.bank_account_number %></span></div>
                                    <div class="info-item">Tên ngân hàng: <span><% currentUser.bank_name %></span></div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-4 form-group">
                                    <label for="amount">Số dư</label>
                                    <input type="text" class="form-control" id="amount" only-number decimal-upto="0" allow-decimal="false" ng-model="waitingQuyetToanAmount" disabled>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="withdraw-amount">Số tiền cần rút <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="withdraw-amount" ng-model="form.withdrawAmount" only-number decimal-upto="0" allow-decimal="false" ng-change="calculateRemainingAmount()">
                                    <div class="invalid-feedback d-block error" role="alert">
                                        <span ng-if="errors && errors.withdrawAmount">
                                            <% errors.withdrawAmount[0] %>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="remaining-amount">Số tiền còn lại</label>
                                    <input type="text" class="form-control" id="remaining-amount" only-number decimal-upto="0" allow-decimal="false" ng-model="form.remainingAmount" disabled>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-success" ng-click="withdrawMoney()" ng-disabled="isLoading">
                                        <span ng-if="!isLoading">Xác nhận rút tiền</span>
                                        <span ng-if="isLoading"><i class="fa fa-spinner fa-spin"></i> Đang xử lý...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="modal-check-order">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tra soát đơn hàng</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" style="font-size: 14px; font-style: italic; margin-bottom: 20px;">
                                    <div style="width: 100px;"><span style="color: red;">*</span> Lưu ý: </div>
                                    <div>
                                        <span>- Chức năng này chỉ sử dụng để kiểm tra đối soát lại đơn hàng affiliate</span><br>
                                        <span>- Vui lòng tra soát đơn hàng sau 24h kể từ khi đặt hàng</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="withdraw-amount">Mã đơn hàng <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" ng-model="formCheckOrder.order_code">
                                    <div class="invalid-feedback d-block error" role="alert">
                                        <span ng-if="errors && errors.order_code">
                                            <% errors.order_code[0] %>
                                        </span>
                                    </div>
                                    <div class="result-success" ng-if="resultCheckOrder">
                                        <div class="info-item" style="font-size: 16px; font-weight: 600; background-color: #28a74695; color: #fff; padding: 10px; border-radius: 5px; margin-bottom: 10px; margin-top: 20px;"><i class="fa fa-check-circle"></i> Kết quả tra soát thành công!</div>
                                        {{-- <div class="info-item">Mã đơn hàng: <span><% resultCheckOrder.code %></span></div> --}}
                                        <div class="info-item">Trạng thái đơn hàng: <span ng-bind-html="resultCheckOrder.status_text" style="color: #fff;"></span></div>
                                        <div class="info-item">Ngày đặt hàng: <span><% resultCheckOrder.aff_order_at | date_time %></span></div>
                                        <div class="info-item">Giá trị đơn hàng: <span><% resultCheckOrder.total_after_discount | number: 0 %>₫</span></div>
                                        <div class="info-item">Hoa hồng được tính: <span><% resultCheckOrder.revenue_amount | number: 0 %>₫</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-success" ng-click="submitCheckOrder()" ng-disabled="isLoading">
                                        <span ng-if="!isLoading">Tra soát</span>
                                        <span ng-if="isLoading"><i class="fa fa-spinner fa-spin"></i> Đang xử lý...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="modal-otp">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nhập mã OTP</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" style="font-size: 14px; font-style: italic; margin-bottom: 20px;">
                                    <div style="width: 100px;"><span style="color: red;">*</span> Lưu ý: </div>
                                    <div>
                                        <span>- Mã OTP đã được gửi đến email <span style="color: #0974ba;"><% currentUser.email %></span></span><br>
                                        <span>- Vui lòng kiểm tra email và nhập mã OTP để xác nhận</span>
                                    </div>
                                </div>
                            </div>

                            <div class="otp-group text-center">
                                <div class="otp-inputs">
                                    <input type="text" maxlength="1"
                                        ng-repeat="digit in otp track by $index"
                                        ng-model="otp[$index]"
                                        ng-keyup="moveToNext($event, $index)"
                                        ng-class="{'is-invalid': errors && errors.otp}">
                                </div>
                                <div class="invalid-feedback d-block error" role="alert">
                                    <span ng-if="errors && errors.otp">
                                        <% errors.otp %>
                                    </span>
                                </div>
                            </div>
                            <p class="countdown-text text-center"><span><% minutes %> : <% seconds < 10 ? '0' + seconds : seconds %></span></p>
                            <button class="btn btn-primary btn-resend-otp" ng-click="resendOTP()" ng-disabled="!canResend">
                                <span ng-if="!isLoadingResend">Gửi lại mã</span>
                                <span ng-if="isLoadingResend"><i class="fa fa-spinner fa-spin"></i> Đang gửi...</span>
                            </button>
                            <button class="btn btn-success btn-submit-otp" ng-click="submitOTP()" ng-disabled="isLoading">
                                <span ng-if="!isLoading">Xác nhận</span>
                                <span ng-if="isLoading"><i class="fa fa-spinner fa-spin"></i> Đang xử lý...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/datepicker.full.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('js/constant.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    <script src="{{ asset('js/custom.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    @include('partial.classes.base.Datatable')
    <script src="{{ asset('libs/angularjs/app.directive.js') }}"></script>

    <script>
        app.controller('UserRevenueController', function($scope, $interval) {

            let datatable = new DATATABLE('table-list', {
                ajax: {
                    url: '{{ route('front.user-revenue-search-data') }}',
                    data: function (d, context) {
                        DATATABLE.mergeSearch(d, context);
                    },
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
                    {data: 'order_code', title: 'Mã đơn hàng'},
                    {data: 'order_employee', title: 'Người đặt hàng', className: "text-left"},
                    {data: 'revenue_amount', title: 'Hoa hồng'},
                    {data: 'settlement_amount', title: 'Đã quyết toán'},
                    {data: 'remaining_amount', title: 'Còn lại'},
                    {data: 'status', title: 'Trạng thái'},
                    {data: 'created_at', title: 'Ngày đặt hàng'},
                    {data: 'settlement_date', title: 'Ngày quyết toán'},
                ],
                search_columns: [
                    {data: 'order_code', search_type: "text", placeholder: "Mã đơn hàng"},
                    {data: 'order_employee', search_type: "text", placeholder: "Người đặt hàng"},
                    {data: 'status', search_type: "select", placeholder: "Trạng thái", column_data: @json(\App\Model\Admin\OrderRevenueDetail::STATUSES)},
                    // {data: 'settlement_date', search_type: "date", placeholder: "Ngày quyết toán"},
                ],
                // search_by_time: true,
            }).datatable;

            $scope.currentUser = @json($user);
            $scope.revenueAmount = @json($revenue_amount);
            $scope.quyetToanAmount = @json($quyet_toan_amount);
            $scope.waitingQuyetToanAmount = @json($waiting_quyet_toan_amount);

            $scope.showWithdrawMoneyModal = function() {
                $('#modal-withdraw-money').modal('show');
            }
            $scope.form = {
                withdrawAmount: 0,
                remainingAmount: $scope.waitingQuyetToanAmount,
            }

            $scope.calculateRemainingAmount = function() {
                if (Number($scope.form.withdrawAmount) > Number($scope.waitingQuyetToanAmount)) {
                    $scope.form.withdrawAmount = $scope.waitingQuyetToanAmount; // Giới hạn giá trị

                    // Cập nhật lại view của input thông qua directive only-number
                    const inputElement = document.getElementById("withdraw-amount"); // ID của input
                    const ngModelCtrl = angular.element(inputElement).controller("ngModel");
                    ngModelCtrl.$setViewValue($scope.form.withdrawAmount);
                    ngModelCtrl.$render();
                }
                $scope.form.remainingAmount = $scope.waitingQuyetToanAmount - $scope.form.withdrawAmount;
                // Cập nhật lại view của input thông qua directive only-number
                const inputElementRemaining = document.getElementById("remaining-amount"); // ID của input
                const ngModelCtrlRemaining = angular.element(inputElementRemaining).controller("ngModel");
                ngModelCtrlRemaining.$setViewValue($scope.form.remainingAmount);
                ngModelCtrlRemaining.$render();
            }

            $scope.errors = {};

            $scope.otp = ["", "", "", "", "", ""];
            $scope.canResend = false;
            $scope.isLoadingResend = false;

            $scope.withdrawMoney = function() {
                let data = $scope.form;
                data.revenueAmount = $scope.revenueAmount;
                data.waitingQuyetToanAmount = $scope.waitingQuyetToanAmount;
                $scope.isLoading = true;
                $.ajax({
                    url: '{{ route('front.send-otp') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            $('#modal-otp').modal('show');
                            $('#modal-withdraw-money').modal('hide');
                            $scope.minutes = 5;
                            $scope.seconds = 0;
                            $scope.isLoadingResend = false;
                            $scope.canResend = false;
                            // Đếm ngược 5 phút
                            var countdown = $interval(function () {
                                if ($scope.minutes === 0 && $scope.seconds === 0) {
                                    $interval.cancel(countdown);
                                    $scope.canResend = true;
                                } else {
                                    if ($scope.seconds === 0) {
                                        $scope.minutes--;
                                        $scope.seconds = 59;
                                    } else {
                                        $scope.seconds--;
                                    }
                                }
                            }, 1000);
                        } else {
                            toastr.warning(response.message);
                            $scope.errors = response.errors;
                        }
                    },
                    error: function(response) {
                        toastr.error('Thao tác thất bại');
                    },
                    complete: function() {
                        $scope.isLoading = false;
                        $scope.$applyAsync();
                    }
                })
            }

            // Hàm chuyển ô nhập khi gõ số
            $scope.moveToNext = function (event, index) {
                var key = event.key;
                $scope.errors = {};
                if (key >= "0" && key <= "9") {
                var nextInput = document.querySelectorAll(".otp-inputs input")[index + 1];
                if (nextInput) nextInput.focus();
                } else if (key === "Backspace") {
                var prevInput = document.querySelectorAll(".otp-inputs input")[index - 1];
                if (prevInput) prevInput.focus();
                }
            };

            // Gửi lại OTP
            $scope.resendOTP = function () {
                $scope.isLoadingResend = true;
                $scope.withdrawMoney();
                $scope.otp = ["", "", "", "", "", ""];
                $scope.canResend = false;
            };

            $scope.submitOTP = function() {
                var otpCode = $scope.otp.join("");
                $scope.isLoading = true;
                if (otpCode.length === 6) {
                    $.ajax({
                        url: '{{ route('front.verify-otp') }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {otp: otpCode},
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                let data = $scope.form;
                                data.revenueAmount = $scope.revenueAmount;
                                data.waitingQuyetToanAmount = $scope.waitingQuyetToanAmount;
                                $scope.isLoading = true;
                                $.ajax({
                                    url: '{{ route('front.withdraw-money') }}',
                                    type: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: data,
                                    success: function(response) {
                                        if (response.success) {
                                            toastr.success(response.message);
                                            $('#modal-withdraw-money').modal('hide');
                                        } else {
                                            toastr.warning(response.message);
                                            $scope.errors = response.errors;
                                        }
                                    },
                                    error: function(response) {
                                        toastr.error('Thao tác thất bại');
                                    },
                                    complete: function() {
                                        $scope.isLoading = false;
                                        $scope.$applyAsync();
                                    }
                                })
                                $('#modal-otp').modal('hide');
                                $scope.otp = ["", "", "", "", "", ""];
                            } else {
                                $scope.errors = response.errors;
                            }
                        },
                        error: function(response) {
                            toastr.error('Thao tác thất bại');
                        },
                        complete: function() {
                            $scope.isLoading = false;
                            $scope.$applyAsync();
                        }
                    })
                } else {
                    $scope.isLoading = false;
                    toastr.warning('Vui lòng nhập đủ 6 số OTP');
                }
            }

            $scope.showCheckOrderModal = function() {
                $scope.formCheckOrder = {}
                $scope.resultCheckOrder = null;
                $scope.errors = {};
                $('#modal-check-order').modal('show');
            }

            $scope.formCheckOrder = {}
            $scope.resultCheckOrder = null;
            $scope.submitCheckOrder = function() {
                let data = $scope.formCheckOrder;
                $scope.isLoading = true;
                $.ajax({
                    url: '{{ route('front.check-order') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            // toastr.success(response.message);
                            // $('#modal-check-order').modal('hide');
                            $scope.errors = {};
                            $scope.resultCheckOrder = response.data;
                        } else {
                            toastr.warning(response.message);
                            $scope.errors = response.errors;
                        }
                    },
                    error: function(response) {
                        toastr.error('Thao tác thất bại');
                    },
                    complete: function() {
                        $scope.isLoading = false;
                        datatable.ajax.reload();
                        $scope.$applyAsync();
                    }
                })
            }
        })
    </script>
@endpush

