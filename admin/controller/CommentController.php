<?php
class CommentController
{
    private $comment;

    public function __construct()
    {
        $this->comment = new Comment();
    }

    public function index()
    {
        $view = 'comment/index';
        $title = 'Danh sách bình luận';

        // Lấy tham số filter/sort/pagination từ query
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $perPage = isset($_GET['perPage']) ? min(100, max(5, (int) $_GET['perPage'])) : 10;
        $sort = $_GET['sort'] ?? 'rating_desc'; // rating_desc | rating_asc
        $q = trim($_GET['q'] ?? '');         // tìm theo tên sản phẩm
        $onlyParents = true; // chỉ bình luận gốc

        [$data, $total] = $this->comment->getCommentList($page, $perPage, $sort, $q, $onlyParents);

        if (!empty($_GET['ajax'])) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'data' => $data,
                'total' => $total,
                'page' => $page,
                'perPage' => $perPage,
            ]);
            exit;
        }

        require_once PATH_VIEW_ADMIN_MAIN;
    }


    public function show()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];

            $comment = $this->comment->find('*', 'id = :id', ['id' => $id]);

            if (empty($comment)) {
                throw new Exception("Bình luận có ID = $id không tồn tại!");
            }

            $view = 'comments/show';
            $title = "Chi tiết thương hiệu có ID = $id";

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=comments-index');
            exit();
        }
    }

    public function create()
    {
        $view = 'comments/create';
        $title = 'Thêm mới thương hiệu';

        require_once PATH_VIEW_ADMIN_MAIN;
    }

    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Phương thức không hợp lệ.');
            }

            $data = $_POST + $_FILES;
            $_SESSION['errors'] = [];

            if (empty($data['title']) || strlen($data['title']) > 50) {
                $_SESSION['errors']['title'] = "Tên thương hiệu là bắt buộc và không được quá 50 ký tự.";
            }

            if ($data['logoUrl']['size'] > 0) {
                if ($data['logoUrl']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['errors']['logoUrl_size'] = 'Ảnh có dung lượng tối đa 2MB.';
                }

                $fileType = $data['logoUrl']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['errors']['logoUrl_type'] = "Chỉ chấp nhận các định dạng ảnh JPG, JPEG, PNG, GIF.";
                }
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu không hợp lệ.');
            }

            if ($data['logoUrl']['size'] > 0) {
                $data['logoUrl'] = upload_file('comments', $data['logoUrl']);
            } else {
                $data['logoUrl'] = null;
            }

            $data['slug'] = slugify($data['title']);
            $rowCount = $this->comment->insert($data);

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Thêm thương hiệu thành công.';
            } else {
                throw new Exception('Thêm thương hiệu không thành công.');
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=comments-index');
        exit();
    }

    public function edit()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $comment = $this->comment->find('*', 'id = :id', ['id' => $id]);

            if (empty($comment)) {
                throw new Exception("Bình luận không tồn tại.");
            }

            $view = 'comments/edit';
            $title = "Cập nhật thương hiệu: " . $comment['title'];

            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=comments-index');
            exit();
        }
    }

    public function update()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Phương thức không hợp lệ.');
            }

            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $comment = $this->comment->find('*', 'id = :id', ['id' => $id]);

            if (empty($comment)) {
                throw new Exception("Bình luận không tồn tại.");
            }

            $data = $_POST + $_FILES;
            $_SESSION['errors'] = [];
            $data['slug'] = slugify($data['title']);

            if (!empty($this->comment->find('*', 'slug = :slug AND id != :id', ['slug' => $data['slug'], 'id' => $id]))) {
                $_SESSION['errors']['slug'] = 'Tên thương hiệu đã tồn tại.';
            }

            if ($data['logoUrl']['size'] > 0) {
                if ($data['logoUrl']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['errors']['logoUrl_size'] = 'Ảnh có dung lượng tối đa 2MB.';
                }

                $fileType = $data['logoUrl']['type'];
                $allowedType = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedType)) {
                    $_SESSION['errors']['logoUrl_type'] = "Chỉ chấp nhận các định dạng ảnh JPG, JPEG, PNG, GIF.";
                }
            }

            if (!empty($_SESSION['errors'])) {
                $_SESSION['data'] = $data;
                throw new Exception('Dữ liệu không hợp lệ.');
            }

            if ($data['logoUrl']['size'] > 0) {
                $data['logoUrl'] = upload_file('comments', $data['logoUrl']);
            } else {
                $data['logoUrl'] = $comment['logoUrl'];
            }

            $data['updatedAt'] = date('Y-m-d H:i:s');
            $rowCount = $this->comment->update($data, 'id = :id', ['id' => $id]);

            if ($rowCount > 0) {
                if ($_FILES['logoUrl']['size'] > 0 && !empty($comment['logoUrl']) && file_exists(PATH_ASSETS_UPLOADS . $comment['logoUrl'])) {
                    unlink(PATH_ASSETS_UPLOADS . $comment['logoUrl']);
                }

                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Cập nhật thành công.';
            } else {
                throw new Exception('Cập nhật không thành công.');
            }

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage() . ' - Dòng: ' . $th->getLine();

            if ($th->getCode() == 99) {
                header('Location: ' . BASE_URL_ADMIN . '&action=comments-index');
                exit();
            }
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=comments-edit&id=' . $id);
    }

    public function restore()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $comment = $this->comment->find('*', 'id = :id', ['id' => $id]);

            if (empty($comment)) {
                throw new Exception("Bình luận không tồn tại.");
            }

            $rowCount = $this->comment->update(
                ['isApproved' => 1],
                'id = :id',
                ['id' => $id]
            );

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Khôi phục thành công.';
            } else {
                throw new Exception('Khôi phục không thành công.');
            }

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=comments-index');
        exit();
    }

    public function softDelete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $comment = $this->comment->find('*', 'id = :id', ['id' => $id]);

            if (empty($comment)) {
                throw new Exception("Bình luận không tồn tại.");
            }


            $rowCount = $this->comment->update(
                ['isApproved' => 0],
                'id = :id',
                ['id' => $id]
            );

            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Xóa tạm thời thành công.';
            } else {
                throw new Exception('Xóa tạm thời không thành công.');
            }

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=comments-index');
        exit();
    }

    public function delete()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Thiếu tham số "id".', 99);
            }

            $id = $_GET['id'];
            $comment = $this->comment->find('*', 'id = :id', ['id' => $id]);

            if (empty($comment)) {
                throw new Exception("Bình luận không tồn tại.");
            }

            $rowCount = $this->comment->delete('id = :id', ['id' => $id]);

            if ($rowCount > 0) {
                if (!empty($comment['logoUrl']) && file_exists(PATH_ASSETS_UPLOADS . $comment['logoUrl'])) {
                    unlink(PATH_ASSETS_UPLOADS . $comment['logoUrl']);
                }

                $_SESSION['success'] = true;
                $_SESSION['msg'] = 'Xóa vĩnh viễn thành công.';
            } else {
                throw new Exception('Xóa không thành công.');
            }

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();
        }

        header('Location: ' . BASE_URL_ADMIN . '&action=comments-index');
        exit();
    }
}
