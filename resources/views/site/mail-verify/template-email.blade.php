<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Xác Thực</title>
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
            font-size: 13px;
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
        <div class="header">Xin chào,</div>

        <div class="info">
            <div>Liên kết xác minh email của bạn là: <span>{{$link}}</span> </div>
            <div style="text-align: center;">
                <a href="{{$link}}" class="btn-primary">Xác minh email</a>
            </div>
        </div>
        <div class="note">
            <span style="color: red;">*</span> Lưu ý: <br>
            - Nếu bạn không yêu cầu xác minh email, vui lòng bỏ qua email này. <br>
            - Liên kết xác minh này có hiệu lực trong 10 phút. <br>
            - Nếu liên kết xác minh đã hết hạn, vui lòng gửi lại yêu cầu. <br>
            - Mọi chi tiết xin liên hệ: <a href="mailto:{{ $config->email }}">{{ $config->email }}</a>
        </div>
    </div>
</body>
</html>
