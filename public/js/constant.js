const USER_TYPES = [
    { id: 1, name: "Super Admin" },
    { id: 2, name: "Quản trị viên" },
    { id: 10, name: "Khách hàng" },
    { id: 20, name: "Người bán hàng" }
];

const i18nDataTable = {
    processing:
        "<div class = '_loaderContainer'><div class='_loaderOverlay'></div><div class ='_loaderContent'><div class='_loader'><span></span><span></span><span></span><span></span><span></span></div></div></div>",
    search: "Tìm kiếm",
    emptyTable: "Không có dữ liệu",
    info: "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
    infoEmpty: "Đang xem 0 đến 0 trong tổng số 0 mục",
    infoFiltered: "(lọc từ tổng cộng _MAX_ mục)",
    infoPostFix: "",
    thousands: ",",
    lengthMenu: "Xem _MENU_ mục",
    loadingRecords: "Loading...",
    zeroRecords: "Không tìm thấy dữ liệu",
    paginate: {
        first: "Đầu tiên",
        last: "Cuối cùng",
        next: "Sau",
        previous: "Trước"
    }
};

const PAYMENT_METHODS = [
    {id: 1, name: "Tiền mặt"},
    {id: 2, name: "Chuyển khoản"}
];
