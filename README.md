# Website Quản Lý Thư Viện

## 1. Giới thiệu
Đồ án Website Quản lý Thư viện được thực hiện nhằm xây dựng một hệ thống hỗ trợ công tác quản lý sách, độc giả và hoạt động mượn – trả sách tại thư viện theo hướng tin học hóa. Hệ thống giúp giảm thiểu thao tác thủ công, nâng cao hiệu quả quản lý và đảm bảo tính chính xác của dữ liệu.

## 2. Mục tiêu 
- Xây dựng website quản lý thư viện với các chức năng cơ bản, dễ sử dụng.
- Áp dụng kiến thức đã học về phân tích, thiết kế hệ thống và lập trình web.
- Làm quen với quy trình phát triển một hệ thống quản lý hoàn chỉnh từ phân tích yêu cầu đến triển khai.
  
## 3. Đối tượng
- Quản trị viên (Admin): Quản lý toàn bộ hệ thống.
- Thủ thư: Thực hiện nghiệp vụ mượn – trả, quản lý sách và độc giả.
  
## 4. Chức năng chính
- Quản lý sách (thêm, sửa, xóa, tìm kiếm)
- Quản lý độc giả (sửa, xóa và tìm kiếm)
- Quản lý mượn – trả sách (sửa, xóa và tìm kiếm)
- Thống kê
- Phân quyền người dùng (Admin, Thủ thư)
- Đăng ký, đăng nhập và đăng xuất

## 5. Công nghệ sử dụng
- Ngôn ngữ: PHP
- Cơ sở dữ liệu: MySQL
- Frontend: HTML, CSS, JavaScript
- Framework giao diện: AdminLTE
- Công cụ: Laragon
- 
## 6. Cài đặt và chạy chương trình
### Bước 1:
Clone source code:
```bash
git clone https://github.com/QueAnh068/csn-da23ttb-thachnguyenqueanh-webquanlythuvien.git

### Bước 2: Cài đặt môi trường
Copy source vào thư mục htdocs
Import file database .sql vào MySQL

### Bước 3: Chạy chương trình
Chỉnh file connect.php
Truy cập: http://localhost/www

## 7. Cấu trúc thư mục
/admin        - Giao diện quản trị
/user         - Giao diện người dùng
/image        - CSS, JS, hình ảnh
/database     - File SQL

## 8. Kết quả đạt được
- Xây dựng được website quản lý thư viện cơ bản với giao diện trực quan.
- Đáp ứng đầy đủ các chức năng nghiệp vụ chính đã đề ra.
- Hệ thống hoạt động ổn định trong môi trường cục bộ.

## 9. Hạn chế
- Giao diện chưa tối ưu trải nghiệm người dùng
- Chức năng còn giới hạn
- Bảo mật ở mức cơ bản

## 10. Hướng phát triển
-Chat, mã vạch nhằm tự động hóa quy trình mượn – trả, gia hạn mượn… 

## 11. Người thực hiện
Sinh viên thực hiện: Thạch Nguyễn Quế Anh
Lớp – MSSV: DA23TTB - 110123068
Trường Kỹ thuật & Công nghệ
Khoa Công Nghệ Thông Tin
Trường Đại học Trà Vinh

## 12. Cách sử dụng Laragon
- Dự án được chạy trong môi trường cục bộ bằng Laragon.
- Thư mục chạy web mặc định: laragon/www.
- Khuyến nghị sử dụng PHP và MySQL phiên bản mặc định đi kèm Laragon để tránh lỗi tương thích.
