<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link rel="icon" href="{{ $config->favicon->path ?? '' }}" type="image/x-icon">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
        }

        .success-icon {
            font-size: 48px;
            color: #28a745;
        }

        .message {
            font-size: 18px;
            color: #333;
        }

        .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            font-weight: bold;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="card">
        <img src="{{ $config->image->path ?? '/site/images/logo.png' }}" alt="Logo công ty" class="logo">
        @if ($status == 'success')
            <div class="success-icon">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" fill="#28a745" />
                    <path d="M8 12.5L10.5 15L16 9.5" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
        @else
            <div class="success-icon">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" fill="#dc3545" />
                    <path d="M15 9L9 15M9 9L15 15" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
        @endif
        <div class="message">
            <h3 style="margin-top: 0;"><strong>{{$title}}</strong></h3>
            <p>{{$content}}</p>
        </div>
        <a href="{{ route('front.client-account') }}" class="button">Quay lại hệ thống</a>
    </div>
</body>

</html>
