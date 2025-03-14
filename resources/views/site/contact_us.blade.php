@extends('site.layouts.master')
@section('title')
    Liên hệ
@endsection
@section('description')
    {{ $config->web_des }}
@endsection
@section('image')
    {{ url('' . $banners[0]->image->path) }}
@endsection
@section('css')
    <link href="{{ asset('site/css/style_page.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('site/css/contact_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('site/css/breadcrumb_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
@endsection

@section('content')
<div ng-controller="ContactUsController" ng-cloak>
    <section class="bread-crumb"
        style="background: linear-gradient(0deg, rgba(0,0,0,0), rgba(0,0,0,0)),  url(/site/images/bg_footer.jpg?1721988795194) center no-repeat;">
        <div class="container">
            <div class="title-bread-crumb"> Liên hệ
            </div>
            <ul class="breadcrumb">
                <li class="home">
                    <a href="{{ route('front.home-page') }}"><span>Trang chủ</span></a>
                    <span class="mr_lr">/</span>
                </li>
                <li><strong><span>Liên hệ</span></strong></li>
            </ul>
        </div>
    </section>
    <div class="layout-contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="contact">
                        <h4>{{ $config->web_title }}</h4>
                        <div class="time_work">
                            <div class="item">
                                <b>Địa chỉ:</b>
                                {{ $config->address_company }}
                            </div>
                            <div class="item">
                                <b>Hotline:</b> <a class="fone" href="tel:{{ $config->hotline }}" title="{{ $config->hotline }}">{{ $config->hotline }}</a>
                            </div>
                            <div class="item">
                                <b>Email:</b> <a href="mailto:{{ $config->email }}" title="{{ $config->email }}">{{ $config->email }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-contact">
                        <h4>Liên hệ với chúng tôi</h4>
                        <div id="pagelogin">
                            <form id="contact" accept-charset="UTF-8">
                                <div class="group_contact">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-bottom: 10px;">
                                            <input placeholder="Họ và tên" type="text" style="margin-bottom: 0;"
                                                class="form-control  form-control-lg" required value=""
                                                ng-model="your_name" ng-class="{'is-invalid': errors && errors.your_name}">
                                            <div class="invalid-feedback d-block error" role="alert">
                                                <span ng-if="errors && errors.your_name">
                                                    <% errors.your_name[0] %>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-bottom: 10px;">
                                            <input placeholder="Email" type="email" style="margin-bottom: 0;"
                                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required id="email1"
                                                class="form-control form-control-lg" value="" ng-model="your_email" ng-class="{'is-invalid': errors && errors.your_email}">
                                            <div class="invalid-feedback d-block error" role="alert">
                                                <span ng-if="errors && errors.your_email">
                                                    <% errors.your_email[0] %>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: 10px;">
                                            <input type="text" placeholder="Điện thoại" style="margin-bottom: 0;"
                                                class="form-control form-control-lg" required ng-model="your_phone" ng-class="{'is-invalid': errors && errors.your_phone}">
                                            <div class="invalid-feedback d-block error" role="alert">
                                                <span ng-if="errors && errors.your_phone">
                                                    <% errors.your_phone[0] %>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: 10px;">
                                            <textarea placeholder="Nội dung" id="comment" ng-model="your_message" style="margin-bottom: 10px;"
                                                class="form-control content-area form-control-lg" rows="5" Required ng-model="your_message" ng-class="{'is-invalid': errors && errors.your_message}"></textarea>
                                            <div class="invalid-feedback d-block error" role="alert">
                                                <span ng-if="errors && errors.your_message">
                                                    <% errors.your_message[0] %>
                                                </span>
                                            </div>
                                            <button type="submit" class="btn-lienhe" ng-click="submitContact()">Gửi thông tin</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div id="contact_map" class="map">
                        {!! $config->location !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        app.controller('ContactUsController', function($scope, $http) {
            $scope.loading = false;
            $scope.errors = {};
            $scope.submitContact = function() {
                $scope.loading = true;
                let data = {
                    your_name: $scope.your_name,
                    your_email: $scope.your_email,
                    your_phone: $scope.your_phone,
                    your_message: $scope.your_message
                };
                jQuery.ajax({
                    url: '{{ route('front.post-contact') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Thao tác thành công !')
                        } else {
                            $scope.errors = response.errors;
                            toastr.error('Thao tác thất bại !')
                        }
                    },
                    error: function() {
                        toastr.error('Thao tác thất bại !')
                    },
                    complete: function() {
                        $scope.$applyAsync();
                        $scope.loading = false;
                    }
                });
            };
        });
    </script>
@endpush
