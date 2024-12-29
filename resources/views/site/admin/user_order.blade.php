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
    <script src="{{ asset('libs/datepicker/datepicker.full.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>

    <script src="{{ asset('js/constant.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    <script src="{{ asset('js/custom.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    @include('partial.classes.base.Datatable')

    <script>
        app.controller('UserOrderController', function($scope) {
            let datatable = new DATATABLE('table-list', {
                ajax: {
                    url: '{{ route('orders.searchData') }}',
                    data: function (d, context) {
                        DATATABLE.mergeSearch(d, context);
                        d.employee_email = "{{ Auth::guard('client')->user()->email }}";
                    },
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
                    {data: 'code_client', title: 'Mã'},
                    // {data: 'customer_name', title: 'Tên khách hàng'},
                    // {data: 'customer_phone', title: 'SĐT khách hàng'},
                    {data: 'total_price', title: 'Tổng tiền'},
                    {
                        data: 'status',
                        title: "Trạng thái",
                        // render: function (data) {
                        //     return getStatus(data, @json(\App\Model\Admin\Order::STATUSES));
                        // },
                        // className: "text-center"
                    },
                    {data: 'created_at', title: 'Ngày đặt hàng'},
                    // {data: 'action_client', orderable: false, title: "Hành động", style: "width: 100px;"}
                ],
                search_columns: [
                    // {data: 'code_client', search_type: "text", placeholder: "Mã đơn hàng"},
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
