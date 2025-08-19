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

    public function ongoingOrder()
    {
        $sql = "
                SELECT COUNT(*)
                FROM orders o
             
                WHERE o.status <= 4
            
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Doanh thu theo tháng trong năm (đủ 12 tháng).
     * @param int|null $year  Năm cần lấy (mặc định: năm hiện tại)
     * @param bool $onlyCompleted  Chỉ tính đơn hoàn tất (status='5')
     * @return array [
     *   ['month' => 1, 'revenue' => 0, 'orders' => 0],
     *   ...
     *   ['month' => 12, 'revenue' => 12345678.90, 'orders' => 10],
     * ]
     */
    public function revenueByMonth(?int $year = null, bool $onlyCompleted = true): array
    {
        $year = $year ?: (int) date('Y');

        // MySQL 8+ dùng CTE để tạo dãy 1..12
        $sql = "
            WITH RECURSIVE months(m) AS (
                SELECT 1
                UNION ALL
                SELECT m + 1 FROM months WHERE m < 12
            )
            SELECT 
                m AS month,
                COALESCE(SUM(o.total), 0) AS revenue,
                COALESCE(COUNT(o.id), 0) AS orders
            FROM months
            LEFT JOIN orders o
                ON MONTH(o.createdAt) = m
               AND YEAR(o.createdAt) = :year
               " . ($onlyCompleted ? "AND o.status = '4'" : "") . "
            GROUP BY m
            ORDER BY m;
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':year' => $year]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Đảm bảo trả đúng 12 tháng
        $out = [];
        for ($i = 1; $i <= 12; $i++) {
            $out[$i] = ['month' => $i, 'revenue' => 0, 'orders' => 0];
        }
        foreach ($rows as $r) {
            $i = (int) $r['month'];
            $out[$i] = [
                'month' => $i,
                'revenue' => (float) $r['revenue'],
                'orders' => (int) $r['orders'],
            ];
        }
        return array_values($out);
    }
}