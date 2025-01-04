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
            padding: 0 18px !important;
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
    </div>
@endsection
@push('script')

    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    {{-- <script src="{{ asset('libs/datepicker/datepicker.full.min.js') }}"></script> --}}
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- daterangepicker -->
    {{-- <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
    <script src="{{ asset('js/adminlte.js') }}"></script>
    {{-- <script src="{{ asset('plugins/moment/moment.min.js') }}"></script> --}}

    <script src="{{ asset('js/constant.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    <script src="{{ asset('js/custom.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    @include('partial.classes.base.Datatable')

    <script>
        // $('#startDate').daterangepicker({
        //     singleDatePicker: true,
        //     startDate: moment().subtract(6, 'days')
        // });

        // $('#endDate').daterangepicker({
        //     singleDatePicker: true,
        //     startDate: moment()
        // });
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
                    // {data: 'action_client', title: 'Hành động', orderable: false, searchable: false},
                ],
                search_columns: [
                    {data: 'code', search_type: "text", placeholder: "Mã đơn hàng"},
                    {data: 'status', search_type: "select", placeholder: "Trạng thái", column_data: @json(\App\Model\Admin\Order::STATUSES)},
                ],
                // search_by_time: true,
            }).datatable;

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
