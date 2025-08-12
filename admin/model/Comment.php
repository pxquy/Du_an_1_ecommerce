<?php
class Comment extends BaseModel
{
    protected $table = "comments";


    public function getCommentList(
        int $page = 1,
        int $perPage = 10,
        string $sort = 'rating_desc',
        string $q = '',
        bool $onlyParents = true
    ) {
        $offset = ($page - 1) * $perPage;

        // Whitelist ORDER BY
        $orderMap = [
            'rating_desc' => 'c.rating DESC, c.id DESC',
            'rating_asc' => 'c.rating ASC, c.id DESC',

        ];
        $orderBy = $orderMap[$sort] ?? $orderMap['rating_desc'];

        // WHERE
        $where = [];
        $params = [];

        if ($onlyParents) {
            $where[] = 'c.parentId IS NULL';
        }
        if ($q !== '') {
            $where[] = 'p.title LIKE :q';
            $params[':q'] = '%' . $q . '%';
        }

        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

        // COUNT
        $sqlCount = "
        SELECT COUNT(*) AS cnt
        FROM comments c
        JOIN users u    ON u.id = c.userId
        JOIN products p ON p.id = c.productId
        $whereSql
    ";
        $stmtCount = $this->pdo->prepare($sqlCount);
        foreach ($params as $k => $v)
            $stmtCount->bindValue($k, $v, PDO::PARAM_STR);
        $stmtCount->execute();
        $total = (int) $stmtCount->fetchColumn();

        // DATA
        $sql = "
        SELECT 
            c.id,
            c.parentId,
            u.fullName,
            p.title,
            c.content,
            c.rating,
            c.isApproved
        FROM comments c
        JOIN users u    ON u.id = c.userId
        JOIN products p ON p.id = c.productId
        $whereSql
        ORDER BY $orderBy
        LIMIT :limit OFFSET :offset
    ";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v)
            $stmt->bindValue($k, $v, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$rows, $total];
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
            'userId' => $userId,
            'productId' => $productId,
            'content' => $content,
            'rating' => $rating,
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
