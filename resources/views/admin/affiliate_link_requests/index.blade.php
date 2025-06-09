@extends('layouts.main')

@section('css')
@endsection

@section('page_title')
    Quản lý yêu cầu affiliate link
@endsection

@section('title')
    Quản lý yêu cầu affiliate link
@endsection

@section('buttons')
@endsection
@section('content')
    <div ng-cloak>
        <div class="row" ng-controller="AffiliateLinkRequests">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="table-list">
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="update-status" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="semi-bold">Đổi trạng thái</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group custom-group">
                                                <label class="form-label">Trạng thái</label>
                                                <select class="form-control" ng-model="form.status">
                                                    <option value="">Chọn trạng thái</option>
                                                    <option ng-repeat="s in statues" ng-value="s.id"
                                                        ng-selected="s.id == form.status">
                                                        <% s.name %>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-cons" ng-click="submit()"
                                ng-disabled="loading.submit">
                                <i ng-if="!loading.submit" class="fa fa-save"></i>
                                <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
                                Lưu
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                    class="fas fa-window-close"></i> Hủy</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal fade" id="send-email" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="semi-bold">Gửi email xác nhận</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group custom-group">
                                                <label class="form-label">Xác nhận sản phẩm</label>
                                                <select select2-modal-ajax ng-model="formSendEmail.product_id"
                                                    url="{{ route('Product.searchProductAjax') }}"
                                                    id="formSendEmail.product_id" placeholder="Chọn sản phẩm"
                                                    class="form-control" modal-selector="#send-email">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-cons" ng-click="submitSendEmail()"
                                ng-disabled="loading.submitSendEmail">
                                <i ng-if="!loading.submitSendEmail" class="fa fa-save"></i>
                                <i ng-if="loading.submitSendEmail" class="fa fa-spin fa-spinner"></i>
                                Gửi email
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                    class="fas fa-window-close"></i> Hủy</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let columns = [
            {
                data: 'DT_RowIndex',
                orderable: false,
                title: "STT",
                className: "text-center"
            },
            {
                data: 'user',
                title: 'Người yêu cầu'
            },
            {
                data: 'campaign',
                title: 'Chiến dịch'
            },
            {
                data: 'url_origin',
                title: 'Link gốc'
            },
            {
                data: 'status',
                title: 'Trạng thái'
            },
            {
                data: 'created_at',
                title: 'Ngày yêu cầu'
            },
            {
                data: 'approved_by',
                title: 'Người xử lý'
            },
            {
                data: 'approved_at',
                title: 'Ngày xử lý'
            },
            {
                data: 'action',
                orderable: false,
                title: "Hành động"
            }
        ];
        if ({{ Auth::guard('admin')->user()->type }} == @json(\App\Model\Common\User::CONG_TAC_VIEN)) {
            columns.splice(1, 1);
            columns.splice(5, 1);
            columns.splice(5, 1);
        }
        let datatable = new DATATABLE('table-list', {
            ajax: {
                url: '/admin/affiliate-link-requests/searchData',
                data: function(d, context) {
                    DATATABLE.mergeSearch(d, context);
                }
            },
            columns: columns,
            search_columns: [{
                    data: 'user_id',
                    search_type: "select",
                    placeholder: "Người yêu cầu",
                    column_data: @json(\App\Model\Common\User::all())
                },
                {
                    data: 'campaign_id',
                    search_type: "select",
                    placeholder: "Chiến dịch",
                    column_data: @json(\App\Model\Admin\AffiliateLinkRequest::CAMPAIGNS)
                },
                {
                    data: 'status',
                    search_type: "select",
                    placeholder: "Trạng thái",
                    column_data: @json(\App\Model\Admin\AffiliateLinkRequest::STATUSES)
                },
            ],
        }).datatable;

        createReviewCallback = (response) => {
            datatable.ajax.reload();
        }

        app.controller('AffiliateLinkRequests', function($rootScope, $scope, $http) {
            $scope.loading = {};
            $scope.statues = @json(\App\Model\Admin\AffiliateLinkRequest::STATUSES);
            $scope.form = {};
            $scope.formSendEmail = {};
            $scope.urlSendEmail = '';

            $('#table-list').on('click', '.update-status', function() {
                event.preventDefault();
                $scope.data = datatable.row($(this).parents('tr')).data();
                console.log($scope.data);
                $scope.form.status = $scope.data.status;
                $scope.$apply();
                $('#update-status').modal('show');
            });

            $('#table-list').on('click', '.send-email', function() {
                event.preventDefault();
                $scope.data = datatable.row($(this).parents('tr')).data();
                $scope.urlSendEmail = $(this).data('href');
                $scope.$apply();
                $('#send-email').modal('show');
            });

            $scope.submitSendEmail = function() {
                $scope.loading.submitSendEmail = true;
                $.ajax({
                    type: 'GET',
                    url: $scope.urlSendEmail,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        product_id: $scope.formSendEmail.product_id,
                        affiliate_link_request_id: $scope.data.id
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#send-email').modal('hide');
                            $scope.loading.submitSendEmail = false;
                        } else {
                            toastr.warning(response.message);
                            $scope.loading.submitSendEmail = false;
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                        $scope.loading.submitSendEmail = false;
                    },
                    complete: function() {
                        datatable.ajax.reload();
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.submit = function() {
                $scope.loading.submit = true;
                $.ajax({
                    type: 'POST',
                    url: "{{ route('affiliate-link-requests.update.status') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        affiliate_link_request_id: $scope.data.id,
                        status: $scope.form.status
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $scope.loading.submit = false;
                        } else {
                            toastr.warning(response.message);
                            $scope.loading.submit = false;
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                        $scope.loading.submit = false;
                    },
                    complete: function() {
                        $('#update-status').modal('hide');
                        datatable.ajax.reload();
                        $scope.$applyAsync();
                    }
                });
            }
        })
    </script>
    @include('partial.confirm')
@endsection
