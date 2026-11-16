# Bài thực hành tuần 8 - PHP API và Vue.js

## Chạy bài
1. Bật Apache và MySQL (XAMPP), chép thư mục này vào `htdocs`.
2. Import `database.sql` (tạo CSDL `products_db`, bảng `products`, 3 dòng mẫu).
3. Nếu cần, sửa tài khoản MySQL trong `api/db.php`.
4. Mở `http://localhost/<thư mục>/index.html`.

## Câu 4 - kiểm thử
- Thêm sản phẩm hợp lệ rồi tải lại trang: sản phẩm vẫn còn.
- Sửa đơn giá: bảng hiển thị giá mới.
- Gửi trực tiếp tồn kho = -1 (PHP trả lỗi 400, MySQL không có bản ghi mới):

```
curl -X POST http://localhost/<thư mục>/api/products.php -H "Content-Type: application/json" -d "{\"name\":\"X\",\"price\":1000,\"stock\":-1}"
```

- Xóa sản phẩm rồi tải lại trang: sản phẩm không còn trong danh sách.
