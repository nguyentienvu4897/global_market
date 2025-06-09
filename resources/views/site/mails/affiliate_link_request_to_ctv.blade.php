<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
            line-height: 1.6;
        }

        .highlight {
            color: #800080;
        }

        .link {
            color: #0000EE;
            text-decoration: none;
        }

        .bold {
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .footer a {
            color: #0000EE;
            text-decoration: none;
        }

        .important {
            font-weight: bold;
            color: #000;
        }

        .emoji {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <p>Kính gửi Cộng tác viên <strong>{{ $ctv_user->name }}</strong>,</p>

    <p>Bạn ơi! Có khách hàng đề xuất sản phẩm trên sàn <strong>{{$object->campaign_name}}</strong>, bạn nhanh chóng đăng tải thông tin để tăng thêm thu nhập.</p>

    <p>
        <span class="emoji">👉</span>
        <span class="important">Link sản phẩm :</span><br>
        <a class="link"
            href="{{$object->url_origin}}"
            target="_blank">
            {{$object->url_origin}}
        </a>
    </p>

    <p class="highlight">
        {{$config->web_title}} chúc bạn may mắn và thành công!
    </p>

    <p class="highlight">
        Nếu bạn cần thêm thông tin hoặc hỗ trợ thêm, Hãy liên hệ lại với chúng tôi qua thông tin liên lạc bên dưới.
    </p>

    <p class="highlight">
        Một lần nữa, cảm ơn bạn đã tin tưởng và lựa chọn {{$config->web_title}}.
    </p>

    <div class="footer">
        <p>Trân trọng,<br>
            {{$config->web_title}}<br>
            {{$config->short_name_company}}<br>
            Website: <a href="https://globalmarket.com.vn" target="_blank">https://globalmarket.com.vn</a><br>
            SĐT: <a href="tel:{{str_replace(' ', '', $config->hotline)}}"><strong>{{$config->hotline}}</strong></a><br>
            Email: <a href="mailto:{{$config->email}}">{{$config->email}}</a></p>
    </div>
</body>

</html>
