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
@endsection
@section('content')
<div ng-controller="LoginClientController" ng-cloak>
    <section class="bread-crumb"
        style="background: linear-gradient(0deg, rgba(0,0,0,0), rgba(0,0,0,0)),  url(/site/images/bg_footer.jpg?1721988795194) center no-repeat;">
        <div class="container">
            <div class="title-bread-crumb"> Đăng nhập tài khoản
            </div>
            <ul class="breadcrumb">
                <li class="home">
                    <a href="{{route('front.home-page')}}"><span>Trang chủ</span></a>
                    <span class="mr_lr">/</span>
                </li>
                <li><strong><span><% title %></span></strong></li>
            </ul>
        </div>
    </section>
    <section class="section" >
        <div class="container">
            <div class="wrap_background_aside page_login">
                <div class="row">
                    <div
                        class="col-lg-4 col-md-6 col-sm-12 col-xl-4 offset-0 offset-xl-4 offset-lg-4 offset-md-3 offset-xl-3 col-12">
                        <div class="row" ng-show="formLogin">
                            <div class="page-login pagecustome clearfix">
                                <div class="wpx">
                                    <h1 class="title_heads a-center"><span>Đăng nhập</span></h1>
                                    <div id="login" class="section">
                                        <form id="customer_login" accept-charset="UTF-8">
                                            <div class="form-signup clearfix">
                                                <fieldset class="form-group">
                                                    <input type="text"
                                                        class="form-control form-control-lg"
                                                        id="customer_email" ng-model="account_name" placeholder="Email hoặc Tên đăng nhập" Required>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <input type="password" class="form-control form-control-lg"
                                                        id="customer_password" ng-model="password"
                                                        placeholder="Mật khẩu" Required>
                                                </fieldset>
                                                <div class="pull-xs-left">
                                                    <input class="btn btn-style btn_50" type="submit" value="Đăng nhập" ng-click="loginClient()" />
                                                </div>
                                                <div class="btn_boz_khac">
                                                    <div class="btn_khac">
                                                        <span class="quenmk">Quên mật khẩu?</span>
                                                        <a href="javascript:void(0)" ng-click="showFormRegister()" class="btn-link-style btn-register"
                                                            title="Đăng ký tại đây">Đăng ký tại đây</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="h_recover" style="display:none;">
                                        <div id="recover-password" class="form-signup page-login">
                                            <form method="post" action="/account/recover" id="recover_customer_password"
                                                accept-charset="UTF-8">
                                                <input name="FormType" type="hidden"
                                                    value="recover_customer_password" /><input name="utf8" type="hidden"
                                                    value="true" />
                                                <div class="form-signup" style="color: red;">
                                                </div>
                                                <div class="form-signup clearfix">
                                                    <fieldset class="form-group">
                                                        <input type="email"
                                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$"
                                                            class="form-control form-control-lg" value=""
                                                            name="Email" id="recover-email" placeholder="Email" Required>
                                                    </fieldset>
                                                </div>
                                                <div class="action_bottom">
                                                    <input class="btn btn-style btn_50" style="margin-top: 0px;"
                                                        type="submit" value="Lấy lại mật khẩu" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-show="formRegister">
                            <div class="page-login pagecustome clearfix">
                                <div class="wpx">
                                    <h1 class="title_heads a-center"><span>Đăng ký</span></h1>
                                    <span class="block a-center dkm margin-top-10">Đã có tài khoản, đăng nhập <a
                                            href="javascript:void(0)" ng-click="showFormLogin()" class="btn-link-style btn-register">tại
                                            đây</a></span>
                                    <div id="login" class="section">
                                        <form id="customer_register" accept-charset="UTF-8">
                                            <div class="form-signup clearfix">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <fieldset class="form-group" style="margin-bottom: 12px">
                                                            <input type="text" class="form-control form-control-lg" style="margin-bottom: 0;"
                                                                value="" name="name" id="name"
                                                                placeholder="Họ và tên" required>
                                                            <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                                                                ng-if="errors && errors['name']">
                                                                <strong><% errors['name'][0] %></strong>
                                                            </span>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <fieldset class="form-group" style="margin-bottom: 12px">
                                                            <input type="text" class="form-control form-control-lg" style="margin-bottom: 0;"
                                                                value="" name="account_name" id="account_name"
                                                                placeholder="Tên đăng nhập" required>
                                                            <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                                                                ng-if="errors && errors['account_name']">
                                                                <strong><% errors['account_name'][0] %></strong>
                                                            </span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <fieldset class="form-group" style="margin-bottom: 12px">
                                                            <input type="email"
                                                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$"
                                                                class="form-control form-control-lg" style="margin-bottom: 0;" value=""
                                                                name="email" id="email" placeholder="Email"
                                                                required="">
                                                            <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                                                                ng-if="errors && errors['email']">
                                                                <strong><% errors['email'][0] %></strong>
                                                            </span>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <fieldset class="form-group" style="margin-bottom: 12px">
                                                            <input placeholder="Số điện thoại" type="text"
                                                                pattern="\d+"
                                                                class="form-control form-control-comment form-control-lg" style="margin-bottom: 0;"
                                                                name="phone_number">
                                                            <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                                                                ng-if="errors && errors['phone_number']">
                                                                <strong><% errors['phone_number'][0] %></strong>
                                                            </span>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <fieldset class="form-group" style="margin-bottom: 12px">
                                                            <input type="password"
                                                                class="form-control form-control-lg" style="margin-bottom: 0;" value=""
                                                                name="password" id="password" placeholder="Mật khẩu"
                                                                required>
                                                            <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                                                                ng-if="errors && errors['password']">
                                                                <strong><% errors['password'][0] %></strong>
                                                            </span>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <fieldset class="form-group" style="margin-bottom: 12px">
                                                            <input type="text"
                                                                class="form-control form-control-lg" style="margin-bottom: 0;" value=""
                                                                name="invite_code" id="invite_code" placeholder="Nhập mã giới thiệu (nếu có)">
                                                            <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                                                                ng-if="errors && errors['invite_code']">
                                                                <strong><% errors['invite_code'][0] %></strong>
                                                            </span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="section">
                                                    <button type="submit" value="Đăng ký" ng-click="registerClient()"
                                                        class="btn  btn-style btn_50">Đăng ký</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="js-global-alert" class="alert alert-success" role="alert">
        <button type="button" class="close"><span aria-hidden="true"><span
                    aria-hidden="true">&times;</span></span></button>
        <h5 class="alert-heading"></h5>
        <p class="alert-content"></p>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
    function showRecoverPasswordForm() {
        document.getElementById('recover-password').style.display = 'block';
        document.getElementById('login').style.display = 'none';
    }

    function hideRecoverPasswordForm() {
        document.getElementById('recover-password').style.display = 'none';
        document.getElementById('login').style.display = 'block';
    }
    app.controller('LoginClientController', function($scope){
        $scope.formLogin = true;
        $scope.formRegister = false;
        $scope.title = 'Đăng nhập tài khoản';
        $scope.showFormLogin = function(){
            $scope.formLogin = true;
            $scope.formRegister = false;
            $scope.title = 'Đăng nhập tài khoản';
        }
        $scope.showFormRegister = function(){
            $scope.formLogin = false;
            $scope.formRegister = true;
            $scope.title = 'Đăng ký tài khoản';
        }

        $scope.errors = {};

        $scope.registerClient = function(){
            let data = $('#customer_register').serialize();
            $.ajax({
                url: '{{route('front.register-client-submit')}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(response){
                    if(response.success){
                        toastr.success(response.message);
                        $scope.account_name = response.data.account_name;
                        $scope.password = response.data.password;
                        $scope.showFormLogin();
                    }else{
                        toastr.error(response.message);
                        $scope.errors = response.errors;
                    }
                },
                error: function(response){
                    console.log(response);
                },
                complete: function(){
                    $scope.$applyAsync();
                }
            })
        }

        $scope.loginClient = function(){
            let data = {
                account_name: $scope.account_name,
                password: $scope.password
            };
            $.ajax({
                url: '{{route('front.login-client-submit')}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(response){
                    if(response.success){
                        toastr.success(response.message);
                        window.location.href = '{{route('front.client-account')}}';
                        localStorage.setItem('{{ env("prefix") }}-token', response.data.token);
                    }else{
                        toastr.error(response.message);
                    }
                },
                error: function(response){
                    console.log(response);
                },
                complete: function(){
                    $scope.$applyAsync();
                }
            })
        }
    })
</script>
@endpush
