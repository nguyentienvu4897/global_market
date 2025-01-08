<div id="show-order-detail-popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="show-order-detail-popup" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết đơn hàng</h5>
            </div>
            <div class="modal-body">
                <div id="show-order-detail-content">
                    <div class="row" style="font-size: 14px">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Mã đơn hàng: <% detail.code %> </label>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Địa chỉ giao hàng: <% detail.customer_address %> </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tổng tiền: <% detail.total_price | number %></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Phương thức thanh toán: <% detail.payment_method_name %></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Trạng thái: <span ng-bind-html="detail.status"></span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Yêu cầu khác: </label>
                                        <textarea id="my-textarea" class="form-control" rows="2" style="height: 50px; min-height: 50px !important; padding: 0 15px;"><% form.customer_required %></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 table-responsive-scroll" style="margin-top: 20px">
                            <table class="table table-bordered table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th><b>STT</b></th>
                                    <th><b>Tên hàng hóa</b></th>
                                    <th><b>Phân loại</b></th>
                                    <th><b>Giá tiền</b></th>
                                    <th><b>Số lượng đặt mua</b></th>
                                    <th><b>Thành tiền</b></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="item in detail.details track by item.id">
                                    <td class="text-center"><% $index + 1 %></td>
                                    <td class="text-center"><% item.product.name %></td>
                                    <td class="text-center">
                                        <div ng-repeat="attribute in item.attributes">
                                            <% attribute.name %> : <span style="font-weight: 600; font-size: 14px;"><% attribute.value %></span>
                                        </div>
                                    </td>
                                    <td class="text-center"><% item.product.price | number %></td>
                                    <td class="text-center"><% item.qty | number %></td>
                                    <td class="text-right"><% (item.qty * item.product.price) | number %></td>

                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><b>Tổng thành tiền: </b></td>
                                    <td class="text-right"><b><% detail.total_before_discount | number %></b></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><b>Giảm giá: </b><br>
                                        <span ng-if="detail.discount_code" class="text-danger">
                                            <i class="fa fa-tag"></i> <% detail.discount_code ? 'Voucher: ' + detail.discount_code : '' %>
                                        </span>
                                    </td>
                                    <td class="text-right"><b><% detail.discount_value | number %></b></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><b>Thành tiền sau giảm: </b></td>
                                    <td class="text-right"><b><% detail.total_after_discount | number %></b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 text-right">
                            <a ng-click="closeModal()" class="btn btn-danger btn-cons" data-bs-dismiss="modal">
                                <i class="fa fa-close"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #show-order-detail-popup .btn.btn-danger {
        background-color: #f44336 !important;
        color: #fff !important;
    }
    @media (max-width: 768px) {
        #show-order-detail-popup .table-responsive-scroll {
            max-width: 100%; /* Đảm bảo không vượt quá chiều rộng của popup */
            overflow-x: auto; /* Bật cuộn ngang */
            -webkit-overflow-scrolling: touch; /* Cải thiện cuộn trên thiết bị di động */
        }

        #show-order-detail-popup .table-responsive-scroll table {
            white-space: nowrap; /* Giữ nguyên nội dung trong cùng một dòng */
        }
    }
</style>
