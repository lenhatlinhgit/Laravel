# 📌 Hệ thống quản lý bài viết (Laravel)

## 📖 Giới thiệu

Đây là một dự án Laravel xây dựng hệ thống quản lý bài viết đơn giản, bao gồm:

- Đăng nhập / đăng ký tài khoản
- Phân quyền (Admin / User)
- Đổi mật khẩu
- Dashboard quản trị
- CRUD bài viết (thêm, sửa, xóa, xem)
- Soạn thảo nội dung bằng **TinyMCE Rich Text Editor**
- Upload ảnh trực tiếp trong editor
- Upload ảnh nền
- Theo dõi lượt xem bài viết

---

## ⚙️ Công nghệ sử dụng

- **Laravel 13** — framework PHP chính, xử lý routing, controller, model
- **PHP 8+** — ngôn ngữ lập trình backend
- **MySQL** — cơ sở dữ liệu lưu bài viết, người dùng
- **Blade Template** — công cụ tạo giao diện HTML của Laravel, hỗ trợ cú pháp `{{ }}`, `@if`, `@foreach`, `@extends`
- **Vite 8** — công cụ build frontend, dùng để bundle TinyMCE vào `public/build/vendor`
- **TinyMCE v6** — rich text editor self-hosted, soạn thảo nội dung trực tiếp trên trình duyệt, không cần API key
- **mews/purifier** — lọc HTML nguy hiểm (XSS, script độc hại) trước khi lưu vào database
- **CSS custom** — style riêng cho giao diện admin

---

## 🚀 Chức năng chính

### 🔐 Xác thực người dùng

- Đăng ký tài khoản
- Đăng nhập bằng session
- Đăng xuất
- Đổi mật khẩu

---

### 👨‍💼 Admin Dashboard

- Hiển thị thống kê:
    - Tổng số bài viết
    - Số bài viết hôm nay
    - Tổng lượt xem
    - Tổng số người dùng
- Phân quyền admin
- Sử dụng View Composer để truyền dữ liệu global cho layout

---

### 📝 Quản lý bài viết

- Thêm bài viết mới
    - Tiêu đề
    - Địa điểm
    - Tác giả
    - Nội dung soạn thảo bằng TinyMCE (hỗ trợ heading, danh sách, bảng, link, ảnh...)
    - Ảnh nền
- Chỉnh sửa bài viết
- Xóa bài viết
- Xem chi tiết bài viết
- Tự động tăng lượt xem khi truy cập

---

## ✍️ Rich Text Editor (TinyMCE v6)

Nội dung bài viết được soạn thảo trực tiếp trên trình duyệt:

- Định dạng văn bản: bold, italic, underline, heading...
- Danh sách, bảng, link
- Upload ảnh trực tiếp vào bài viết
- Nội dung được lưu dạng HTML vào database
- HTML được sanitize bằng `mews/purifier` trước khi lưu (bảo mật XSS)

---

## 🧠 Cấu trúc bảng posts

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | bigint | Khóa chính |
| title | varchar(255) | Tiêu đề |
| location | varchar(255) | Địa điểm |
| author | varchar(255) | Tác giả |
| content | longtext | Nội dung HTML từ TinyMCE |
| background | varchar(255) | Đường dẫn ảnh nền |
| views | int | Lượt xem |
| dateposted | date | Ngày đăng |
| created_at | timestamp | |
| updated_at | timestamp | |

---

## 🔐 Phân quyền

- **Admin:**
    - Truy cập dashboard
    - Tạo / sửa / xóa bài viết
    - Upload ảnh trong editor
- **User:**
    - Xem bài viết

---

## 📊 Dashboard thống kê

Hiển thị:

- Tổng bài viết
- Bài viết hôm nay
- Tổng người dùng
- Tổng lượt xem

Dữ liệu được truyền toàn cục qua **AppServiceProvider (View Composer)**

---

## 🛠 Cài đặt project

### 1. Clone project

```bash
git clone https://github.com/lenhatlinhgit/Laravel
cd Laravel
```

### 2. Cài thư viện PHP

```bash
composer install
```

### 3. Cài thư viện JavaScript

```bash
npm install
```

### 4. Build frontend (TinyMCE + CSS/JS)

```bash
npm run build
```

### 5. Tạo file cấu hình

```bash
cp .env.example .env
```

Sau đó mở file `.env` và điền thông tin database:

```
DB_DATABASE=tên_database
DB_USERNAME=tên_user
DB_PASSWORD=mật_khẩu
```

### 6. Tạo key bảo mật

```bash
php artisan key:generate
```

### 7. Tạo bảng trong database

```bash
php artisan migrate
```

### 8. Import dữ liệu mẫu

Sau khi migrate xong, import file `Laravel.sql` để có dữ liệu mẫu:

- Mở **phpMyAdmin** hoặc **MySQL Workbench**
- Chọn database vừa tạo
- Import file `Laravel.sql`

### 9. Chạy server

```bash
php artisan serve
```

Truy cập: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 💡 Tác giả

Lê Nhật Linh
