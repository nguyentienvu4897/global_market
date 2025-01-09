<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/site/image/logo.png"/>

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datepicker/datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/sweetalert/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('libs/angularjs/select.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.4.5/select2.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">

    @yield('css')

    <link href="{{ asset('css/custom.css') }}?version={{ env('APP_VERSION', '1') }}" rel="stylesheet">

    <script src="{{ asset('libs/angularjs/angular.js') }}"></script>

    <script src="{{ asset('libs/angularjs/angular-resource.js') }}"></script>
    <script src="{{ asset('libs/angularjs/sortable.js') }}"></script>
    <script src="{{ asset('libs/dnd/dnd.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.9/angular-sanitize.js"></script>
    <script src="{{ asset('libs/angularjs/select.js') }}"></script>

    <script src="{{ asset('js/angular.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    {{-- <script src="{{ asset('libs/angularjs/app.directive.js') }}"></script> --}}


    @include('partial.classes.base.Datatable')
    @include('partial.classes.base.BaseSearchModal')
    @include('partial.classes.base.BaseClass')
    @include('partial.classes.base.BaseChildClass')
    @include('partial.classes.base.File')
    @include('partial.classes.base.Image')
    @include('partial.classes.base.BaseClassWithFile')
    @include('partial.classes.base.BaseChildClassWithFile')
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse layout-navbar-fixed layout-footer-fixed " ng-app="App">
    <div class="wrapper">
        <!-- Navbar -->
        @include('partial.common.nav')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-dark-orange">
            <!-- Brand Logo -->
            <?php
                $config = \App\Model\Admin\Config::query()->get()->first();
            ?>
            <a href="{{ route('index') }}" class="brand-link">
                <img src="{{ $config->image->path ?? '' }}" alt="{{$config->web_title}}" class="brand-image" style="opacity: 1">
                <img src="{{ $config->image->path ?? '' }}" alt="{{$config->web_title}}" class="brand-image brand-mini" style="opacity: 1">
            </a>
            <!-- Sidebar -->
            @include('partial.common.sidebar')
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card customize-card customize-card-2" style="margin: 7px 0; min-height: calc(100vh - 130px)">
                                <div class="card-header card-header-page-title">
                                    <h3 class="card-title"> @yield('title')</h3>
                                </div>
                                <div class="card-body card-body-customize px-2">
                                    <div class="table-tool text-right col-lg-12 mb-2" wfd-id="79">
                                        @yield('buttons')
                                    </div>
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('partial.common.footer')
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('libs/ckeditor/ckeditor.js') }}"></script>

    <!-- daterangepicker -->
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/datepicker.full.min.js') }}"></script>

    <script src="{{ asset('libs/sweetalert/js/sweetalert.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function (){
            $('select.select2').select2();
        });

        function mergeSearchV2(object) {
            $('.search-column [data-column]').each(function() {
                if ($(this).data('column')) {
                    let column = $(this).data('column');
                    object[column] = $(this).val();
                }
            })
            object.startDate = $('#startDate').val() ? moment($('#startDate').val(), 'DD/MM/YYYY').format('YYYY-MM-DD') : '';
            object.endDate = $('#endDate').val() ? moment($('#endDate').val(), 'DD/MM/YYYY').format('YYYY-MM-DD') : '';
        }

        toastr.options.escapeHtml = false;
        @if(Session::has('message'))
        toastr.{{Session::get('alert-type', 'info')}}("{{Session::get('message')}}");
        @endif
        @if(Session::has('token'))
        localStorage.setItem('{{ env("prefix") }}-token', "{{Session::get('token')}}")
        @endif
        @if(Session::has('logout'))
        localStorage.removeItem('{{ env("prefix") }}-token');
        @endif
        var CSRF_TOKEN = "{{ csrf_token() }}";
        @if (Auth::guard('admin')->check())
        const DEFAULT_USER = {
            id: "{{ Auth::guard('admin')->user()->id }}",
            fullname: "{{ Auth::guard('admin')->user()->name }}"
        };
        const USERS = @json(\App\Model\Common\User::getMembers());
        @endIf

        app.directive("onlyNumber", function ($timeout) {
            return {
                restrict: 'EA',
                require: 'ngModel',
                link: function (scope, element, attrs, ngModel) {
                    function formatWithCommas(value) {
                        if (!value || isNaN(value)) return value;
                        let parts = String(value).split(".");
                        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Thêm dấu phẩy vào phần nguyên
                        return parts.join(".");
                    }

                    function removeCommas(value) {
                        return String(value).replace(/,/g, "");
                    }

                    function validateAndFormat(value) {
                        let rawValue = removeCommas(value); // Loại bỏ dấu phẩy để xử lý
                        if (!rawValue || isNaN(rawValue)) return "";

                        // Nếu không cho phép số âm
                        if (attrs.allowNegative === "false" && rawValue.startsWith("-")) {
                            rawValue = rawValue.replace("-", "");
                        }

                        // Nếu không cho phép số thập phân
                        if (attrs.allowDecimal === "false") {
                            rawValue = parseInt(rawValue);
                        }

                        // Giới hạn số thập phân
                        if (attrs.allowDecimal !== "false" && attrs.decimalUpto) {
                            let parts = String(rawValue).split(".");
                            if (parts[1]) {
                                parts[1] = parts[1].slice(0, attrs.decimalUpto);
                                rawValue = parts.join(".");
                            }
                        }

                        // Loại bỏ số 0 không cần thiết ở phần thập phân
                        // if (String(rawValue).includes(".")) {
                        //     rawValue = rawValue.replace(/(\.\d*?[1-9])0+$/, "$1"); // Bỏ số 0 thừa ở cuối
                        //     rawValue = rawValue.replace(/\.0+$/, ""); // Nếu chỉ còn lại `.0` thì loại bỏ cả dấu `.`
                        // }

                        // Giới hạn giá trị tối đa
                        if (attrs.maxValue && parseFloat(rawValue) > parseFloat(attrs.maxValue)) {
                            rawValue = attrs.maxValue;
                        }

                        return formatWithCommas(rawValue);
                    }

                    ngModel.$parsers.push(function (inputValue) {
                        if (!inputValue) return null;

                        let formattedValue = validateAndFormat(inputValue);
                        if (formattedValue !== inputValue) {
                            ngModel.$setViewValue(formattedValue); // Cập nhật giá trị định dạng
                            ngModel.$render();
                        }

                        return removeCommas(formattedValue); // Trả về giá trị không có dấu phẩy cho model
                    });

                    element.on("blur", function () {
                        let formattedValue = validateAndFormat(ngModel.$viewValue);
                        if (formattedValue !== ngModel.$viewValue) {
                            ngModel.$setViewValue(formattedValue);
                            ngModel.$render();
                        }
                    });

                    // Xử lý giá trị ban đầu
                    $timeout(function () {
                        let formattedValue = validateAndFormat(ngModel.$modelValue);
                        if (formattedValue !== ngModel.$modelValue) {
                            ngModel.$setViewValue(formattedValue);
                            ngModel.$render();
                        }
                    });
                }
            };
        })
    </script>
    <script src="{{ asset('js/constant.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    <script src="{{ asset('js/custom.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    @yield('script')

</body>

</html>
