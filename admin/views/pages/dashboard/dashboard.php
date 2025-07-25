<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../../views/layout/layout-admin.css">
    <link rel="stylesheet" href="../../../views/layout/sidebar/sidebar.css">
    <link rel="stylesheet" href="../../../views/layout/header/header.css">
    <link rel="stylesheet" href="../../../views/pages/dashboard/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Add overlay div -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-container">
        <!-- Sidebar -->
        <?php
        include_once(__DIR__ . '/../../layout/sidebar/sidebar.php')
        ?>
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <?php include_once(__DIR__ . '/../../layout/header/header.php') ?>
            <!-- Dashboard Content -->
            <div class="content">
                <div class="content-header">
                    <div class="breadcrumb">
                        <i class="fas fa-home breadcrumb-separator"></i>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-current">Bảng điểu khiển</span>
                    </div>
                    <div class="content-wrapper">
                        <div class="content-text">
                            <h1 class="content-title">Bảng điểu khiển</h1>
                        </div>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stats-card">
                        <div class="stats-header">
                            <h3 class="stats-title">Tổng doanh thu</h3>
                            <div class="stats-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <div class="stats-value"></div>
                            <p class="stats-description">
                                <!-- <i class="fas <?= $revUp ? 'fa-arrow-up trend-up' : 'fa-arrow-down trend-down' ?>"></i>
                                <span class="trend-text <?= $revUp ? 'trend-up' : 'trend-down' ?>"> -->

                                </span> so với tháng trước
                            </p>
                        </div>
                    </div>
                    <div class="stats-card">
                        <div class="stats-header">
                            <h3 class="stats-title">Người dùng mới</h3>
                            <div class="stats-icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <div class="stats-value"></div>
                            <p class="stats-description">
                                <!-- <i class="fas <?= $userUp ? 'fa-arrow-up trend-up' : 'fa-arrow-down trend-down' ?>"></i>
                                <span class="trend-text <?= $userUp ? 'trend-up' : 'trend-down' ?>"> -->

                                </span> so với tháng trước
                            </p>
                        </div>
                    </div>
                    <div class="stats-card">
                        <div class="stats-header">
                            <h3 class="stats-title">Sản phẩm hoạt động</h3>
                            <div class="stats-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <div class="stats-value"></div>

                            <p class="stats-description">Sản phẩm đang được bán</p>
                        </div>
                    </div>
                    <div class="stats-card">
                        <div class="stats-header">
                            <h3 class="stats-title">Đơn chờ xử lý</h3>
                            <div class="stats-icon">
                                <i class="fas fa-spinner"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <div class="stats-value"></div>
                            <p class="stats-description">
                                <!-- <i class="fas <?= $pendingUp ? 'fa-arrow-up trend-up' : 'fa-arrow-down trend-down' ?>"></i>
                                <span class="trend-text <?= $pendingUp ? 'trend-up' : 'trend-down' ?>"> -->

                                </span> so với tháng trước
                            </p>
                        </div>
                    </div>
                </div>

                <div class="charts-grid">
                    <div class="chart-card revenue-chart">
                        <div class="chart-header">
                            <h3 class="chart-title">Tổng quan về doanh thu</h3>
                            <form method="GET" class="year-filter-form" action="index.php">
                                <input type="hidden" name="router" value="admin/dashboard">
                                <label for="year">Chọn năm:</label>
                                <select name="year" id="year" class="filter-select">
                                </select>
                                <button type="submit" class="year-btn">Thống kê năm</button>
                            </form>

                        </div>
                        <div class="chart-content">
                            <div class="chart-placeholder"><canvas id="yearRevenueChart" height="100"></canvas></div>
                        </div>
                    </div>
                    <div class="chart-card orders-chart">
                        <div class="chart-header">
                            <h3 class="chart-title">Đơn đặt hàng gần đây</h3>
                            <p class="chart-description">Đơn hàng mới nhất của khách hàng</p>
                        </div>
                        <div class="chart-content">
                            <div class="orders-list">
                                <div class="order-item">
                                    <div class="order-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="order-info">
                                        <p class="order-name">Đơn hàng #QSS</p>
                                        <p class="order-customer">
                                    </div>
                                    <div class="order-price"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="./admin/views/layout/layout-admin.js"></script>
    <script>
        const monthLabels = <?= $monthLabels ?>;
        const revenueDataByMonth = <?= $revenueValues ?>;

        const ctxYear = document.getElementById('yearRevenueChart').getContext('2d');
        const yearChart = new Chart(ctxYear, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Doanh thu theo tháng',
                    data: revenueDataByMonth,
                    backgroundColor: '#4f46e5',
                    borderColor: '#f1f5f9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw.toLocaleString('vi-VN') + ' đ';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + ' đ';
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>