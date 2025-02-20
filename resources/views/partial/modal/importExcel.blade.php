<style>
	[data-toggle="collapse"] .fa:before {
		content: "\f1de";
	}

	[data-toggle="collapse"].collapsed .fa:before {
		content: "\f1de";
	}
</style>
<div class="modal fade" id="import-excel" ng-controller="ImportExcel">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="import-excel-form">
				<div class="modal-header">
					<h4 class="modal-title">Import Excel</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
                    <div class="row" ng-if="note">
                        <div class="col-md-12" style="display: flex; gap: 0px; font-size: 14px; font-style: italic; margin-bottom: 20px;">
                            <div style="width: 100px;"><span style="color: red;">*</span> Lưu ý: </div>
                            <div class="font-style: italic;">
                                <% note %>
                            </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="form-label">Chọn file</label>
						<span class="text-danger">(*)</span>
						<a ng-if="sample" href="<% sample %>" download>(File mẫu)</a>
						<input class="form-control" type="file" name="file" id="excel-file">
						<div ng-if="import_details" class="mt-1">
							<div><b><u>Chi tiết:</u></b></div>
							<div class="text-success"> Đã import thành công: <% import_details.import || 0 %> bản ghi.</div>
							<div class="text-warning"> Đã bỏ qua: <% import_details.skip || 0 %> bản ghi.</div>
							<div class="text-danger">
								<div data-toggle="collapse" data-target="#error-details" class="cursor-pointer collapsed">
									Không hợp lệ: <% import_details.invalid || 0 %> bản ghi
									<i class="fa" aria-hidden="true"></i>
								</div>
								<div class="ml-2 collapse" id="error-details">
									<div ng-repeat="row in import_details.invalid_rows track by $index">
										- Dòng <% row.index %>: <% row.detail %>.
									</div>
								</div>
							</div>
						</div>
						<span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.file">
							<strong><% errors.file[0] %></strong>
						</span>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-success btn-cons" ng-click="import()" ng-disabled="loading">
						<i ng-if="!loading" class="fa fa-save"></i>
						<i ng-if="loading" class="fa fa-spin fa-spinner"></i>
						Import
					</button>
					<a data-dismiss="modal" href="javascript:void()" class="btn btn-danger btn-cons">
						<i class="fa fa-remove"></i> Hủy
					</a>
				</div>
			</form>
		</div>
	</div>
</div>
