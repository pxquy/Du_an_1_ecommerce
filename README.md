# Du_an_1_ecommerce

Tên tên biến tiếng anh kiếu Camel
Khi viết form phải viết tên theo database và quan sát controller
Khi viết xong 1 function phải comment
Khi thêm dữ liệu phải comment vào file text và backup database về gửi vào zalo
Sau 1 ngày phải commit lên git
Sau một tuần merge code
sang tuần mới phải kéo base mới về
Hàm debug,upload ảnh,genId,chuyển đổi định giá, chuyển đổi trạng thái

Công việc cần làm trong tuần 1:

- CRUD model:

* admin
* client

- CONTROLLER CƠ BẢN:

* admin
* client

\*\*\* Việc quan trọng:

- ROUTER

\*\*\* Việc khó:

- Admin: Biến thể của sản phẩm
- Client: Thanh toán
  <<<<<<< HEAD
  =======

\\16/07/25
Dương Trường Giang:
-việc đã làm:
*\*\*admin
*model: basemodel kết nối database, các hàm dùng chung cho các bảng do admin quản lý
\*controller: controller cơ bản cho admin

**_index: -hàm spl autoload file từ model, controller
_**config: file env định nghĩa các đường dẫn và các biến dùng trong kết nối database
\*\*\*routes: phân chia admin, client

> > > > > > > giang

\*\*\* Quy ước chung:

- Quy ước phân quyền:

* 0: user
* 1: admin
* 2: Quản lý

- Quy ước giới tính:

* 1: nam
* 2: nữ

- Quy ước trạng thái đơn hàng

* 1: Chờ xác nhận
* 2: Đang xử lý
* 3: đang giao hàng
* 4: Thành công
* 5: Huỷ
