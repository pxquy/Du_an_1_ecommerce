<?php
require_once './client/model/Comment.php';

class CommentController
{
    protected $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
    }
    public function addComment()
    {
        require_Login();
        // debug($_POST);

        $userId    = $_SESSION['user']['id'] ?? null;
        $productId = $_POST['productId'] ?? null;
        $slug = $_POST['slug'] ?? null;
        // debug($_POST);
        $content   = trim($_POST['content'] ?? '');
        $rating    = isset($_POST['rating']) ? floatval($_POST['rating']) : null;
        // $comments = $this->commentModel->getCommentsByProduct($productId);
        if (!$userId || !$productId || empty($content)) {
            $_SESSION['error_message'] = 'Vui lòng nhập đầy đủ nội dung bình luận.';
            header('Location: ' . BASE_URL . "?action=product_detail&slug=$slug");
            exit();
        }

        // Kiểm tra quyền bình luận
        if (!$this->commentModel->hasPurchased($userId, $productId)) {
            $_SESSION['error_message'] = 'Bạn chỉ có thể bình luận khi đã mua sản phẩm này.';
            header('Location: ' . BASE_URL . "?action=product_detail&slug=$slug");
            exit();
        }

        $res = $this->commentModel->addComment($userId, $productId, $content, $rating);
        // debug($res);
        $$_SESSION['success_message'] = 'Bình luận của bạn đã được gửi.';

        header('Location: ' . BASE_URL . "?action=product_detail&slug=$slug");
        exit();
    }
}
