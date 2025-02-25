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
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Xin chào,</div>

        <div class="info">
            <div>Mã OTP của bạn là: <span>{{$otp}}</span> </div>
        </div>
        <div class="note">
            <span style="color: red;">*</span> Lưu ý: <br>
            - OTP này có hiệu lực trong 5 phút. <br>
            - Không chia sẻ OTP này với bất kỳ ai. <br>
            - Mọi chi tiết xin liên hệ: <a href="mailto:{{ $config->email }}">{{ $config->email }}</a>
        </div>
    </div>
</body>
</html>
