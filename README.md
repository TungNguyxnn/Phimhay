   # PhimHay - Website xem phim (Laravel + MySQL)

   ## Yêu cầu
   PHP >= 8.2, Composer, MySQL (khuyên dùng Laragon)

   ## Cài đặt
   1. composer install
   2. copy .env.example .env
   3. php artisan key:generate
   4. Tạo database "phimhay" (utf8mb4_unicode_ci), sửa DB_DATABASE, DB_USERNAME, DB_PASSWORD trong .env
   5. php artisan migrate --seed
   6. php artisan serve  -> mở http://127.0.0.1:8000

   ## Tài khoản demo
   - Admin: admin@phim.test / admin123
   - Thành viên: user@phim.test / 123456