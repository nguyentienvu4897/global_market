@extends('site.layouts.master')
@section('title')
    {{ $config->web_title }}
@endsection
@section('description')
    {{ $config->web_des }}
@endsection
@section('image')
@endsection
@section('css')
    <link href="{{ asset('site/css/account_oder_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('site/css/breadcrumb_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <style>
        .page_customer_account .invite-code{
            width: 120px !important;
            padding: 5px !important;
            border: 1px solid #ccc !important;
            border-top-left-radius: 5px !important;
            border-bottom-left-radius: 5px !important;
            margin-bottom: 0 !important;
            font-size: 16px !important;
        }
        .page_customer_account .group-invite-code{
            display: flex;
            align-items: center;
        }
        .page_customer_account .group-invite-code .btn-copy-invite-code{
            padding: 8px 10px;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            background-color: #fafafa;
            color: #000;
        }
        .page_customer_account .group-invite-link{
            width: 70%;
        }
        .page_customer_account .group-invite-link .invite-code{
            width: 75% !important;
        }

        @media (max-width: 768px) {
            .page_customer_account .group-invite-link{
                width: 100%;
            }
            .page_customer_account .group-invite-link .invite-code{
                width: 65% !important;
            }
        }
        .page_customer_account .group-invite-code .btn-update-invite-code{
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-top-right-radius: 5px !important;
            border-bottom-right-radius: 5px !important;
            background-color: #ff9933;
            color: #fff;
        }
        .text-danger {
            color: #dc3232 !important;
        }
        .name-account .form-group{
            margin-bottom: 10px !important;
        }
        .name-account .form-group label{
            margin-bottom: 0 !important;
            font-weight: 600 !important;
        }
        .name-account .form-group input{
            margin-bottom: 0 !important;
            border: 1px solid #dfdfdf !important;
            border-radius: 5px !important;
            padding: 5px 10px !important;
            font-size: 15px !important;
        }
        .name-account .input-group input{
            margin-bottom: 0 !important;
            border: 1px solid #dfdfdf !important;
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            padding: 5px 10px !important;
            font-size: 15px !important;
        }
        .name-account .input-group button{
            border: 1px solid #dfdfdf !important;
            border-top-right-radius: 5px !important;
            border-bottom-right-radius: 5px !important;
        }
        .input-group {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
        }
        .input-group-prepend, .input-group-append {
            display: -ms-flexbox;
            display: flex;
        }
        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
            margin-bottom: 2rem;
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #ffffff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 0.75rem 1.25rem;
            position: relative;
            border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
        }
        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem;
        }
        .btn-success {
            background-color: #0974ba !important;
            color: #fff !important;
            border: 1px solid #0974ba !important;
            border-radius: 5px !important;
            padding: 5px 10px !important;
            font-size: 18px !important;
            height: auto !important;
        }
    </style>
