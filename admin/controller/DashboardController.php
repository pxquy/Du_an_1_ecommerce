<?php
class DashboardController
{
    private $dashBoard;
    public function __construct()
    {
        $this->dashBoard = new DashBoard();
    }
    public function index()
    {
        $view = 'dashboard';

        $year = isset($_GET['year']) ? (int) $_GET['year'] : (int) date('Y');
        $onlyCompleted = true; // đổi false nếu muốn tính tất cả trạng thái

        $revenueSeries = $this->dashBoard->revenueByMonth($year, $onlyCompleted);
        $revenue = $this->dashBoard->totalSum();
        $newUser = $this->dashBoard->newUsers();
        $totalOrder = $this->dashBoard->totalOrders();
        $recentOrders = $this->dashBoard->recentOrders();

        // Chuẩn hóa dữ liệu cho chart
        $monthsLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $seriesRevenue = array_map(fn($r) => $r['revenue'], $revenueSeries);
        $seriesOrders = array_map(fn($r) => $r['orders'], $revenueSeries);

        require_once PATH_VIEW_ADMIN_MAIN;
    }

}