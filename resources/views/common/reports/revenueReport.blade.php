@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="{{ asset('libs/pagination/pagination.css') }}">
<style>
    #modal-settlement-user .info-item span {
        font-weight: 600;
        font-size: 16px;
        color: #1a79b8;
    }
</style>
@endsection

@section('title')
    Báo cáo thưởng hoa hồng
@endsection

@section('content')

<div ng-controller="RevenueReport" ng-cloak>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Bộ lọc</h4>
                </div>
                <div class="card-body">
                    <div class="row">
						<div class="col-md-3">
                            <div class="form-group custom-group">
                                <label>Từ ngày:</label>
                                <input class="form-control" date-form ng-model="form.from_date" theme="select2">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group custom-group">
                                <label>Đến ngày:</label>
                                <input class="form-control" date-form ng-model="form.to_date" theme="select2">
                            </div>
                        </div>
						<div class="col-md-3">
							<div class="form-group custom-group">
                                <label>Người dùng</label>
                                <ui-select remove-selected="false" ng-model="form.user_id" theme="select2">
									<ui-select-match placeholder="Chọn Khách hàng">
										<% $select.selected.name %>
									</ui-select-match>
									<ui-select-choices repeat="item.id as item in (users | filter: $select.search)">
										<span ng-bind="item.name"></span>
									</ui-select-choices>
								</ui-select>
                            </div>
						</div>
                    </div>
                    <hr>
                    <div class="text-right">

                        <button class="btn btn-primary" ng-click="filter(1)" ng-disabled="loading.search">
                            <i ng-if="!loading.search" class="fa fa-filter"></i>
                            <i ng-if="loading.search" class="fa fa-spinner fa-spin"></i>
                            Lọc
                        </button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Chi tiết</h4>
                </div>
                <div class="card-body">
                    <table class="table table-condensed table-bordered table-head-border">
						<thead class="sticky-thead">
							<tr>
								<th>STT</th>
                                <th>Họ tên</th>
								<th>Số điện thoại</th>
                                <th>Email</th>
								<th>Tổng hoa hồng chờ xử lý</th>
								<th>Tổng hoa hồng chờ quyết toán</th>
								<th>Tổng hoa hồng đã quyết toán</th>
								<th>Tổng hoa hồng</th>
								<th>Hành động</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-if="loading.search">
								<td colspan="9"><i class="fa fa-spin fa-spinner"></i> Đang tải dữ liệu</td>
							</tr>
							<tr ng-if="!loading.search && details && !details.length">
								<td colspan="9">Chưa có dữ liệu</td>
							</tr>
                            <tr ng-if="!loading.search && details && details.length">
								<td class="text-center" colspan="4"><b>Tổng cộng</b></td>
								<td class="text-right"><b><% (summary.total_amount_pending ? (summary.total_amount_pending | number) : '-') %></b></td>
								<td class="text-right"><b><% (summary.total_amount_wait_payment ? (summary.total_amount_wait_payment | number) : '-') %></b></td>
								<td class="text-right"><b><% (summary.total_amount_paid ? (summary.total_amount_paid | number) : '-') %></b></td>
								<td class="text-right"><b><% (summary.total_amount ? (summary.total_amount | number) : '-') %></b></td>
								<td></td>
							</tr>
							<tr ng-if="!loading.search && details && details.length" ng-repeat="d in details">
								<td class="text-center"><% $index + 1 + (current.page - 1) * per_page %></td>
                                <td><% d.name %></td>
								<td><% d.phone_number %></td>
								<td><% d.email %></td>
								<td class="text-right"><% (d.total_amount_pending ? (d.total_amount_pending | number) : '-') %></td>
								<td class="text-right"><% (d.total_amount_wait_payment ? (d.total_amount_wait_payment | number) : '-') %></td>
								<td class="text-right"><% (d.total_amount_paid ? (d.total_amount_paid | number) : '-') %></td>
								<td class="text-right"><% (d.total_amount ? (d.total_amount | number) : '-') %></td>
								<td class="text-center">
									<a href="javascript:void(0)" class="btn btn-success" title="Quyết toán" ng-click="settlementUser(d)" ng-if="d.total_amount_wait_payment > 0">
                                        Quyết toán
									</a>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="text-right mt-2">
						<ul uib-pagination ng-change="pageChanged()" total-items="total_items" ng-model="current.page" max-size="10"
							class="pagination-sm" boundary-links="true" items-per-page="per_page" previous-text="‹" next-text="›" first-text="«" last-text="»">
						</ul>
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-settlement-user">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Phiếu quyết toán</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
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
                            <label for="settlement-amount">Số tiền quyết toán <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="settlement-amount" ng-model="settlement.settlementAmount" only-number decimal-upto="0" allow-decimal="false" ng-change="calculateRemainingAmount()">
                            <div class="invalid-feedback d-block error" role="alert">
                                <span ng-if="errors && errors.settlementAmount">
                                    <% errors.settlementAmount[0] %>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="remaining-amount">Số tiền còn lại</label>
                            <input type="text" class="form-control" id="remaining-amount" only-number decimal-upto="0" allow-decimal="false" ng-model="settlement.remainingAmount" disabled>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" ng-click="submitSettlementUser()" ng-disabled="loading.submit">
                                <i ng-if="!loading.submit" class="fa fa-check"></i>
                                <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
                                Xác nhận quyết toán
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('libs/pagination/ui-bootstrap.min.js') }}"></script>
<script>
    angular.module("App").requires.push('ui.bootstrap');
    app.controller('RevenueReport', function ($scope) {
        $scope.form = {};
        $scope.loading = {};
		$scope.details = [];
		$scope.users = @json(App\Model\Common\User::getForSelectUserClients());

        let draw = 0;
        $scope.current = {
            page: 1
        };
        $scope.per_page = 10;
        $scope.total_items = 0;
        $scope.loading = {
            search: false
        };
        $scope.summary = {};

		$scope.filter = function(page = 1) {
			draw++;
			$scope.current.page = page;
			$scope.loading.search = true;
			$.ajax({
                type: 'GET',
                url: "{{ route('Report.revenueReportSearchData') }}",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: {
					...$scope.form,
					per_page: $scope.per_page,
					current_page: $scope.current.page,
					draw: draw
				},
                success: function(response) {
                    if (response.success && response.draw == draw) {
						$scope.details = response.data.data;
                        $scope.details.map(d => {
                            d.total_amount = Number(d.total_amount_pending) + Number(d.total_amount_wait_payment) + Number(d.total_amount_paid);
                            return d;
                        });
						$scope.total_items = response.data.total;
						$scope.current.page = response.data.current_page;
						$scope.summary = {
                            total_amount_pending: $scope.details.reduce((sum, d) => sum + Number(d.total_amount_pending), 0),
                            total_amount_wait_payment: $scope.details.reduce((sum, d) => sum + Number(d.total_amount_wait_payment), 0),
                            total_amount_paid: $scope.details.reduce((sum, d) => sum + Number(d.total_amount_paid), 0),
                            total_amount: $scope.details.reduce((sum, d) => sum + Number(d.total_amount), 0)
                        };
					}
				},
				error: function(err) {
					toastr.error('Đã có lỗi xảy ra');
				},
				complete: function() {
					$scope.loading.search = false;
					$scope.$applyAsync();
				}
            });
        }

		$scope.filter(1);

		$scope.pageChanged = function() {
			$scope.filter($scope.current.page);
		};

        $scope.settlement = {
            settlementAmount: 0,
            remainingAmount: 0,
        };

        $scope.settlementUser = function(user) {
            $scope.currentUser = user;
            $scope.waitingQuyetToanAmount = $scope.currentUser.total_amount_wait_payment;
            $scope.settlement.remainingAmount = $scope.waitingQuyetToanAmount;

            // Cập nhật lại view của input thông qua directive only-number
            const inputElementAmount = document.getElementById("amount"); // ID của input
            const ngModelCtrlAmount = angular.element(inputElementAmount).controller("ngModel");
            ngModelCtrlAmount.$setViewValue($scope.waitingQuyetToanAmount);
            ngModelCtrlAmount.$render();

            // Cập nhật lại view của input thông qua directive only-number
            const inputElementRemainingAmount = document.getElementById("remaining-amount"); // ID của input
            const ngModelCtrlRemainingAmount = angular.element(inputElementRemainingAmount).controller("ngModel");
            ngModelCtrlRemainingAmount.$setViewValue($scope.settlement.remainingAmount);
            ngModelCtrlRemainingAmount.$render();

            $('#modal-settlement-user').modal('show');
        }

        $scope.calculateRemainingAmount = function() {
            if (Number($scope.settlement.settlementAmount) > Number($scope.waitingQuyetToanAmount)) {
                $scope.settlement.settlementAmount = $scope.waitingQuyetToanAmount; // Giới hạn giá trị

                // Cập nhật lại view của input thông qua directive only-number
                const inputElement = document.getElementById("settlement-amount"); // ID của input
                const ngModelCtrl = angular.element(inputElement).controller("ngModel");
                ngModelCtrl.$setViewValue($scope.settlement.settlementAmount);
                ngModelCtrl.$render();
            }
            $scope.settlement.remainingAmount = $scope.waitingQuyetToanAmount - $scope.settlement.settlementAmount;
            // Cập nhật lại view của input thông qua directive only-number
            const inputElementRemaining = document.getElementById("remaining-amount"); // ID của input
            const ngModelCtrlRemaining = angular.element(inputElementRemaining).controller("ngModel");
            ngModelCtrlRemaining.$setViewValue($scope.settlement.remainingAmount);
            ngModelCtrlRemaining.$render();
        }

        $scope.errors = {};
        $scope.submitSettlementUser = function() {
            $scope.loading.submit = true;
            $.ajax({
                type: 'POST',
                url: "{{ route('Report.revenueReportSettlementUser') }}",
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: {
                    ...$scope.settlement,
                    user_id: $scope.currentUser.id,
                    amount_wait_payment: $scope.currentUser.total_amount_wait_payment,
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#modal-settlement-user').modal('hide');
                        $scope.filter(1);
                    } else {
                        toastr.error(response.message);
                        $scope.errors = response.errors;
                    }
                },
                error: function(err) {
                    toastr.error('Đã có lỗi xảy ra');
                },
                complete: function() {
                    $scope.$applyAsync();
                    $scope.loading.submit = false;
                }
            })
        }
    })
</script>
@endsection
