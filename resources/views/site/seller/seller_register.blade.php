<html>

<head>
    @if ($display == 'register')
        <title>Đăng kí bán hàng</title>
    @else
        <title>Đăng nhập kênh bán hàng</title>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="preload" as="script" href="/site/js/jquery.js?1729657650563" />
    <script src="/site/js/jquery.js?1729657650563" type="text/javascript"></script>
    <!-- Angular Js -->
    <script src="{{ asset('libs/angularjs/angular.js?v=222222') }}"></script>
    <script src="{{ asset('libs/angularjs/angular-resource.js') }}"></script>
    <script src="{{ asset('libs/angularjs/sortable.js') }}"></script>
    <script src="{{ asset('libs/dnd/dnd.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.9/angular-sanitize.js"></script>
    <script src="{{ asset('libs/angularjs/select.js') }}"></script>
    <script src="{{ asset('js/angular.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

        * {
            box-sizing: border-box;
        }

        body {
            background: #f6f5f7;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: 'Montserrat', sans-serif;
            height: 100vh;
            margin: -20px 0 50px;
        }

        h1 {
            font-weight: bold;
            margin: 0;
        }

        h2 {
            text-align: center;
        }

        p {
            font-size: 14px;
            font-weight: 100;
            line-height: 20px;
            letter-spacing: 0.5px;
            margin: 20px 0 30px;
        }

        span {
            font-size: 12px;
        }

        a {
            color: #333;
            font-size: 14px;
            text-decoration: none;
            margin: 15px 0;
        }

        button {
            border-radius: 20px;
            border: 1px solid #FF4B2B;
            background-color: #FF4B2B;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
            cursor: pointer;
        }

        button:active {
            transform: scale(0.95);
        }

        button:focus {
            outline: none;
        }

        button.ghost {
            background-color: transparent;
            border-color: #FFFFFF;
        }

        form {
            background-color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }

        .form-group {
            margin: 8px 0;
            width: 100%;
        }

        input {
            background-color: #eee;
            border: none;
            padding: 12px 15px;
            width: 100%;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
                0 10px 10px rgba(0, 0, 0, 0.22);
            position: relative;
            overflow: hidden;
            width: 900px;
            max-width: 100%;
            min-height: 480px;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.right-panel-active .sign-in-container {
            transform: translateX(100%);
        }

        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        @keyframes show {

            0%,
            49.99% {
                opacity: 0;
                z-index: 1;
            }

            50%,
            100% {
                opacity: 1;
                z-index: 5;
            }
        }

        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .overlay {
            background: #FF416C;
            background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
            background: linear-gradient(to right, #FF4B2B, #FF416C);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 0 0;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left {
            transform: translateX(-20%);
        }

        .container.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .container.right-panel-active .overlay-right {
            transform: translateX(20%);
        }

        .social-container {
            margin: 20px 0;
        }

        .social-container a {
            border: 1px solid #DDDDDD;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 5px;
            height: 40px;
            width: 40px;
        }

        footer {
            background-color: #222;
            color: #fff;
            font-size: 14px;
            bottom: 0;
            position: fixed;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 999;
        }

        footer p {
            margin: 10px 0;
        }

        footer i {
            color: red;
        }

        footer a {
            color: #3c97bf;
            text-decoration: none;
        }

        .invalid-feedback {
            color: red;
            font-weight: 400;
        }
    </style>
</head>

<body ng-app="App">
    <div class="container" id="container" ng-controller="SellerRegisterController">
        <div class="form-container sign-up-container" id="sign-up">
            <form id="form-sign-up">
                <h1>Đăng kí</h1>
                <span>Đăng kí bán hàng để bắt đầu bán hàng trên website</span>
                <div class="form-group" style="margin-bottom: 12px;">
                    <input type="checkbox" id="use-account" style="width: 12px; height: 12px;"
                        ng-model="use_account_client" ng-change="changeUseAccountClient()" />
                    <label for="use-account" style="font-size: 13px;">Sử dụng
                        tài khoản mua hàng để đăng kí</label>
                </div>

                <div class="form-group">
                    <input type="text" placeholder="Tên cửa hàng" ng-model="shop_name" />
                    <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                        ng-if="errors && errors['shop_name']">
                        <% errors['shop_name'][0] %>
                    </span>
                </div>
                <div class="form-group">
                    <input type="email" placeholder="Email" ng-model="email" />
                    <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                        ng-if="errors && errors['email']">
                        <% errors['email'][0] %>
                    </span>
                </div>

                <div class="form-group">
                    <input type="text" placeholder="Tên đăng nhập" ng-model="account_name"
                        ng-show="!use_account_client" />
                    <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                        ng-if="errors && errors['account_name']">
                        <% errors['account_name'][0] %>
                    </span>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" ng-model="password" ng-show="!use_account_client" />
                    <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                        ng-if="errors && errors['password']">
                        <% errors['password'][0] %>
                    </span>
                </div>
                <div class="form-group" style="margin-bottom: 12px;">
                    <input type="checkbox" id="agree-terms" style="width: 12px; height: 12px;"
                        ng-model="agree_terms" />
                    <label for="agree-terms" style="font-size: 13px;">Tôi đồng ý với các điều khoản và điều kiện của website</label>
                    <div>
                        <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                            ng-if="errors && errors['agree_terms']">
                            <% errors['agree_terms'][0] %>
                        </span>
                    </div>
                </div>
                <button ng-click="registerSeller()">Đăng kí</button>
            </form>
        </div>
        <div class="form-container sign-in-container" id="sign-in">
            <form id="form-sign-in">
                <h1>Đăng nhập</h1>
                <span>Đăng nhập để tiếp tục bán hàng trên website</span>
                <div class="form-group">
                    <input type="text" placeholder="Email hoặc tên đăng nhập" ng-model="login_email" />
                    <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                        ng-if="errors && errors['login_email']">
                        <% errors['login_email'][0] %>
                    </span>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" ng-model="login_password" />
                    <span class="invalid-feedback d-block error" style="text-align: left;" role="alert"
                        ng-if="errors && errors['login_password']">
                        <% errors['login_password'][0] %>
                    </span>
                </div>
                <a href="#">Quên mật khẩu?</a>
                <button ng-click="signInSeller()">Đăng nhập</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Trở thành người bán hàng ngay hôm nay</h1>
                    <p>Để tiếp tục bán hàng trên website, vui lòng đăng nhập bằng thông tin cá nhân của bạn</p>
                    <button class="ghost" id="signIn">Đăng nhập</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Chào mừng bạn!</h1>
                    <p>Nhập thông tin cá nhân của bạn và bắt đầu hành trình với chúng tôi</p>
                    <button class="ghost" id="signUp">Đăng kí</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        @if (Auth::guard('admin')->check())
            const isAdmin = true;
        @else
            const isAdmin = false;
        @endif

        signUpButton.addEventListener('click', () => {
            if (isAdmin) {
                window.location.href = '{{ route('index') }}';
            } else {
                container.classList.add("right-panel-active");
            }
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });

        @if (Auth::guard('client')->check())
            const DEFAULT_CLIENT_USER = {
                id: "{{ Auth::guard('client')->user()->id }}",
                fullname: "{{ Auth::guard('client')->user()->name }}",
                email: "{{ Auth::guard('client')->user()->email }}"
            };
        @else
            const DEFAULT_CLIENT_USER = null;
        @endif

        app.controller('SellerRegisterController', function($scope) {
            $scope.display = @json($display) ?? '';
            $scope.use_account_client = false;
            $scope.errors = {};

            if ($scope.display == 'register') {
                container.classList.add("right-panel-active");
            }

            if ($scope.display == 'login') {
                container.classList.remove("right-panel-active");
            }

            $scope.changeUseAccountClient = function() {
                if ($scope.use_account_client) {
                    $scope.use_account_client = true;
                    $scope.email = DEFAULT_CLIENT_USER ? DEFAULT_CLIENT_USER.email : '';
                } else {
                    $scope.use_account_client = false;
                    $scope.account_name = '';
                    $scope.password = '';
                }
                $scope.errors = {};
                $scope.$applyAsync();
            };

            $scope.signInSeller = function() {
                let data = {
                    login_email: $scope.login_email,
                    login_password: $scope.login_password,
                };
                $.ajax({
                    url: '{{ route('front.seller-login-submit') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function(response){
                        if(response.success){
                            toastr.success(response.message);
                            window.location.href = '{{ route('index') }}';
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
                });
            };

            $scope.registerSeller = function() {
                let data = {
                    use_account_client: $scope.use_account_client ? 1 : 0,
                    shop_name: $scope.shop_name,
                    email: $scope.email,
                    account_name: $scope.account_name,
                    password: $scope.password,
                    status: 0, // 0: chờ duyệt, 1: đã duyệt, 2: từ chối
                    agree_terms: $scope.agree_terms ? 1 : 0,
                };
                $.ajax({
                    url: '{{ route('front.seller-register-submit') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function(response){
                        if(response.success){
                            toastr.success(response.message);
                            window.location.href = '{{ route('front.seller-register-notice') }}';
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
            };
        });
    </script>
</body>

</html>
