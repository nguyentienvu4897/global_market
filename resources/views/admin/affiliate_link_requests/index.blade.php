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
                                                <option ng-repeat="s in statues" ng-value="s.id" ng-selected="s.id == form.status">
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
                        <button type="button" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
                            <i ng-if="!loading.submit" class="fa fa-save"></i>
                            <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
                            Lưu
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Hủy</button>
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
    let datatable = new DATATABLE('table-list', {
        ajax: {
            url: '/admin/affiliate-link-requests/searchData',
            data: function (d, context) {
                DATATABLE.mergeSearch(d, context);
            }
        },
        columns: [
            {data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'user', title: 'Người yêu cầu'},
            {data: 'campaign', title: 'Chiến dịch'},
            {data: 'url_origin', title: 'Link gốc'},
            {data: 'status', title: 'Trạng thái'},
            {data: 'created_at', title: 'Ngày yêu cầu'},
            {data: 'updated_at', title: 'Ngày cập nhật'},
            {data: 'action', orderable: false, title: "Hành động"}
        ],
        search_columns: [
            {data: 'user_id', search_type: "select", placeholder: "Người yêu cầu", column_data: @json(\App\Model\Common\User::all())},
            {data: 'campaign_id', search_type: "select", placeholder: "Chiến dịch", column_data: @json(\App\Model\Admin\AffiliateLinkRequest::CAMPAIGNS)},
            {data: 'status', search_type: "select", placeholder: "Trạng thái", column_data: @json(\App\Model\Admin\AffiliateLinkRequest::STATUSES)},
        ],
    }).datatable;

    createReviewCallback = (response) => {
        datatable.ajax.reload();
    }

    app.controller('AffiliateLinkRequests', function ($rootScope, $scope, $http) {
        $scope.loading = {};
        $scope.statues = @json(\App\Model\Admin\AffiliateLinkRequest::STATUSES);
        $scope.form = {}

        $('#table-list').on('click', '.update-status', function () {
            event.preventDefault();
            $scope.data = datatable.row($(this).parents('tr')).data();
            console.log($scope.data);
            $scope.form.status = $scope.data.status;
            $scope.$apply();
            $('#update-status').modal('show');
        });

        $scope.submit = function () {
            $.ajax({
                type: 'POST',
                url: "{{route('affiliate-link-requests.update.status')}}",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data: {
                    affiliate_link_request_id: $scope.data.id,
                    status:  $scope.form.status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(e) {
                    toastr.error('Đã có lỗi xảy ra');
                },
                complete: function() {
                    $('#update-status').modal('hide');
                    datatable.ajax.reload();
                    $scope.loading.submit = false;
                    $scope.$applyAsync();
                }
            });
        }
    })

</script>
@include('partial.confirm')
@endsection
