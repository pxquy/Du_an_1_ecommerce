<?php
class DashBoard extends BaseModel
{
    public function totalSum()
    {
        $sql = "SELECT
                        SUM(total) revenue
                FROM orders
                WHERE status = '4'
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function newUsers()
    {
        $sql = "SELECT 
                        COUNT(*) AS newUsers
                FROM users
                WHERE MONTH(createdAt) = MONTH(CURDATE())
                AND YEAR(createdAt) = YEAR(CURDATE())
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function totalOrders()
    {
        $sql = "SELECT
                        COUNT(*)
                FROM orders
                WHERE status = '4'
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function recentOrders()
    {
        $sql = "
                SELECT 
                    u.fullName,
                    o.id,
                    o.total,
                    o.createdAt
                FROM orders o
                JOIN users u ON o.userId = u.id
                WHERE o.createdAt >= NOW() - INTERVAL 5 DAY
                ORDER BY o.createdAt DESC;
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}