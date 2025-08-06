<?php
class Comment extends BaseModel
{
    protected $table = "comments";

    public function __construct()
    {
        parent::__construct();
        $this->setTable($this->table);
    }

    public function hasPurchased(int $userId, int $productId): bool
    {
        $sql = "
            SELECT COUNT(*) as count
            FROM orders o
            JOIN order_products op ON o.id = op.orderId
            WHERE o.userId = ? AND op.productId = ? AND o.status IN ('3','4','5')
        ";
        $result = $this->selectRaw($sql, [$userId, $productId]);
        return ($result[0]['count'] ?? 0) > 0;
    }

    public function addComment(int $userId, int $productId, string $content, ?float $rating = null): int
    {
        return $this->insert([
            'userId'    => $userId,
            'productId' => $productId,
            'content'   => $content,
            'rating'    => $rating,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getCommentsByProduct(int $productId): array
    {
        $sql = "
            SELECT c.*, u.fullname, u.avatarUrl
            FROM comments c
            JOIN users u ON c.userId = u.id
            WHERE c.productId = ? AND c.isApproved = 1
            ORDER BY c.createdAt DESC
        ";
        return $this->selectRaw($sql, [$productId]);
    }
}
