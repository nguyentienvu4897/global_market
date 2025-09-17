# 🔧 Hướng dẫn xử lý lỗi "Too many connections"

## 🚨 Lỗi hiện tại
```
SQLSTATE[HY000] [1040] Too many connections (SQL: select * from `configs` where `id` = 1 limit 1)
```

## ✅ Các bước đã thực hiện

### 1. Cấu hình Connection Pooling
- ✅ Thêm cấu hình pool trong `config/database.php`
- ✅ Giới hạn max_connections = 10
- ✅ Cấu hình timeout và idle time

### 2. Chuyển Queue sang Redis
- ✅ Thay đổi `QUEUE_CONNECTION=redis` trong `config/queue.php`
- ✅ Giảm tải cho database

### 3. Tạo các công cụ quản lý
- ✅ `DatabaseConnectionManager` middleware
- ✅ `CheckDatabaseConnections` command
- ✅ `CleanupDatabaseConnections` command
- ✅ `DatabaseConnectionService` service

## 🛠️ Các bước triển khai

### Bước 1: Cấu hình MySQL Server
```bash
# Chỉnh sửa file cấu hình MySQL
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf

# Thêm các dòng sau:
max_connections = 200
wait_timeout = 300
interactive_timeout = 300
max_connect_errors = 1000000
connect_timeout = 10
net_read_timeout = 30
net_write_timeout = 30

# Restart MySQL
sudo systemctl restart mysql
```

### Bước 2: Cấu hình Redis
```bash
# Cài đặt Redis (nếu chưa có)
sudo apt-get install redis-server

# Cấu hình Redis
sudo nano /etc/redis/redis.conf

# Thêm:
maxmemory 256mb
maxmemory-policy allkeys-lru

# Restart Redis
sudo systemctl restart redis
```

### Bước 3: Cập nhật .env
```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=global_market
DB_USERNAME=root
DB_PASSWORD=your_password

# Queue (chuyển sang Redis)
QUEUE_CONNECTION=redis

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0
```

### Bước 4: Chạy các lệnh kiểm tra
```bash
# Kiểm tra kết nối database
php artisan db:check-connections

# Dọn dẹp kết nối không cần thiết
php artisan db:cleanup-connections

# Chạy queue worker
php artisan queue:work redis --tries=3 --timeout=90
```

## 🔍 Giám sát và theo dõi

### 1. Kiểm tra tình trạng database
```bash
# Xem số kết nối hiện tại
mysql -u root -p -e "SHOW STATUS LIKE 'Threads_connected';"

# Xem các kết nối đang chạy
mysql -u root -p -e "SHOW PROCESSLIST;"

# Xem cấu hình max_connections
mysql -u root -p -e "SHOW VARIABLES LIKE 'max_connections';"
```

### 2. Sử dụng Artisan commands
```bash
# Kiểm tra health database
php artisan db:check-connections

# Dọn dẹp kết nối idle
php artisan db:cleanup-connections --force
```

### 3. Log monitoring
```bash
# Theo dõi log database
tail -f storage/logs/laravel.log | grep -i "database\|connection"

# Theo dõi log MySQL
sudo tail -f /var/log/mysql/error.log
```

## 🚨 Xử lý khẩn cấp

### Khi gặp lỗi "Too many connections":

1. **Kiểm tra ngay lập tức:**
```bash
php artisan db:check-connections
```

2. **Dọn dẹp kết nối:**
```bash
php artisan db:cleanup-connections --force
```

3. **Restart queue workers:**
```bash
php artisan queue:restart
```

4. **Nếu vẫn lỗi, restart MySQL:**
```bash
sudo systemctl restart mysql
```

## 📊 Các chỉ số cần theo dõi

- **Threads_connected**: Số kết nối hiện tại
- **Max_connections**: Giới hạn kết nối tối đa
- **Usage percentage**: % sử dụng kết nối
- **Idle connections**: Kết nối không hoạt động
- **Response time**: Thời gian phản hồi database

## 🔧 Tối ưu hóa thêm

### 1. Sử dụng Database Transactions đúng cách
```php
DB::beginTransaction();
try {
    // Your database operations
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    throw $e;
}
```

### 2. Sử dụng Connection Pooling
```php
// Sử dụng connection pool
DB::connection('mysql')->transaction(function () {
    // Your operations
});
```

### 3. Cache kết quả query
```php
$result = Cache::remember('expensive_query', 300, function () {
    return DB::table('large_table')->get();
});
```

## 📞 Liên hệ hỗ trợ

Nếu vẫn gặp vấn đề, vui lòng:
1. Chạy `php artisan db:check-connections`
2. Gửi kết quả log
3. Mô tả tình huống xảy ra lỗi
