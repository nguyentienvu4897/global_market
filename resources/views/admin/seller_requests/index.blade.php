@extends('layouts.main')

@section('css')
@endsection

@section('page_title')
Quản lý yêu cầu đăng ký cộng tác viên
@endsection

@section('title')
    Quản lý yêu cầu đăng ký cộng tác viên
@endsection

@section('buttons')
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="SellerRequest">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table-list">
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
    let datatable = new DATATABLE('table-list', {
        ajax: {
            url: '{!! route('seller-requests.searchData') !!}',
            data: function (d, context) {
                DATATABLE.mergeSearch(d, context);
            }
        },
        columns: [
            {data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'campaign', title: 'Sàn TMĐT'},
            {data: 'email', title: 'Email'},
            {data: 'status', title: 'Trạng thái'},
            {data: 'created_at', title: 'Ngày yêu cầu'},
            {data: 'approved_by', title: 'Người duyệt'},
            {data: 'approved_at', title: 'Ngày duyệt'},
            {data: 'action', orderable: false, title: "Hành động"}
        ],
        search_columns: [
            {data: 'campaign_id', search_type: "select", placeholder: "Chọn sàn TMĐT", column_data: @json(App\Model\Admin\AffiliateLinkRequest::CAMPAIGNS)},
            {data: 'email', search_type: "text", placeholder: "Nhập email"},
            {data: 'status', search_type: "select", placeholder: "Chọn trạng thái", options: {
                '0': 'Chưa duyệt',
                '1': 'Đã duyệt',
                '2': 'Từ chối',
            }},
        ],
    }).datatable;

    createReviewCallback = (response) => {
        datatable.ajax.reload();
    }

</script>


@include('partial.confirm')
@endsection
