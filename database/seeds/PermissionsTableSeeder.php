<?php

use Illuminate\Database\Seeder;
use App\Model\Common\Permission;
use App\Model\Common\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('permission_has_types')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        Cache::flush('spatie.permission.cache');
        Cache::flush('spatie.role.cache');

        Permission::createRecord(['id' => 1, 'name' => 'Thêm danh mục đặc biệt', 'display_name' => 'Tạo mới', 'group' => 'Quản lý danh mục đặc biệt'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 2, 'name' => 'Sửa danh mục đặc biệt', 'display_name' => 'Sửa', 'group' => 'Quản lý danh mục đặc biệt'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 3, 'name' => 'Xóa danh mục đặc biệt', 'display_name' => 'Xóa', 'group' => 'Quản lý danh mục đặc biệt'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 4, 'name' => 'Thêm danh mục hàng hóa', 'display_name' => 'Tạo mới', 'group' => 'Quản lý danh mục hàng hóa'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 5, 'name' => 'Sửa danh mục hàng hóa', 'display_name' => 'Sửa', 'group' => 'Quản lý danh mục hàng hóa'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 6, 'name' => 'Xóa danh mục hàng hóa', 'display_name' => 'Xóa', 'group' => 'Quản lý danh mục hàng hóa'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 7, 'name' => 'Thêm hàng hóa', 'display_name' => 'Tạo mới', 'group' => 'Quản lý hàng hóa'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN, User::NGUOI_BAN_HANG]);
        Permission::createRecord(['id' => 8, 'name' => 'Sửa hàng hóa', 'display_name' => 'Sửa', 'group' => 'Quản lý hàng hóa'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN, User::NGUOI_BAN_HANG]);
        Permission::createRecord(['id' => 9, 'name' => 'Xóa hàng hóa', 'display_name' => 'Xóa', 'group' => 'Quản lý hàng hóa'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN, User::NGUOI_BAN_HANG]);

        Permission::createRecord(['id' => 10, 'name' => 'Thêm thuộc tính hàng hóa', 'display_name' => 'Tạo mới', 'group' => 'Danh mục thuộc tính hàng hóa'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 11, 'name' => 'Sửa thuộc tính hàng hóa', 'display_name' => 'Sửa', 'group' => 'Danh mục thuộc tính hàng hóa'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 12, 'name' => 'Xóa thuộc tính hàng hóa', 'display_name' => 'Xóa', 'group' => 'Danh mục thuộc tính hàng hóa'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 13, 'name' => 'Thêm mã giảm giá', 'display_name' => 'Tạo mới', 'group' => 'Danh mục mã giảm giá'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN, User::NGUOI_BAN_HANG]);
        Permission::createRecord(['id' => 14, 'name' => 'Sửa mã giảm giá', 'display_name' => 'Sửa', 'group' => 'Danh mục mã giảm giá'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN, User::NGUOI_BAN_HANG]);
        Permission::createRecord(['id' => 15, 'name' => 'Xóa mã giảm giá', 'display_name' => 'Xóa', 'group' => 'Danh mục mã giảm giá'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN, User::NGUOI_BAN_HANG]);

        Permission::createRecord(['id' => 16, 'name' => 'Thêm danh mục bài viết', 'display_name' => 'Tạo mới', 'group' => 'Quản lý danh mục bài viết'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 17, 'name' => 'Sửa danh mục bài viết', 'display_name' => 'Sửa', 'group' => 'Quản lý danh mục bài viết'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 18, 'name' => 'Xóa danh mục bài viết', 'display_name' => 'Xóa', 'group' => 'Quản lý danh mục bài viết'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 19, 'name' => 'Thêm bài viết', 'display_name' => 'Tạo mới', 'group' => 'Quản lý bài viết'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 20, 'name' => 'Sửa bài viết', 'display_name' => 'Sửa', 'group' => 'Quản lý bài viết'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 21, 'name' => 'Xóa bài viết', 'display_name' => 'Xóa', 'group' => 'Quản lý bài viết'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 22, 'name' => 'Thêm danh mục chính sách', 'display_name' => 'Tạo mới', 'group' => 'Quản lý danh mục chính sách'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 23, 'name' => 'Sửa danh mục chính sách', 'display_name' => 'Sửa', 'group' => 'Quản lý danh mục chính sách'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 24, 'name' => 'Xóa danh mục chính sách', 'display_name' => 'Xóa', 'group' => 'Quản lý danh mục chính sách'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 25, 'name' => 'Thêm danh mục tag', 'display_name' => 'Tạo mới', 'group' => 'Quản lý danh mục tag'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 26, 'name' => 'Sửa danh mục tag', 'display_name' => 'Sửa', 'group' => 'Quản lý danh mục tag'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 27, 'name' => 'Xóa danh mục tag', 'display_name' => 'Xóa', 'group' => 'Quản lý danh mục tag'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 28, 'name' => 'Thêm danh mục banner trang chủ', 'display_name' => 'Tạo mới', 'group' => 'Quản lý danh mục banner trang chủ'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 29, 'name' => 'Sửa danh mục banner trang chủ', 'display_name' => 'Sửa', 'group' => 'Quản lý danh mục banner trang chủ'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 30, 'name' => 'Xóa danh mục banner trang chủ', 'display_name' => 'Xóa', 'group' => 'Quản lý danh mục banner trang chủ'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 31, 'name' => 'Quản lý danh mục khách hàng liên hệ', 'display_name' => 'Quản lý', 'group' => 'Quản lý danh mục khách hàng liên hệ'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 32, 'name' => 'Quản lý đơn hàng', 'display_name' => 'Quản lý', 'group' => 'Quản lý đơn hàng'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN, User::NGUOI_BAN_HANG]);
        Permission::createRecord(['id' => 33, 'name' => 'Xuất excel đơn hàng', 'display_name' => 'Xuất excel', 'group' => 'Quản lý đơn hàng'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN, User::NGUOI_BAN_HANG]);
        Permission::createRecord(['id' => 34, 'name' => 'Import excel đơn hàng', 'display_name' => 'Import excel', 'group' => 'Quản lý đơn hàng'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN, User::NGUOI_BAN_HANG]);
        Permission::createRecord(['id' => 35, 'name' => 'Xem chi tiết đơn hàng', 'display_name' => 'Xem chi tiết', 'group' => 'Quản lý đơn hàng'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN, User::NGUOI_BAN_HANG]);
        Permission::createRecord(['id' => 36, 'name' => 'Cập nhật trạng thái đơn hàng', 'display_name' => 'Cập nhật trạng thái', 'group' => 'Quản lý đơn hàng'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN, User::NGUOI_BAN_HANG]);

        Permission::createRecord(['id' => 37, 'name' => 'Quản lý yêu cầu affiliate link', 'display_name' => 'Quản lý', 'group' => 'Quản lý yêu cầu affiliate link'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 38, 'name' => 'Cập nhật trạng thái yêu cầu affiliate link', 'display_name' => 'Cập nhật trạng thái', 'group' => 'Quản lý yêu cầu affiliate link'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 39, 'name' => 'Xóa yêu cầu affiliate link', 'display_name' => 'Xóa', 'group' => 'Quản lý yêu cầu affiliate link'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 40, 'name' => 'Quản lý tài khoản người dùng', 'display_name' => 'Quản lý', 'group' => 'Quản lý tài khoản người dùng'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 41, 'name' => 'Thêm mới người dùng', 'display_name' => 'Tạo mới', 'group' => 'Quản lý tài khoản người dùng'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 42, 'name' => 'Cập nhật người dùng', 'display_name' => 'Sửa', 'group' => 'Quản lý tài khoản người dùng'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 43, 'name' => 'Xóa người dùng', 'display_name' => 'Xóa', 'group' => 'Quản lý tài khoản người dùng'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 44, 'name' => 'Quản lý chức vụ', 'display_name' => 'Quản lý', 'group' => 'Quản lý chức vụ'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 45, 'name' => 'Thêm chức vụ', 'display_name' => 'Tạo mới', 'group' => 'Quản lý chức vụ'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 46, 'name' => 'Cập nhật chức vụ', 'display_name' => 'Cập nhật', 'group' => 'Quản lý chức vụ'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
        Permission::createRecord(['id' => 47, 'name' => 'Xóa chức vụ', 'display_name' => 'Xóa', 'group' => 'Quản lý chức vụ'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        Permission::createRecord(['id' => 48, 'name' => 'Cập nhật cấu hình', 'display_name' => 'Cập nhật', 'group' => 'Quản lý cấu hình chung'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);

        // Báo cáo
        Permission::createRecord(['id' => 49, 'name' => 'Xem báo cáo thương hoa hồng', 'display_name' => 'Xem báo cáo thương hoa hồng', 'group' => 'Quản lý báo cáo thống kê'], [User::SUPER_ADMIN, User::QUAN_TRI_VIEN]);
    }
}
