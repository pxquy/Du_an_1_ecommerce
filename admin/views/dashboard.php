<div class="stats-grid">
    <div class="stats-card">
        <div class="stats-header">
            <h3 class="stats-title">Tổng doanh thu</h3>
            <div class="stats-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
        <div class="stats-content">
            <div class="stats-value">
                <?= number_format($revenue ?? 0, 0, ',', '.') ?>₫
            </div>
            <p class="stats-description">
                <!-- <i class="fas fa-arrow-up trend-up"></i> -->
                <!-- <span class="trend-text trend-up">+20.1%</span> so với tháng trước -->
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
                <!-- <i class="fas fa-arrow-up trend-up"></i> -->
                <!-- <span class="trend-text trend-up">+180.1%</span> so với tháng trước -->
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
                <!-- <i class="fas fa-arrow-up trend-up"></i> -->
                <!-- <span class="trend-text trend-up">+19%</span> so với tháng trước -->
            </p>
        </div>
    </div>
    <div class="stats-card">
        <div class="stats-header">
            <h3 class="stats-title">Đơn hàng đang chờ xử lý</h3>
            <div class="stats-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
        <div class="stats-content">
            <div class="stats-value"><?= $ongoingOrder ?></div>
            <p class="stats-description">
                <!-- <i class="fas fa-arrow-up trend-up"></i> -->
                <!-- <span class="trend-text trend-up">+19%</span> so với tháng trước -->
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
                        <div class="order-price"><?= number_format($order['total'], 0, ',', '.') ?>₫</div>
                    </div>
                <?php endforeach ?>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const revenueData = <?= json_encode($seriesRevenue, JSON_UNESCAPED_UNICODE) ?>;
    const ordersData = <?= json_encode($seriesOrders, JSON_UNESCAPED_UNICODE) ?>;
    const categories = <?= json_encode($monthsLabels, JSON_UNESCAPED_UNICODE) ?>;
    const yearLabel = <?= json_encode($year) ?>;
    // console.log(revenueData);

    const options = {
        series: [
            { name: 'Doanh thu ' + yearLabel, data: revenueData },
            // Nếu muốn hiển thị thêm số đơn theo tháng (trục phụ), có thể tách sang chart khác
            // { name: 'Số đơn', data: ordersData }
        ],
        chart: { type: 'bar', height: 350 },
        plotOptions: {
            bar: { horizontal: false, columnWidth: '55%', borderRadius: 5, borderRadiusApplication: 'end' },
        },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        xaxis: { categories: categories },
        yaxis: { title: { text: 'VND' } },
        fill: { opacity: 1 },
        tooltip: {
            y: {
                formatter: function (val) {
                    // Format tiền VND cơ bản (có thể thay bằng Intl.NumberFormat)
                    return new Intl.NumberFormat('vi-VN').format(val) + ' ₫';
                }
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>