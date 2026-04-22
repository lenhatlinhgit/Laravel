# 📌 Hệ thống quản lý bài viết (Laravel)

## 📖 Giới thiệu

Đây là một dự án Laravel xây dựng hệ thống quản lý bài viết đơn giản, bao gồm:

- Đăng nhập / đăng ký tài khoản
- Phân quyền (Admin / User)
- Đổi mật khẩu
- Dashboard quản trị
- CRUD bài viết (thêm, sửa, xóa, xem)
- Upload bài viết bằng file ZIP
- Upload ảnh nền
- Theo dõi lượt xem bài viết

---

## ⚙️ Công nghệ sử dụng

- Laravel 13
- PHP 8+
- MySQL
- Blade Template
- CSS custom
- ZipArchive (giải nén file ZIP)

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
    - File ZIP (tự động giải nén)
    - Ảnh nền
- Chỉnh sửa bài viết
- Xóa bài viết
- Xem chi tiết bài viết
- Tự động tăng lượt xem khi truy cập

---

## 📦 Cơ chế upload ZIP

Khi upload bài viết:

- Hệ thống giải nén file ZIP
- Tìm file `index.html`
- Tự động sửa đường dẫn hình ảnh trong HTML
- Lưu nội dung HTML vào database

---

## 🧠 Cấu trúc bảng posts

- id
- title (tiêu đề)
- location (địa điểm)
- author (tác giả)
- content (nội dung HTML từ ZIP)
- background (ảnh nền)
- views (lượt xem)
- dateposted (ngày đăng)
- created_at
- updated_at

---

## 🔐 Phân quyền

- Admin:
    - Truy cập dashboard
    - Tạo / sửa / xóa bài viết
- User:
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

```bash
git clone https://github.com/lenhatlinhgit/Laravel
```

## 💡 Tác giả

Lê Nhật Linh
