@extends('layouts.main')

@section('css')
@endsection

@section('page_title')
Quản lý yêu cầu đăng kí bán hàng
@endsection

@section('title')
    Quản lý yêu cầu đăng kí bán hàng
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
            {data: 'shop_name', title: 'Tên shop'},
            {data: 'email', title: 'Email'},
            {data: 'status', title: 'Trạng thái'},
            {data: 'created_at', title: 'Ngày tạo'},
            {data: 'approved_by', title: 'Người duyệt'},
            {data: 'approved_at', title: 'Ngày duyệt'},
            {data: 'action', orderable: false, title: "Hành động"}
        ],
        search_columns: [
            {data: 'shop_name', search_type: "text", placeholder: "nhập tên shop"},
            {data: 'email', search_type: "text", placeholder: "nhập email"},
        ],
    }).datatable;

    createReviewCallback = (response) => {
        datatable.ajax.reload();
    }

</script>


@include('partial.confirm')
@endsection
