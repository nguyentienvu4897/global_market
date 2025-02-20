@extends('site.layouts.master')
@section('title')
    Quản lý đơn hàng
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

    {{-- <link rel="stylesheet" href="{{ asset('libs/datepicker/datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}"> --}}

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
    </style>
@endsection
@section('content')
    <div ng-controller="UserOrderController" ng-cloak>
        <section class="signup page_customer_account">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="table-list">
                        </table>
                    </div>
                </div>
            </div>
        </section>
        @include('site.admin.user_order_detail_popup')
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
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script src="{{ asset('libs/sweetalert/js/sweetalert.min.js') }}"></script>

    <script src="{{ asset('js/constant.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    <script src="{{ asset('js/custom.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    @include('partial.classes.base.Datatable')

    <script>
        app.controller('UserOrderController', function($scope) {
            let datatable = new DATATABLE('table-list', {
                ajax: {
                    url: '{{ route('front.user-order-search-data') }}',
                    data: function (d, context) {
                        DATATABLE.mergeSearch(d, context);
                        d.employee_email = "{{ Auth::guard('client')->user()->email }}";
                    },
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
                    {data: 'type', title: 'Loại đơn hàng', className: "text-center"},
                    {data: 'code_client', title: 'Mã'},
                    {data: 'total_price', title: 'Tổng tiền'},
                    {
                        data: 'status',
                        title: "Trạng thái",
                        render: function (data) {
                            return getStatus(data, @json(\App\Model\Admin\Order::STATUSES));
                        },
                        className: "text-center"
                    },
                    {data: 'created_at', title: 'Ngày đặt hàng'},
                    {data: 'action_client', title: 'Hành động', orderable: false, searchable: false},
                ],
                search_columns: [
                    {data: 'code', search_type: "text", placeholder: "Mã đơn hàng"},
                    {data: 'status', search_type: "select", placeholder: "Trạng thái", column_data: @json(\App\Model\Admin\Order::STATUSES)},
                ],
                // search_by_time: true,
            }).datatable;

            $('#table-list').on('click', '.cancel-order', function () {
                event.preventDefault();
                let url = $(this).data('href');
                swal({
                    title: "Xác nhận hủy đơn hàng!",
                    text: `Đơn hàng sẽ được hủy và không thể khôi phục lại<br>
                    <label style="float: left;">Lý do hủy đơn hàng<span style="color: red;">*</span></label>
                    <textarea class="form-control" rows="2" style="width: 100%;" id="cancel-order-reason"></textarea><br>
                    <div id="cancel-order-reason-error" style="display: none; color: red;">Lý do hủy đơn hàng không được để trống</div>`,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Xác nhận",
                    cancelButtonText: "Hủy",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    html: true,
                }, function(isConfirm) {
                    if (isConfirm) {
                        let reason = $('#cancel-order-reason').val();
                        if (reason) {
                            $.ajax({
                                url: url,
                                type: 'GET',
                                data: {reason: reason},
                                success: function (response) {
                                    if (response.success) {
                                        toastr.success('Đã hủy đơn hàng');
                                        swal.close();
                                        datatable.ajax.reload();
                                    }
                                },
                                error: function (error) {
                                    console.log(error);
                                },
                                complete: function () {
                                }
                            });
                        } else {
                            $('#cancel-order-reason-error').show();
                        }
                    }
                });
            });

            $('#table-list').on('click', '.show-order-detail', function () {
                event.preventDefault();
                let url = $(this).data('href');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        if (response.success) {
                            $scope.detail = response.data;
                            $scope.detail.status = getStatus($scope.detail.status, @json(\App\Model\Admin\Order::STATUSES));
                            $scope.detail.details = $scope.detail.details.map(item => {
                                item.attributes = JSON.parse(item.attributes);
                                return item;
                            });
                            $scope.$apply();
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    },
                    complete: function () {
                        $('#show-order-detail-popup').modal('show');
                    }
                });
            });

            $scope.getStatus = function (status, statuses) {
                let obj = statuses.find(val => val.id == status);
                return obj.name;
            }
        })
    </script>
@endpush
