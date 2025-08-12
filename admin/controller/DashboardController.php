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
        $revenue = $this->dashBoard->totalSum();
        $newUser = $this->dashBoard->newUsers();
        $totalOrder = $this->dashBoard->totalOrders();
        $recentOrders = $this->dashBoard->recentOrders();
        // debug($recentOrder);
        require_once PATH_VIEW_ADMIN_MAIN;
    }

}