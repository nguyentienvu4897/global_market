<script>
$(document).on('click', 'a.delete', function($event, confirm) {
    var self = this;
    $event.preventDefault();
    swal({
        title: "Xác nhận xóa!",
        text: "Bạn chắc chắn muốn xóa bản ghi này?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Xác nhận",
        cancelButtonText: "Hủy",
        closeOnConfirm: false
    }, function(isConfirm) {
        if (isConfirm) {
            window.location.href = $(self).attr("href");
        }
    })
})
$(document).on('click', 'a.confirm', function($event, confirm) {
    var self = this;
    $event.preventDefault();
    swal({
        title: "Xác nhận!",
        text: "Bạn chắc chắn muốn thực hiện hành động này?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Xác nhận",
        cancelButtonText: "Hủy",
        closeOnConfirm: false
    }, function(isConfirm) {
        if (isConfirm) {
            window.location.href = $(self).attr("href");
        }
    })
})
$(document).on('click', 'a.approve', function($event, confirm) {
    var self = this;
    $event.preventDefault();
    swal({
        title: "Xác nhận duyệt!",
        text: "Bạn chắc chắn muốn duyệt yêu cầu này?",
        type: "success",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Xác nhận",
        cancelButtonText: "Hủy",
        closeOnConfirm: false
    }, function(isConfirm) {
        if (isConfirm) {
            window.location.href = $(self).attr("href");
        }
    })
})
$(document).on('click', 'a.reject', function($event, confirm) {
    var self = this;
    $event.preventDefault();
    swal({
        title: "Xác nhận từ chối!",
        text: "Bạn chắc chắn muốn từ chối yêu cầu này?",
        type: "danger",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Xác nhận",
        cancelButtonText: "Hủy",
        closeOnConfirm: false
    }, function(isConfirm) {
        if (isConfirm) {
            window.location.href = $(self).attr("href");
        }
    })
})

</script>
