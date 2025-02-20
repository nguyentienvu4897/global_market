app
    // filters
    .filter('toDate', function () {
        return function (items) {
            return new Date(items);
        };
    })
    .filter('date_time', function() {
        return function(date) {
            return moment(date).format('DD/MM/YYYY HH:mm');
        }
    })
    .filter('my_number', function () {
        return function (x) {
            if (!x) return 0;
            x = roundNumber(x, 2);
            return x.toLocaleString('en');
        };
    })
    .filter('round_number', function () {
        return function (x) {
            if (!x) return 0;
            x = roundNumber(x, 0);
            return x.toLocaleString('en');
        };
    })
    .filter('makePositive', function() {
        return function(num) { return Math.abs(num); }
    })

    // directive
    .directive('format', ['$filter', function ($filter) {
        return {
            require: '?ngModel',
            link: function (scope, elem, attrs, ctrl) {
                if (!ctrl) return;
                elem.bind('input', function (event) {
                    var input = $(this).val();
                    input = input.replace(/[\D\s\._\-]+/g, "");
                    input = input ? parseInt(input, 10) : 0;
                    $(this).val((input === 0 ? "" : input.toLocaleString("en-US")));
                });
            }
        };
    }])
    .directive('ckEditor', function () {
        return {
            require: '?ngModel',
            scope: {
                height: '@'
            },
            link: function (scope, elm, attr, ngModel) {
                var ck = CKEDITOR.replace(elm[0], {
                    allowedContent: {
                        $1: {
                            // Use the ability to specify elements as an object.
                            elements: CKEDITOR.dtd,
                            attributes: true,
                            styles: true,
                            classes: true
                        }
                    },
                    disallowedContent: 'script; *[on*]',
                    height: scope.height || 350,
                    basicEntities: false,
                    enterMode: CKEDITOR.ENTER_DIV,
                    bodyClass: 'document-editor',
                    extraPlugins: 'tableresize,pastefromword,lineheight',
                    line_height: "1;1.2;1.5;2;3;4",
                    toolbar: [
                        {name: 'document', items: ['Source']},
                        {name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll']},
                        {
                            name: 'clipboard',
                            items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
                        },
                        {name: 'forms', items: ['Checkbox', 'Radio']},
                        {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat']},
                        {
                            name: 'paragraph',
                            items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                        },
                        {name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak']},
                        '/',
                        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize', 'lineheight']},
                        {name: 'colors', items: ['TextColor', 'BGColor']},
                        {name: 'tools', items: ['Maximize']},
                    ],
                });

                if (!ngModel) return;

                ck.on('instanceReady', function () {
                    ck.setData(ngModel.$viewValue);
                });

                function updateModel() {
                    scope.$apply(function () {
                        ngModel.$setViewValue(ck.getData());
                    });
                }

                ck.on('change', updateModel);
                ck.on('key', updateModel);
                ck.on('dataReady', updateModel);
                ck.on('blur', updateModel);

                ck.on('pasteState', function () {
                    scope.$apply(function () {
                        ngModel.$setViewValue(ck.getData());
                    });
                });

                ngModel.$render = function (value) {
                    ck.setData(ngModel.$viewValue);
                };
            }
        };
    })
    .directive('ckEditorPrint', function () {
        return {
            require: '?ngModel',
            link: function (scope, elm, attr, ngModel) {
                var ck = CKEDITOR.replace(elm[0], {
                    allowedContent: {
                        $1: {
                            // Use the ability to specify elements as an object.
                            elements: CKEDITOR.dtd,
                            attributes: true,
                            styles: true,
                            classes: true
                        }
                    },
                    disallowedContent: 'script; *[on*]',
                    height: 350,
                    basicEntities: false,
                    enterMode: CKEDITOR.ENTER_DIV,
                    bodyClass: 'document-editor',
                    extraPlugins: 'tableresize,pastefromword,lineheight',
                    line_height: "1;1.2;1.5;2;3;4",
                    toolbar: [
                        {name: 'document', items: ['Source']},
                        {name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll']},
                        {
                            name: 'clipboard',
                            items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
                        },
                        {name: 'forms', items: ['Checkbox', 'Radio']},
                        {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat']},
                        {
                            name: 'paragraph',
                            items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                        },
                        {name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak']},
                        '/',
                        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize', 'lineheight']},
                        {name: 'colors', items: ['TextColor', 'BGColor']},
                        {name: 'tools', items: ['Maximize']},
                    ],
                    contentsCss: ['/css/yield-css/editor.css'],
                });

                if (!ngModel) return;

                ck.on('instanceReady', function () {
                    ck.setData(ngModel.$viewValue);
                });

                function updateModel() {
                    scope.$apply(function () {
                        ngModel.$setViewValue(ck.getData());
                    });
                }

                ck.on('change', updateModel);
                ck.on('key', updateModel);
                ck.on('dataReady', updateModel);
                ck.on('blur', updateModel);

                ck.on('pasteState', function () {
                    scope.$apply(function () {
                        ngModel.$setViewValue(ck.getData());
                    });
                });

                ngModel.$render = function (value) {
                    ck.setData(ngModel.$viewValue);
                };
            }
        };
    })
    .directive("dateForm", function () {
        return {
            restrict: "A",
            require: "ngModel",
            link: function (scope, element, attr, ngModel) {
                $(element).datetimepicker({
                    timepicker: false,
                    format: "d/m/Y"
                });

                $(element).on("change", function () {
                    let val = $(this).val();
                    scope.$apply(function () {
                        //will cause the ng-model to be updated.
                        setTimeout(() => {
                            ngModel.$setViewValue(val);
                        });
                    });
                });

                if (ngModel) {

                    ngModel.$parsers.push(function (value) {
                        return dateSetter(value);
                    });

                    ngModel.$formatters.push(function (value) {
                        return dateGetter(value);
                    });

                }
            }
        };
    })
    .directive("currency", function () {
        return {
            restrict: "A",
            require: "ngModel",
            link: function (scope, element, attr, ngModel) {

                $(element).on("change input keyup", function () {
                    let val = $(this).val();
                    scope.$apply(function () {
                        setTimeout(() => {
                            ngModel.$modelValue = val;
                        });
                    });
                });

                if (ngModel) {

                    ngModel.$parsers.push(function (value) {
                        // console.log(value)
                        return parseNumberString(value);
                    });

                    ngModel.$formatters.push(function (value) {
                        return value != null ? Number(value).toLocaleString('en') : '';
                    });

                }
            }
        };
    })
    .directive("ngSelect2", function ($timeout) {
        return {
            restrict: 'AC',
            require: 'ngModel',
            link: function (scope, element, attrs) {

                $timeout(function () {
                    $(element).select2();
                });

                var refreshSelect = function () {
                    if (!element.select2Initialized) return;
                    $timeout(function () {
                        element.trigger('change');
                    });
                };

                scope.$watch(attrs.ngModel, refreshSelect);
            }
        };
    })
    .directive("ngTaginput", function ($timeout) {
        return {
            restrict: 'AC',
            require: 'ngModel',
            link: function (scope, element, attrs) {

                $timeout(function () {
                    $(element).tagsinput();
                });

            }
        };
    })
    // .directive("onlyNumber", function ($timeout) {
    //     return {
    //         restrict: 'EA',
    //         require: 'ngModel',
    //         link: function (scope, element, attrs, ngModel) {
    //             function removeTrailingZeros(value) {
    //                 if (value && value.includes(".")) {
    //                     let parts = String(value).split(".");
    //                     parts[1] = parts[1].replace(/0+$/, ""); // Loại bỏ số 0 cuối
    //                     if (!parts[1]) return parts[0]; // Nếu không còn phần thập phân, chỉ giữ phần nguyên
    //                     return parts.join(".");
    //                 }
    //                 return value;
    //             }
    //             function formatWithCommas(value) {
    //                 if (value == null || value === "") return value;
    //                 let parts = String(value).split(".");
    //                 parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Chèn dấu phẩy vào phần nguyên
    //                 return parts.join(".");
    //             }

    //             function removeCommas(value) {
    //                 return String(value).replace(/,/g, "");
    //             }

    //             // Xử lý giá trị ban đầu khi directive được khởi tạo
    //             $timeout(function () {
    //                 let initialValue = removeTrailingZeros(ngModel.$modelValue);
    //                 if (initialValue !== ngModel.$modelValue) {
    //                     ngModel.$setViewValue(formatWithCommas(initialValue));
    //                     ngModel.$render();
    //                 }
    //             });
    //             scope.$watch(attrs.ngModel, function (newValue, oldValue) {
    //                 if (newValue) {
    //                     newValue = removeCommas(newValue); // Loại bỏ dấu phẩy trước khi xử lý
    //                     let spiltArray = String(newValue).split("");

    //                     if (attrs.allowNegative === "false") {
    //                         if (spiltArray[0] === '-') {
    //                             newValue = newValue.replace("-", "");
    //                             ngModel.$setViewValue(removeZeros(newValue));
    //                             ngModel.$render();
    //                         }
    //                     }

    //                     if (attrs.allowDecimal === "false") {
    //                         newValue = parseInt(newValue);
    //                         ngModel.$setViewValue(removeZeros(newValue));
    //                         ngModel.$render();
    //                     }

    //                     if (attrs.allowDecimal !== "false") {
    //                         if (attrs.decimalUpto) {
    //                             let n = String(newValue).split(".");
    //                             if (n[1]) {
    //                                 let n2 = n[1].slice(0, attrs.decimalUpto);
    //                                 newValue = [n[0], n2].join(".");
    //                                 ngModel.$setViewValue(removeZeros(newValue));
    //                                 ngModel.$render();
    //                             }
    //                         }
    //                     }

    //                     if (attrs.allowDecimal !== "false") {
    //                         if (attrs.decimalUpto2) {
    //                             let n = String(newValue).split(".");
    //                             if (n[1]) {
    //                                 let n2 = n[1].slice(0, attrs.decimalUpto2);
    //                                 newValue = [n[0], n2].join(".");
    //                                 ngModel.$setViewValue(newValue);
    //                                 ngModel.$render();
    //                             }
    //                         }
    //                     }

    //                     if (attrs.maxValue) {
    //                         newValue = Number(newValue);
    //                         const maxValue_ = Number(attrs.maxValue);
    //                         if (newValue > maxValue_) {
    //                             newValue = maxValue_;
    //                             ngModel.$setViewValue(removeZeros(newValue));

    //                             ngModel.$render();
    //                         }
    //                     }

    //                     if (spiltArray.length === 0) return;
    //                     if (spiltArray.length === 1 && (spiltArray[0] === '-' || spiltArray[0] === '.')) return;
    //                     if (spiltArray.length === 2 && newValue === '-.') return;

    //                     /*Check it is number or not.*/
    //                     if (isNaN(newValue)) {
    //                         ngModel.$setViewValue(oldValue || '');
    //                     } else {
    //                         ngModel.$setViewValue(formatWithCommas(newValue));
    //                     }

    //                     ngModel.$render();
    //                 }
    //             });
    //             // Xử lý loại bỏ số 0 không cần thiết khi rời khỏi ô nhập
    //             element.on("blur", function () {
    //                 let newValue = removeTrailingZeros(removeCommas(ngModel.$viewValue));
    //                 if (newValue !== ngModel.$viewValue) {
    //                     ngModel.$setViewValue(formatWithCommas(newValue));
    //                     ngModel.$render();
    //                 }
    //             });
    //         }
    //     };
    // })
    .directive("onlyNumber", function ($timeout) {
        return {
            restrict: 'EA',
            require: 'ngModel',
            link: function (scope, element, attrs, ngModel) {
                function formatWithCommas(value) {
                    if (!value || isNaN(value)) return value;
                    let parts = String(value).split(".");
                    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Thêm dấu phẩy vào phần nguyên
                    return parts.join(".");
                }

                function removeCommas(value) {
                    return String(value).replace(/,/g, "");
                }

                function validateAndFormat(value) {
                    let rawValue = removeCommas(value); // Loại bỏ dấu phẩy để xử lý
                    if (!rawValue || isNaN(rawValue)) return "";

                    // Nếu không cho phép số âm
                    if (attrs.allowNegative === "false" && rawValue.startsWith("-")) {
                        rawValue = rawValue.replace("-", "");
                    }

                    // Nếu không cho phép số thập phân
                    if (attrs.allowDecimal === "false") {
                        rawValue = parseInt(rawValue);
                    }

                    // Giới hạn số thập phân
                    if (attrs.allowDecimal !== "false" && attrs.decimalUpto) {
                        let parts = String(rawValue).split(".");
                        if (parts[1]) {
                            parts[1] = parts[1].slice(0, attrs.decimalUpto);
                            rawValue = parts.join(".");
                        }
                    }

                    // Loại bỏ số 0 không cần thiết ở phần thập phân
                    // if (String(rawValue).includes(".")) {
                    //     rawValue = rawValue.replace(/(\.\d*?[1-9])0+$/, "$1"); // Bỏ số 0 thừa ở cuối
                    //     rawValue = rawValue.replace(/\.0+$/, ""); // Nếu chỉ còn lại `.0` thì loại bỏ cả dấu `.`
                    // }

                    // Giới hạn giá trị tối đa
                    if (attrs.maxValue && parseFloat(rawValue) > parseFloat(attrs.maxValue)) {
                        rawValue = attrs.maxValue;
                    }

                    return formatWithCommas(rawValue);
                }

                ngModel.$parsers.push(function (inputValue) {
                    if (!inputValue) return null;

                    let formattedValue = validateAndFormat(inputValue);
                    if (formattedValue !== inputValue) {
                        ngModel.$setViewValue(formattedValue); // Cập nhật giá trị định dạng
                        ngModel.$render();
                    }

                    return removeCommas(formattedValue); // Trả về giá trị không có dấu phẩy cho model
                });

                element.on("blur", function () {
                    let formattedValue = validateAndFormat(ngModel.$viewValue);
                    if (formattedValue !== ngModel.$viewValue) {
                        ngModel.$setViewValue(formattedValue);
                        ngModel.$render();
                    }
                });

                // Xử lý giá trị ban đầu
                $timeout(function () {
                    let formattedValue = validateAndFormat(ngModel.$modelValue);
                    if (formattedValue !== ngModel.$modelValue) {
                        ngModel.$setViewValue(formattedValue);
                        ngModel.$render();
                    }
                });
            }
        };
    })
    .directive('compile', ['$compile', function ($compile) {
        return function(scope, element, attrs) {
            scope.$watch(
                function(scope) {
                    // watch the 'compile' expression for changes
                    return scope.$eval(attrs.compile);
                },
                function(value) {
                    // when the 'compile' expression changes
                    // assign it into the current DOM
                    element.html(value);

                    // compile the new DOM and link it to the current
                    // scope.
                    // NOTE: we only compile .childNodes so that
                    // we don't get into infinite loop compiling ourselves
                    $compile(element.contents())(scope);
                }
            );
        };
    }])
    .directive('inputGroupPercent', function() {
        return {
            restrict: 'E',
            scope: {
                percent: '=',
                value: '=',
                amount: '=',
                disabled: '='
            },
            link: function(scope) {
                scope.initComponent = true;
                if (!scope.amount) scope.amount = 0;
                scope.currentChange = '';
                scope.updatePercent = function () {
                    if (scope.currentChange === 'percent') {
                        if (scope.percent >= 100) scope.percent = 100;
                        scope.amount = Math.round(scope.percent * scope.value / 100)
                    }
                }

                scope.updateAmount = function () {
                    if (scope.currentChange === 'amount') {
                        if (scope.amount >= scope.value) scope.amount = scope.value;
                        scope.percent = scope.amount / scope.value * 100;
                    }
                }

                scope.$watch('value', function () {
                    if (scope.percent && scope.value && !scope.initComponent) {
                        scope.amount = Math.round(scope.percent * scope.value / 100)
                    } else {
                        scope.initComponent = false
                    }
                })
            },
            template: `
                <div class="input-group mb-0">
                    <input class="form-control text-right" type="text"
                           only-number decimal-upto="2" ng-change="updatePercent()" ng-keypress="currentChange = 'percent'"
                           ng-model="percent" ng-disabled="disabled">
                    <span class="input-group-addon"> % </span>
                    <input class="form-control text-right" currency type="text"
                            ng-change="updateAmount()" ng-model="amount" ng-keypress="currentChange = 'amount'"
                            ng-disabled="disabled">
                    <span class="help-block"></span>
                </div>
            `
        };
    })

