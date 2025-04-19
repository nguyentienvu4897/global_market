<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo! Yêu cầu cấp link liên kết affiliate</title>
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
        <div class="info">
            <div class="header">Các link gốc affiliate cần được xử lý.</div>
            <div>Khách hàng: <strong>{{ $user->name }}</strong> - SĐT: <strong>{{ $user->phone_number }}</strong></div>
            <div>
                <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                    <thead>
                        <tr>
                            <th style="width: 10%; text-align: center; border: 1px solid #ddd;">STT</th>
                            <th style="width: 20%; text-align: center; border: 1px solid #ddd;">Chiến dịch</th>
                            <th style="width: 70%; text-align: center; border: 1px solid #ddd;">Link gốc</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arrGenerateLink as $index => $item)
                            @php
                                $campaign = array_find_el(\App\Model\Admin\AffiliateLinkRequest::CAMPAIGNS, function ($el) use ($item) {
                                    return $el['id'] == $item['campaign_id'];
                                })['name'];
                            @endphp
                            <tr>
                                <td style="text-align: center; border: 1px solid #ddd;">{{ $index + 1 }}</td>
                                <td style="text-align: center; border: 1px solid #ddd;">{{ $campaign }}</td>
                                <td style="text-align: left; word-break: break-all; border: 1px solid #ddd;">
                                    <a href="{{ $item['url_origin'] }}" target="_blank">{{ $item['url_origin'] }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
