<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c3e50;
        }
        p {
            font-size: 16px;
        }
        .reset-button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .reset-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Chào {{ $user->name }},</p>
        <p>Chúng tôi đã nhận được yêu cầu lấy lại mật khẩu của bạn. Dưới đây là mật khẩu mới của bạn:</p>
        <h3>{{ $new_password }}</h3>
        <p>Vui lòng giữ mật khẩu này an toàn và bảo mật. Nếu bạn không yêu cầu lấy lại mật khẩu, vui lòng bỏ qua email này.</p>
        <p>Trân trọng,<br>Đội ngũ hỗ trợ</p>
    </div>
</body>
</html>
