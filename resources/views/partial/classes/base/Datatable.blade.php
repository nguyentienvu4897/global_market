@if (Auth::guard('admin')->check() || Auth::guard('client')->check())
<script>
    class DATATABLE {
    constructor(id, options = {}) {
        this.id = id;
        this.options = options;
        this.datatable = this.initDatatable();
    }

    static mergeSearch(object, context) {
        let id = context.nTable.id;
        $(`#${id}_wrapper .search-column [data-column]`).each(function() {
            if ($(this).data('column')) {
                let column = $(this).data('column');
                object[column] = $(this).val();
            }
        })
        object.startDate = $(`#${id}_wrapper .search-column .startDate`).val() ? moment($(`#${id}_wrapper .search-column .startDate`).val(), 'DD/MM/YYYY').format('YYYY-MM-DD') : '';
        object.endDate = $(`#${id}_wrapper .search-column .endDate`).val() ? moment($(`#${id}_wrapper .search-column .endDate`).val(), 'DD/MM/YYYY').format('YYYY-MM-DD') : '';
    }

    resetSearch() {
        let id = this.id;
        $(`#${id}_wrapper .search-column [data-column]`).each(function() {
            $(this).val('');
        })
        $(`#${id}_wrapper .search-column .startDate`).val('');
        $(`#${id}_wrapper .search-column .endDate`).val('');
        triggerSelect2();
    }

    saveSearch() {
        let object = {};
        let id = this.id;
        $(`#${id}_wrapper .search-column [data-column]`).each(function() {
            if ($(this).data('column')) {
                let column = $(this).data('column');
                object[column] = $(this).val();
            }
        })
        object.page = this.datatable.page();
        localStorage.setItem(id + "-" + window.location.href, JSON.stringify(object))
    }

    restoreSearch(object) {
        let id = this.id;
        Object.keys(object).forEach((key) => {
            $(`#${id}_wrapper .search-column [data-column=${key}]`).val(object[key]);
        })
        triggerSelect2();
        if (object.page) this.datatable.page(object.page);
        setTimeout(() => this.datatable.draw('page'));
    }

    getSavedSearch() {
        return JSON.parse(localStorage.getItem(this.id + '-' + window.location.href) || '{}');
    }

    datatableInitComplete(self, saved_search) {
        return function () {
            let options = self.options;
            let table = this.api();
            let table_id = this[0].id;
            let has_column_search = false;
            let html = "";

            // if (options.search_by_time || has_column_search || options.create_link || options.act) {
            html += `<div class="row"><div class="col-md-12 mb-2">`;
            html += `<a class="btn btn-primary mr-1" data-toggle="collapse" href="#collapseSearch${self.id}" role="button" aria-expanded="false" aria-controls="collapseSearch${self.id}"><i class="fa fa-sliders-h"></i> Bộ lọc</a>`;

            if (options.create_link) {
                html += `<a class="btn btn-success mr-1" href="${options.create_link}"><i class="fa fa-plus"></i> Tạo mới</a>`;
            }
            if (options.create_modal) {
                html += `<a class="btn btn-success mr-1" href="javascript:void(0)" data-toggle="modal" data-target="#${options.create_modal}">
                    <i class="fa fa-plus"></i> Tạo mới
                </a>`;
            }
            if (options.print_link) {
                html += `<a class="btn btn-primary print-button mr-1" href="${options.print_link}"> <i class ="fa fa-print"></i> In</a>`;
            }
            if (options.export_link) {
                html += `<a class="btn btn-primary export-button mr-1" id="${options.subject !== undefined ? options.subject : ''}" href="${options.export_link}"><i class="fa fa-file"></i> Xuất excel</a>`;
            }
            if (options.export_pdf_link) {
                html += `<a class="btn btn-primary export-pdf-button mr-1" id="${options.subject !== undefined ? options.subject : ''}" href="${options.export_pdf_link}"><i class="fa fa-file"></i> Xuất pdf</a>`;
            }
            if (options.import_link_with_params) {
                html += `<a href="#import-excel" data-toggle="modal" class="btn btn-info"><i class="fa fa-upload"></i> Import excel</a>`;
            }
            if (options.create_modal_2) {
                html += `<a class="btn btn-success create-modal" href="javascript:void(0)">
                    <i class="fa fa-plus"></i> Tạo mới
                </a>`;
            }
            if (options.act) {
                html += `
                <button class="btn btn-info dropdown-toggle btn-remove" type="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Thao tác
                <div class="dropdown-menu">`;
                    if (options.act.remove) {
                        html += `<a href="javascript:void(0)" title="" class="dropdown-item act-remove" onclick="removeArr();"><i class="fa fa-trash"></i> Xóa</a>`;
                    }
                html += `</div>
                </button>`;
            }
            html += `</div></div>`;
            // }
            html += `<div class="row">`;
            html += `<div class="col-md-12">`;
            html += `<div class = "search-wrap collapse" id="collapseSearch${self.id}">`;
            html += `<div class="row search-column">`;
            if (options.search_by_time) {
                html += `<div class="col-md-3">
                    <div class="form-group">
                        <input id="startDate" type="text" class="form-control startDate date" placeholder="Từ ngày">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input id="endDate" type="text" class="form-control endDate date" placeholder="Đến ngày">
                    </div>
                </div>`;
            }

            (options.search_columns || []).forEach(col => {
                if (col.search_type) {
                    has_column_search = true;
                    if (col.search_type == 'text') {
                        html += `<div class="col-md-3">
                            <input type="text" class="form-control" data-column="${col.data}" placeholder="${col.placeholder}">
                        </div>`;
                    } else if (col.search_type == 'select') {
                        html += `<div class="col-md-3">
                            <div class="form-group custom-group">
                            <select class="form-control select2-dynamic" data-column="${col.data}">
                                <option value="">${col.placeholder}</option>`;
                        (col.column_data || []).forEach(function (el) {
                            if (typeof el == 'string') html += '<option value="' + el + '">' + el + '</option>';
                            else html += '<option value="' + el.id + '">' + el.name + '</option>';
                        });
                        html += `</select></div></div>`;
                    } else if (col.search_type == 'date') {
                        html += `<div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control date" data-column="${col.data}" placeholder="${col.placeholder}">
                            </div>
                        </div>`;
                    }
                }
            })
            if (options.search_by_time || has_column_search) {
                html += `<div class="col-md-3">
                    <button class="btn btn-primary search-button mr-1"><i class="fa fa-search"></i></button>
                    <button class="btn btn-success refresh-button mr-1"><i class="fas fa-sync"></i></button>
                </div>`;
            }
            html += "</div></div></div></div>";
            $(`#${table_id}_wrapper`).prepend(html);
            $(`#${table_id}_wrapper .search-column`).on('change', 'select', function () {
                if(this.value.length >= 3) {
                    table.draw();
                }
            });
			$(`#${table_id}_wrapper .search-column`).on('blur', 'input', function () {
                if(this.value.length >= 3) {
                    table.draw();
                }
            });
            $(`#${table_id}_wrapper .search-column`).on('keyup change clear', 'input, select', function () {
                if (this.timeOut) clearTimeout(this.timeOut);
                this.timeOut = setTimeout(() => table.draw(), 500)
                ;
            });

            // self.restoreSearch(saved_search);
        }
    }

    initDatatable() {
        let self = this;
        let tableElement = $(`#${this.id}`);
        tableElement.addClass('table table-hover table-condensed table-responsive table-bordered table-head-border');
        let saved_search = this.getSavedSearch();
        let datatable = tableElement.DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [],
            sDom: 'ltrip',
            language: i18nDataTable,
            bLengthChange: false,
            initComplete: this.datatableInitComplete(self, saved_search),
            drawCallback: function() {
                self.saveSearch();
            },
            ...this.options
        });

        $(`#${this.id}_wrapper`).parent().on('click', '.search-button, #search-button', function() {
            datatable.draw();
        })

        $(`#${this.id}_wrapper`).parent().on('click', '.refresh-button, #refresh-button', function() {
            self.resetSearch();
            datatable.draw();
        })

        return datatable;
    }

    setOptions(select, options, holder) {
        $(select).html('');
        let html = `<option value="">${holder}</option>`;
        options.forEach(o => {
            html += `<option value="${o.id}">${o.name}</option>`;
        })
        $(select).html(html);
        $(select).val('');
        $(select).trigger('change');
    }
}
</script>
@endIf
