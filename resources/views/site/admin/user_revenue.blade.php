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
        .form-control {
            display: block;
            width: 100%;
            /* height: calc(2.25rem + 2px) !important; */
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #ffffff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            box-shadow: inset 0 0 0 rgba(0, 0, 0, 0);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-group.custom-group {
            position: relative;
        }
        .form-group.custom-group label {
            position: absolute;
            z-index: 10;
            font-weight: 700;
            background: #fff;
            padding: 0 5px;
            top: -10px;
            left: 10px;
            font-size: 13px;
            color: #000;
        }
        label {
            display: inline-block;
            margin-bottom: 0.5rem;
        }
        [type="search"] {
            outline-offset: -2px;
            -webkit-appearance: none;
        }
    </style>

@endsection
@section('content')
    <div ng-controller="UserRevenueController" ng-cloak>
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

    <script src="{{ asset('js/constant.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    <script src="{{ asset('js/custom.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    @include('partial.classes.base.Datatable')

    <script>
        $(document).ready(function (){
            $('select.select2').select2();
        });
        app.controller('UserRevenueController', function($scope) {
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
                    {data: 'status', title: 'Trạng thái'},
                    {data: 'created_at', title: 'Ngày đặt hàng'},
                    {data: 'settlement_date', title: 'Ngày quyết toán'},
                ],
                // search_columns: [
                //     {data: 'order_code', search_type: "text", placeholder: "Mã đơn hàng"},
                //     {data: 'order_employee', search_type: "text", placeholder: "Người đặt hàng"},
                //     {data: 'status', search_type: "select", placeholder: "Trạng thái", options: @json(\App\Model\Admin\OrderRevenueDetail::STATUSES)},
                // ],
                // search_by_time: true,
            }).datatable;
        })
    </script>
@endpush
