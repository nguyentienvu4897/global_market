<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #ffffff;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333333;
        }

        .note {
            font-size: 12px;
            color: #888888;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info div {
            margin-bottom: 10px;
        }

        .info span {
            font-weight: bold;
            color: #555555;
        }

        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff !important;
            background-color: #007bff !important;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">Yêu cầu đăng ký bán hàng trên website của bạn đã được phê duyệt</div>
        <div class="info">
            <div><span>Tên cửa hàng:</span> {{ $data->shop_name }}</div>
            <div><span>Email đăng ký:</span> {{ $data->email }}</div>
        </div>
        <div style="text-align: center;">
            <a href="{{ route('front.seller-login') }}" class="btn-primary">Đi tới đăng nhập</a>
        </div>
    </div>
</body>

</html>
