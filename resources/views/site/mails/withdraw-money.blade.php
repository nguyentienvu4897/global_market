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
        .balance {
            display: flex;
            justify-content: space-between;
        }
        .balance div {
            width: 30%;
            text-align: center;
        }
        .balance div span {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555555;
        }
        .balance div .balance-value {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
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
        <div class="header">Yêu cầu rút tiền</div>
        <div class="note">
            <span style="color: red;">*</span> Lưu ý: <br>
            - Số tiền rút tối thiểu là 100.000 VNĐ <br>
            - Nếu chưa có thông tin chuyển khoản, vui lòng quay lại trang thông tin tài khoản để cập nhật
        </div>
        <div class="info">
            <div><span>Họ tên:</span> {{$user->name}}</div>
            <div><span>Số điện thoại:</span> {{$user->phone_number}}</div>
            <div><span>Email:</span> {{$user->email}}</div>
            <div><span>Chủ tài khoản:</span> {{$user->bank_account_name}}</div>
            <div><span>Số tài khoản:</span> {{$user->bank_account_number}}</div>
            <div><span>Tên ngân hàng:</span> {{$user->bank_name}}</div>
        </div>
        <div class="balance">
            <div>
                <span>Tổng hoa hồng</span>
                <span class="balance-value">{{formatCurrency($data['revenueAmount'])}}</span>
            </div>
            <div>
                <span>Số dư hiện có</span>
                <span class="balance-value">{{formatCurrency($data['waitingQuyetToanAmount'])}}</span>
            </div>
            <div>
                <span>Số tiền cần rút</span>
                <span class="balance-value">{{formatCurrency($data['withdrawAmount'])}}</span>
            </div>
            <div>
                <span>Số tiền còn lại</span>
                <span class="balance-value">{{formatCurrency($data['remainingAmount'])}}</span>
            </div>
        </div>
        <div style="text-align: center;">
            <a href="{{route('Report.revenueReport')}}" class="btn-primary">Đi tới quyết toán</a>
        </div>
    </div>
</body>
</html>
