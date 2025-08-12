<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="stats-grid">
    <div class="stats-card">
        <div class="stats-header">
            <h3 class="stats-title">Tổng doanh thu</h3>
            <div class="stats-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
        <div class="stats-content">
            <div class="stats-value"><?= $revenue ?> </div>
            <p class="stats-description">
                <i class="fas fa-arrow-up trend-up"></i>
                <span class="trend-text trend-up">+20.1%</span> so với tháng trước
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
            <div class="stats-value"><?= $newUser ?></div>
            <p class="stats-description">
                <i class="fas fa-arrow-up trend-up"></i>
                <span class="trend-text trend-up">+180.1%</span> so với tháng trước
            </p>
        </div>
    </div>
    <div class="stats-card">
        <div class="stats-header">
            <h3 class="stats-title">Đơn hàng được mua</h3>
            <div class="stats-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
        <div class="stats-content">
            <div class="stats-value"><?= $totalOrder ?></div>
            <p class="stats-description">
                <i class="fas fa-arrow-up trend-up"></i>
                <span class="trend-text trend-up">+19%</span> so với tháng trước
            </p>
        </div>
    </div>

</div>

<div class="charts-grid">
    <div class="chart-card revenue-chart">
        <div class="chart-header">
            <h3 class="chart-title">Tổng quan về doanh thu</h3>
            <p class="chart-description">
                Doanh thu hàng tháng cho năm hiện tại.
            </p>
        </div>
        <div class="chart-content">
            <div id="chart">Trình dữ liệu biểu đồ doanh thu</div>
        </div>
    </div>
    <div class="chart-card orders-chart">
        <div class="chart-header">
            <h3 class="chart-title">Đơn hàng đặt gần đây</h3>
            <p class="chart-description">Đơn hàng mới nhất cảu khách hàng</p>
        </div>
        <div class="chart-content">
            <div class="orders-list">
                <?php foreach ($recentOrders as $order): ?>
                    <div class="order-item">
                        <div class="order-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="order-info">
                            <p class="order-name">Đơn hàng <?= $order['id'] ?></p>
                            <p class="order-customer">Người dùng <?= $order['fullName'] ?></p>
                        </div>
                        <div class="order-price"><?= $order['total'] ?></div>
                    </div>
                <?php endforeach ?>

            </div>
        </div>
    </div>
</div>

<script>
    var options = {
        series: [{
            name: 'Free Cash Flow',
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                borderRadius: 5,
                borderRadiusApplication: 'end'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
            title: {
                text: '$ (thousands)'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "$ " + val + " thousands"
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>