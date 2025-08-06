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

        $userId    = $_SESSION['user']['id'] ?? null;
        $productId = $_POST['productId'] ?? null;
        $content   = trim($_POST['content'] ?? '');
        $rating    = isset($_POST['rating']) ? floatval($_POST['rating']) : null;
        // $comments = $this->commentModel->getCommentsByProduct($productId);
        if (!$userId || !$productId || empty($content)) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = 'Vui lòng nhập đầy đủ nội dung bình luận.';
            header('Location: ' . BASE_URL . "?action=product_detail&id=$productId");
            exit();
        }

        // Kiểm tra quyền bình luận
        if (!$this->commentModel->hasPurchased($userId, $productId)) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = 'Bạn chỉ có thể bình luận khi đã mua sản phẩm này.';
            header('Location: ' . BASE_URL . "?action=product_detail&id=$productId");
            exit();
        }

        $this->commentModel->addComment($userId, $productId, $content, $rating);
        $_SESSION['success'] = true;
        $_SESSION['msg'] = 'Bình luận của bạn đã được gửi.';

        header('Location: ' . BASE_URL . "?action=product_detail&id=$productId");
        exit();
    }
}
