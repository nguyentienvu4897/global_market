@extends('site.layouts.master')
@section('title')
    Xác minh email
@endsection
@section('description')
    Xác minh email
@endsection
@section('image')
    {{ url('' . $banners[0]->image->path) }}
@endsection
@section('css')
    <link href="{{ asset('site/css/account_oder_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('site/css/breadcrumb_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <style>
        #customer_request_verify input[type="text"] {
            margin-bottom: 0px;
        }
        #customer_request_verify .form-group {
            margin-bottom: 15px;
        }
    </style>
@endsection
@section('content')
    <div ng-controller="MailVerifyController" ng-cloak>
        <section class="bread-crumb"
            style="background: linear-gradient(0deg, rgba(0,0,0,0), rgba(0,0,0,0)),  url(/site/images/bg_footer.jpg?1721988795194) center no-repeat;">
            <div class="container">
                <div class="title-bread-crumb"> Xác minh email
                </div>
                <ul class="breadcrumb">
                    <li class="home">
                        <a href="{{ route('front.home-page') }}"><span>Trang chủ</span></a>
                        <span class="mr_lr">/</span>
                    </li>
                    <li><strong><span>Xác minh email</span></strong></li>
                </ul>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="wrap_background_aside page_login">
                    <div class="row">
                        <div
                            class="col-lg-4 col-md-6 col-sm-12 col-xl-4 offset-0 offset-xl-4 offset-lg-4 offset-md-3 offset-xl-3 col-12">
                            <div class="row">
                                <div class="page-login pagecustome clearfix">
                                    <div class="wpx" style="margin-bottom: 0">
                                        <h1 class="title_heads a-center"><span>Xác minh email hệ thống</span></h1>
                                        <div id="login" class="section">
                                            <form id="customer_request_verify">
                                                <div class="form-signup clearfix">
                                                    <fieldset class="form-group">
                                                        <input type="text" class="form-control form-control-lg"
                                                            id="customer_email" ng-model="requestVerify.email"
                                                            placeholder="Email" required>
                                                        <span class="invalid-feedback d-block error"
                                                            style="text-align: left;" role="alert"
                                                            ng-if="errors && errors['email']">
                                                            <strong><% errors['email'][0] %></strong>
                                                        </span>
                                                    </fieldset>
                                                    <div class="pull-xs-left">
                                                        <input class="btn btn-style btn_50" type="submit" value="Gửi liên kết xác minh"
                                                            ng-click="submitRequestVerify()" />
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
    </div>
@endsection
@push('script')
    <script type="text/javascript">
        app.controller('MailVerifyController', function($scope) {
            $scope.errors = {};
            $scope.requestVerify = {
                email: ''
            };

            $scope.submitRequestVerify = function() {
                let data = {
                    email: $scope.requestVerify.email
                };
                $.ajax({
                    url: '{{ route('email.verify.link.send') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = '{{ route('front.client-account') }}';
                        } else {
                            toastr.error(response.message);
                            $scope.errors = response.errors;
                        }
                    },
                    error: function(response) {
                        console.log(response);
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                })
            }
        })
    </script>
@endpush
