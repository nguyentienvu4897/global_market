@extends('layouts.main')

@section('css')
    <style>
        .layout-builder {
            display: flex;
            height: 100vh;
        }

        .preview-column {
            flex: 1;
            padding: 20px;
            background: #f0f0f0;
            overflow-y: auto;
        }

        .config-column {
            width: 400px;
            padding: 10px;
            border-left: 1px solid #ccc;
            background: #fff;
            overflow-y: auto;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .block-item {
            background: white;
            border: 1px solid #ddd;
            cursor: pointer;
            position: relative;
            margin-left: 100px;
            margin-right: 100px;
            padding: 0 8.2%;
        }

        .preview-column.is-responsive .block-item {
            padding: 0 7.6%;
        }

        .block-item.active {
            border: 1px solid #007bff;
        }

        .block-item.active .block-item-title {
            background: #666;
            color: #fff;
        }

        .block-item-title {
            position: absolute;
            top: 0;
            left: -100px;
            font-size: 12px;
            padding: 5px;
            background: #e8e8e8;
            color: #666;
            width: 100px;
            border-top-left-radius: 2px;
            border-bottom-left-radius: 2px;
        }

        .block-item.active .block-item-actions {
            position: absolute;
            right: -50px;
            top: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .block-item-actions {
            display: none;
        }

        .block-item-actions button {
            background: #666;
            color: #fff;
            border: none;
        }

        .block-item-actions button:disabled {
            background: #ccc;
            color: #fff;
        }

        .block-item:hover .block-item-actions button {
            display: block;
        }

        .banner-preview img {
            max-width: 100%;
        }

        .product-preview {
            background: #fff;
            padding: 10px;
        }

        .config-content {
            flex-grow: 1;
        }

        .button-fixed-bottom {
            padding: 15px 0;
            border-top: 1px solid #ccc;
            background: #fff;
        }

        .config-title-block {
            font-size: 16px;
            font-weight: bold;
        }

        .config-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            padding-top: 10px;
        }
    </style>
@endsection

@section('title')
    Trang trí cửa hàng
@endsection

@section('content')
    <div ng-controller="SellerStoreDecoration" ng-cloak>
        <div class="layout-builder">

            <!-- Preview Column -->
            <div class="preview-column" ng-class="{'is-responsive': selectedBlock}">
                <div class="block-item p-0">
                    <img src="/img/page-header.png" alt="Ảnh bìa">
                </div>
                <div ng-repeat="block in blocks track by $index" ng-click="editBlock(block)" class="block-item"
                    ng-class="{'active': block.classActive}">
                    <div ng-include="'templates/' + block.type + '.html'"></div>
                    <div class="block-item-title"><% block.title %></div>
                    <div class="block-item-actions">
                        <button ng-click="moveUp($index); $event.stopPropagation()" ng-disabled="$index === 0">↑</button>
                        <button ng-click="moveDown($index); $event.stopPropagation()" ng-disabled="$index === blocks.length - 1">↓</button>
                        <button ng-click="removeBlock($index); $event.stopPropagation()">🗑</button>
                    </div>
                </div>
            </div>

            <!-- Config Column -->
            <div class="config-column" ng-if="selectedBlock">
                <div class="config-content">
                    <div class="d-flex justify-content-between">
                        <div class="config-title-block"><% selectedBlock.title %> </div>
                        {{-- <div class="cursor-pointer" ng-click="closeConfig()"><i class="fa fa-times"></i></div> --}}
                    </div>
                    <div class="config-description"><% selectedBlock.description %></div>
                    <div ng-include="'forms/' + selectedBlock.type + '-form.html'"></div>
                </div>
                <div class="button-fixed-bottom">
                    <div class="d-flex justify-content-end">
                        {{-- <button class="btn btn-danger mr-2" ng-click="closeConfig()">Đóng</button> --}}
                        <button class="btn btn-success" ng-click="saveBlock(selectedBlock)">Lưu</button>
                    </div>
                </div>
            </div>

        </div>

        @include('admin.seller_stores.decoration_templates')

        @include('admin.seller_stores.decoration_forms')
    </div>
@endsection

@section('script')
    <script>
        app.controller('SellerStoreDecoration', function($scope, $http) {
            $scope.blocks = [
                {
                    type: 'banner',
                    title: 'Ảnh bìa',
                    description: 'Hình ảnh bìa nổi bật sẽ giúp Shop tăng độ nhận diện thương hiệu!',
                    data: {
                        image: 'https://via.placeholder.com/600x200',
                        logo: 'https://via.placeholder.com/600x200'
                    },
                    classActive: true,
                    order: 1
                },
                {
                    type: 'vouchers',
                    title: 'Mã giảm giá',
                    data: {
                        vouchers: []
                    },
                    classActive: false,
                    order: 2
                }
            ];
            $scope.object = @json($object);
            if ($scope.object) {
                $scope.blocks.filter(function(block) {
                    return block.type == 'banner';
                }).forEach(function(block) {
                    block.data.image = $scope.object.banner.path;
                    block.data.logo = $scope.object.logo.path;
                });
            }
            $scope.loading = {
                submit: false
            };

            $scope.selectedBlock = $scope.blocks[0];

            $scope.editBlock = function(block) {
                $scope.selectedBlock = block;
                $scope.blocks.forEach(function(block) {
                    if (block.classActive) {
                        block.classActive = false;
                    }
                });
                $scope.selectedBlock.classActive = true;
                $scope.$applyAsync();
            };

            $scope.closeConfig = function() {
                $scope.selectedBlock = null;
            };

            $scope.moveUp = function(index) {
                if (index > 0) {
                    const tmp = $scope.blocks[index];
                    $scope.blocks[index] = $scope.blocks[index - 1];
                    $scope.blocks[index - 1] = tmp;
                    $scope.blocks.forEach(function(block, index) {
                        block.order = index + 1;
                    });
                }

                $scope.$applyAsync();
            };

            $scope.moveDown = function(index) {
                if (index < $scope.blocks.length - 1) {
                    const tmp = $scope.blocks[index];
                    $scope.blocks[index] = $scope.blocks[index + 1];
                    $scope.blocks[index + 1] = tmp;
                    $scope.blocks.forEach(function(block, index) {
                        block.order = index + 1;
                    });
                }

                $scope.$applyAsync();
            };

            $scope.removeBlock = function(index) {
                $scope.blocks.splice(index, 1);
                $scope.blocks.forEach(function(block, index) {
                    block.order = index + 1;
                });
                $scope.selectedBlock = null;
                $scope.closeConfig();
                $scope.$applyAsync();
            };

            @include('admin.seller_stores.formJs')

            $scope.submit = function() {
                $scope.loading.submit = true;
                let data = $scope.form.submit_data;
                $.ajax({
                    type: 'POST',
                    url: "{!! route('seller-stores.update', $object->id) !!}",
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = "{{ route('seller-stores.index') }}";
                        } else {
                            toastr.warning(response.message);
                            $scope.errors = response.errors;
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.loading.submit = false;
                        $scope.$applyAsync();
                    }
                });
            }

        });
    </script>
@endsection
