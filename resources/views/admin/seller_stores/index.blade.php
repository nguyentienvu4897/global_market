@extends('layouts.main')

@section('css')
@endsection

@section('page_title')
Quản lý cửa hàng bán hàng
@endsection

@section('title')
    Quản lý cửa hàng bán hàng
@endsection

@section('buttons')
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="SellerStore">
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
            url: '{!! route('seller-stores.searchData') !!}',
            data: function (d, context) {
                DATATABLE.mergeSearch(d, context);
            }
        },
        columns: [
            {data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
            {data: 'shop_name', title: 'Tên shop'},
            {data: 'status', title: 'Trạng thái'},
            {data: 'created_at', title: 'Ngày tạo'},
            {data: 'updated_at', title: 'Ngày cập nhật'},
            {data: 'action', orderable: false, title: "Hành động"}
        ],
        search_columns: [
            {data: 'shop_name', search_type: "text", placeholder: "nhập tên shop"},
        ],
    }).datatable;

    createReviewCallback = (response) => {
        datatable.ajax.reload();
    }

</script>


@include('partial.confirm')
@endsection
