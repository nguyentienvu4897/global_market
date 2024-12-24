<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body>
<table class="table" style="width:100%">
    <thead>
    {{-- <tr class="">
        <td colspan="{{$data['COLSPAN']}}" style="text-align: center;"><img alt="" width="{{$data['WIDTH'] ?? 1070}}" src="{{safeImage($data['HEADER'])}}"/>
        </td>
    </tr> --}}
    <tr class="">
        <td colspan="{{$data['COLSPAN']}}" style="text-align: center; font-weight: bold; font-size: 20px;">DANH SÁCH ĐƠN HÀNG
        </td>
    </tr>
    @if(isset($data['FROM_DATE']) && isset($data['TO_DATE']))
    <tr>
        <td colspan="{{$data['COLSPAN']}}" style="text-align: center; font-size: 14px;">Từ ngày: {{$data['FROM_DATE']}} đến ngày: {{$data['TO_DATE']}}
        </td>
    </tr>
    @endif
    </thead>
</table>

{!! $data['CHI_TIET'] !!}

<table class="table" style="width:100%">
    <thead>
        <tr></tr>
        @php
            $colspan = $data['COLSPAN'] / 2;
        @endphp
        <tr>
            <td colspan="{{ $colspan }}" style="text-align: center;"></td>
            <td colspan="{{ $colspan }}" style="text-align: center;">Ngày..... Tháng..... Năm.....</td>
        </tr>
        <tr>
            <td colspan="{{ $colspan }}" style="text-align: center;"><b></b></td>
            <td colspan="{{ $colspan }}" style="text-align: center; font-weight: bold;"><b>Người lập</b></td>
        </tr>
        <tr>
            <td colspan="{{ $colspan }}" style="text-align: center;"></td>
            <td colspan="{{ $colspan }}" style="text-align: center;">(Ký, họ tên)</td>
        </tr>
    </thead>
</table>

</body>
</html>