@endsection
@section('content')
    <div ng-controller="AdminClientController" ng-cloak>
        <section class="signup page_customer_account">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-3 col-left-ac">
                        <div class="block-account">
                            <h5 class="title-account">Trang tài khoản</h5>
                            <p>Xin chào, <span style="color:#ff9933;">{{ Auth::guard('client')->user()->name }}</span>&nbsp;!</p>
                            <ul>
                                <li>
                                    <a disabled="disabled" class="title-info" title="Thông tin tài khoản"
                                        href="javascript:void(0);" ng-click="showChangePassword = false">Thông tin tài khoản</a>
                                </li>
                                <li>
                                    <a class="title-info" href="javascript:void(0)" title="Đổi mật khẩu" ng-click="changePassword(showChangePassword = !showChangePassword)">Đổi mật
                                        khẩu</a>
                                </li>
                                <li>
                                    <a class="title-info" href="{{ route('front.logout-client') }}" title="Đăng xuất">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-lg-9 col-right-ac">
                        <h1 class="title-head margin-top-0 d-flex" style="align-items: center; justify-content: flex-end; flex-wrap: wrap;">
                            <div style="font-size: 19px; font-weight: 500; flex: 1 1 50%;" ng-if="!showChangePassword">Thông tin tài khoản</div>
                            <div style="font-size: 19px; font-weight: 500; flex: 1 1 50%;" ng-if="showChangePassword">Thay đổi mật khẩu</div>
                            <div class="ml-auto group-invite-code" style="flex: 1 1 -1%;">
                                <label style="font-weight: 600; font-size: 16px; margin-bottom: 0 !important; margin-right: 10px;">Mã giới thiệu: </label>
                                <input class="invite-code" type="text" ng-model="currentUser.invite_code" placeholder="Mã giới thiệu" disabled>
                                <a class="btn-copy-invite-code" href="javascript:void(0)" ng-click="copyReferralCode($event)" title="Copy mã giới thiệu" style="border-right: 1px solid #ccc;">
                                    <i class="fa fa-copy"></i>
                                </a>
                                <a class="btn-update-invite-code" href="javascript:void(0)" ng-click="updateReferralCode($event)" title="Tạo lại mã giới thiệu" ng-if="!currentUser.invite_code">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </div>
                            <div class="group-invite-code group-invite-link" style="margin-top: 10px; flex: 0 1 -1%;">
                                <label style="font-weight: 600; font-size: 16px; margin-bottom: 0 !important; margin-right: 10px; width:21%" ng-if="currentUser.invite_code">Link giới thiệu: </label>
                                <input class="invite-code" type="text" ng-model="link_invite_code" placeholder="Link giới thiệu" disabled ng-if="currentUser.invite_code">
                                <a class="btn-copy-invite-code" href="javascript:void(0)" ng-click="copyReferralLink($event)" title="Copy link giới thiệu" style="border-right: 1px solid #ccc;" ng-if="currentUser.invite_code">
                                    <i class="fa fa-copy"></i>
                                </a>
                            </div>
                        </h1>
                        <div class="form-signup name-account m992" ng-if="!showChangePassword">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Tên đăng nhập</label>
                                        <span class="text-danger">(*)</span>
                                        <input type="text" class="form-control" ng-model="currentUser.account_name">
                                        <span class="invalid-feedback d-block error" role="alert">
                                            <strong><% errors.account_name[0] %></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Họ tên</label>
                                        <span class="text-danger">(*)</span>
                                        <input type="text" class="form-control" ng-model="currentUser.name">
                                        <span class="invalid-feedback d-block error" role="alert">
                                            <strong><% errors.name[0] %></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <span class="text-danger">(*)</span>
                                        <input type="text" class="form-control" ng-model="currentUser.email">
                                        <span class="invalid-feedback d-block error" role="alert">
                                            <strong><% errors.email[0] %></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Số điện thoại</label>
                                        <span class="text-danger">(*)</span>
                                        <input type="text" class="form-control" ng-model="currentUser.phone_number">
                                        <span class="invalid-feedback d-block error" role="alert">
                                            <strong><% errors.phone_number[0] %></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Địa chỉ</label>
                                        <input type="text" class="form-control" ng-model="currentUser.address">
                                        <span class="invalid-feedback d-block error" role="alert">
                                            <strong><% errors.address[0] %></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Số tài khoản</label>
                                        <span class="text-danger">(*)</span>
                                        <input type="text" class="form-control" ng-model="currentUser.bank_account_number">
                                        <span class="invalid-feedback d-block error" role="alert">
                                            <strong><% errors.bank_account_number[0] %></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Tên chủ tài khoản</label>
                                        <span class="text-danger">(*)</span>
                                        <input type="text" class="form-control" ng-model="currentUser.bank_account_name">
                                        <span class="invalid-feedback d-block error" role="alert">
                                            <strong><% errors.bank_account_name[0] %></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Tên ngân hàng</label>
                                        <span class="text-danger">(*)</span>
                                        <input type="text" class="form-control" ng-model="currentUser.bank_name">
                                        <span class="invalid-feedback d-block error" role="alert">
                                            <strong><% errors.bank_name[0] %></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0" style="font-size: 18px; font-weight: 600; margin-bottom: 0 !important;">Ảnh đại diện</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="img-chooser">
                                                <label for="<% currentUser.image.element_id %>">
                                                    <img ng-src="<% currentUser.image.path %>">
                                                    <input class="d-none" type="file" accept=".jpg,.png,.jpeg" id="<% currentUser.image.element_id %>">
                                                </label>
                                            </div>
                                            <span class="invalid-feedback d-block error" role="alert">
                                                <strong><% errors['image'][0] %></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <button class="btn btn-success" style="float: right;" ng-click="updateUser()">Cập nhật</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-signup name-account m992" ng-if="showChangePassword">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Mật khẩu hiện tại</label>
                                        <span class="text-danger">(*)</span>
                                        <div class="input-group mb-0">
                                            <input class="form-control" type="password" ng-model="form.current_password">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary show-password" type="button"><i class="fa fa-eye muted"></i></button>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback d-block error" role="alert">
                                            <strong><% errors.current_password[0] %></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Mật khẩu mới</label>
                                        <span class="text-danger">(*)</span>
                                        <div class="input-group mb-0">
                                            <input class="form-control" type="password" ng-model="form.new_password">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary show-password" type="button"><i class="fa fa-eye muted"></i></button>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback d-block error" role="alert">
                                            <strong><% errors.new_password[0] %></strong>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Nhập lại mật khẩu mới</label>
                                        <span class="text-danger">(*)</span>
                                        <div class="input-group mb-0">
                                            <input class="form-control" type="password" ng-model="form.confirm_password">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary show-password" type="button"><i class="fa fa-eye muted"></i></button>
                                            </div>
                                        </div>
                                        <span class="invalid-feedback d-block error" role="alert">
                                            <strong><% errors.confirm_password[0] %></strong>
                                        </span>
                                    </div>
                                    <button class="btn btn-success" style="float: right; margin-top: 10px" ng-click="submitChangePassword()">Đổi mật khẩu</button>
                                </div>
                                <div class="col-md-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    <script src="{{ asset('js/custom.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    @include('partial.classes.base.BaseClass')
    @include('partial.classes.base.BaseChildClass')
    @include('partial.classes.base.Image')
    @include('partial.classes.common.User')
    <script type="text/javascript">
        app.controller('AdminClientController', function($scope) {
            $scope.currentUser = new User(@json($user), {scope: $scope});
            $scope.showChangePassword = false;
            $scope.copyReferralCode = function($event){
                $event.preventDefault();
                if($scope.currentUser.invite_code){
                    navigator.clipboard.writeText($scope.currentUser.invite_code);
                    toastr.success('Đã sao chép mã giới thiệu');
                }else{
                    toastr.error('Mã giới thiệu không tồn tại');
                }
            }
            $scope.copyReferralLink = function($event){
                $event.preventDefault();
                if($scope.link_invite_code){
                    navigator.clipboard.writeText($scope.link_invite_code);
                    toastr.success('Đã sao chép link giới thiệu');
                }else{
                    toastr.error('Link giới thiệu không tồn tại');
                }
            }
            if ($scope.currentUser.invite_code) {
                $scope.link_invite_code = '{{route("front.login-client")}}?invite_code=' + $scope.currentUser.invite_code;
            }

            $scope.updateReferralCode = function($event){
                $event.preventDefault();
                $.ajax({
                    url: "{{ route('front.update-invite-code') }}",
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: {
                        user_id: $scope.currentUser.id
                    },
                    success: function(response) {
                        if (response.success) {
                            $scope.currentUser.invite_code = response.data.invite_code;
                            if ($scope.currentUser.invite_code) {
                                $scope.link_invite_code = '{{route("front.login-client")}}?invite_code=' + $scope.currentUser.invite_code;
                            }
                            toastr.success('Đã tạo lại mã giới thiệu');
                            $scope.$applyAsync();
                        }else{
                            toastr.error(response.message);
                        }
                    },
                    error: function(response) {
                        toastr.error('Có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$apply();
                    }
                });
            }

            $scope.updateUser = function() {
                let data = $scope.currentUser.submit_data;
                $.ajax({
                    type: 'POST',
                    url: "{{ route('front.client-update', $user->id) }}",
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.warning(response.message);
                            $scope.errors = response.errors;
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.form = {
                current_password: '',
                new_password: '',
                confirm_password: ''
            }

            $scope.submitChangePassword = function() {
                let data = $scope.form;
                $.ajax({
                    type: 'POST',
                    url: "{{ route('front.client-change-password', $user->id) }}",
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $scope.showChangePassword = false;
                            window.location.href = "{{ route('front.logout-client') }}";
                        } else {
                            toastr.warning(response.message);
                            $scope.errors = response.errors;
                        }
                    },
                    error: function(response) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }
        })

        $(document).on("click", ".show-password", function() {
            var input = $(this).closest(".form-group").find("input");
            if ($(input).attr("type") == "password") $(input).attr("type", "text");
            else $(input).attr("type", "password")
        })
    </script>
@endpush
