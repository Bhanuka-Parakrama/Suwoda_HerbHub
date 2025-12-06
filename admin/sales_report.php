<!-- Removed category tables as requested -->
<?php

require_once '../includes/dbconnect.php';
require_once '../classes/SalesReportTypes.php';

$db = new DbConnector();
$conn = $db->getConnection();

$view = $_GET['view'] ?? 'daily';
$date = $_GET['date'] ?? date('Y-m-d');
$year = $_GET['year'] ?? date('Y');
$month = $_GET['month'] ?? date('n');
$week_start = $_GET['week_start'] ?? date('Y-m-d', strtotime('last Sunday'));
$week_end = isset($_GET['week_start']) ? date('Y-m-d', strtotime($week_start . ' +6 days')) : date('Y-m-d', strtotime('next Saturday', strtotime($week_start)));

$details = [];
$revenue = 0;
$topProducts = [];
$avgOrderValue = 0;
$orderStatusSummary = [];

$params = ['type' => $view];

if ($view === 'daily') {
    $salesReport = new DailySalesReport();
    $params['date'] = $date;
    $details = $salesReport->getAverageDetails($params);
    $revenue = $details['revenue'] ?? 0;
    $topProducts = $details['top_selling_products'] ?? [];
    $orderStatusSummary = $details['order_status_summary'] ?? [];

} elseif ($view === 'weekly') {
    $salesReport = new WeeklySalesReport();
    $params['year'] = $year;
    $params['week'] = date('W', strtotime($week_start));
    $details = $salesReport->getAverageDetails($params);
    $revenue = $details['revenue'] ?? 0;
    $topProducts = $details['top_selling_products'] ?? [];
    $avgOrderValue = $details['average_order_value'] ?? 0;
    $orderStatusSummary = $details['order_status_summary'] ?? [];

} elseif ($view === 'monthly') {
    $salesReport = new MonthlySalesReport();
    $params['year'] = $year;
    $params['month'] = $month;
    $details = $salesReport->getAverageDetails($params);
    $revenue = $details['revenue'] ?? 0;
    $topProducts = $details['top_selling_products'] ?? [];
    $avgOrderValue = $details['average_order_value'] ?? 0;
    $orderStatusSummary = $details['order_status_summary'] ?? [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <?php include './admin_header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Sales Report</h1>

     <a href="dashbord.php" class="btn btn-success text-white mb-2"><i class="bi bi-arrow-left"></i> Back to Dashbord</a>

    <!-- Filter Section -->
    <div class="card border-primary mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Filter Sales Report</h5>
        </div>
        <div class="card-body">
            <form method="get">
                <div class="row g-2 align-items-end">
                    <div class="col-md-2">
                        <label for="view" class="form-label">View</label>
                        <select name="view" id="view" class="form-select" onchange="this.form.submit()">
                            <option value="daily" <?php if($view==='daily') echo 'selected'; ?>>Daily</option>
                            <option value="weekly" <?php if($view==='weekly') echo 'selected'; ?>>Weekly</option>
                            <option value="monthly" <?php if($view==='monthly') echo 'selected'; ?>>Monthly</option>
                        </select>
                    </div>
                    <div class="col-md-2" id="dailyInput" style="display:<?php echo $view==='daily'?'block':'none'; ?>;">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="<?php echo $_GET['date'] ?? date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-md-3" id="weeklyInput" style="display:<?php echo $view==='weekly'?'block':'none'; ?>;">
                        <label for="week_start" class="form-label">Week Start</label>
                        <input type="date" name="week_start" id="week_start" class="form-control" value="<?php echo $_GET['week_start'] ?? date('Y-m-d', strtotime('last Sunday')); ?>" onchange="updateWeekEnd()">
                    </div>
                    <div class="col-md-3" id="weekEndInput" style="display:<?php echo $view==='weekly'?'block':'none'; ?>;">
                        <label for="week_end" class="form-label">Week End</label>
                        <input type="date" name="week_end" id="week_end" class="form-control" value="<?php echo $_GET['week_end'] ?? date('Y-m-d', strtotime('next Saturday', strtotime($_GET['week_start'] ?? date('Y-m-d', strtotime('last Sunday'))))); ?>" readonly>
                    </div>
                    <div class="col-md-2" id="monthlyInput" style="display:<?php echo $view==='monthly'?'block':'none'; ?>;">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" name="year" id="monthYear" class="form-control" value="<?php echo $_GET['year'] ?? date('Y'); ?>">
                    </div>
                    <div class="col-md-2" id="monthInput" style="display:<?php echo $view==='monthly'?'block':'none'; ?>;">
                        <label for="month" class="form-label">Month</label>
                        <input type="number" name="month" id="month" class="form-control" min="1" max="12" value="<?php echo $_GET['month'] ?? date('n'); ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Orders</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $details['orders'] ?? 0; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $details['users'] ?? 0; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Products</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $details['products'] ?? 0; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Revenue</div>
                <div class="card-body">
                    <h5 class="card-title">Rs. <?php echo number_format($revenue, 2); ?></h5>
                </div>
            </div>
        </div>
    </div>


    <!-- Top Selling Products table -->
    <?php if ($view === 'weekly' || $view === 'monthly' || $view === 'daily'): ?>
    <div class="row mt-3">
        <div class="col-md-8">
            <div class="card border-success mb-3">
                <div class="card-header">Top Selling Products</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($topProducts)): ?>
                                <tr><td colspan="2" class="text-center text-muted">No top selling products found for this period.</td></tr>
                            <?php else: ?>
                                <?php foreach ($topProducts as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                        <td><?php echo $product['total_sold']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Order Status Summary table -->
    <?php if ($view === 'weekly' || $view === 'monthly' || $view === 'daily'): ?>
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card border-info mb-3">
                <div class="card-header">Order Status Summary</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orderStatusSummary)): ?>
                                <tr><td colspan="2" class="text-center text-muted">No order status data found for this period.</td></tr>
                            <?php else: ?>
                                <?php foreach ($orderStatusSummary as $status): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($status['status']); ?></td>
                                        <td><?php echo $status['count']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>


<!-- Charts Section -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Top Selling Products</div>
                <div class="card-body">
                    <canvas id="topProductsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Order Status Summary</div>
                <div class="card-body">
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Top Selling Products Bar Chart
const topProducts = <?php echo json_encode($topProducts); ?>;
const productNames = topProducts.map(p => p.product_name);
const productQuantities = topProducts.map(p => Number(p.total_sold));

const ctxProducts = document.getElementById('topProductsChart').getContext('2d');
if (productNames.length > 0) {
    new Chart(ctxProducts, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Quantity Sold',
                data: productQuantities,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
} else {
    ctxProducts.font = '16px Arial';
    ctxProducts.fillText('No data available', 50, 50);
}

// Order Status Pie Chart
const orderStatus = <?php echo json_encode($orderStatusSummary); ?>;
const statusLabels = orderStatus.map(s => s.status);
const statusCounts = orderStatus.map(s => Number(s.count));

const ctxStatus = document.getElementById('orderStatusChart').getContext('2d');
if (statusLabels.length > 0) {
    new Chart(ctxStatus, {
        type: 'pie',
        data: {
            labels: statusLabels,
            datasets: [{
                label: 'Order Status',
                data: statusCounts,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        }
    });
} else {
    ctxStatus.font = '16px Arial';
    ctxStatus.fillText('No data available', 50, 50);
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
function updateWeekEnd() {
    var weekStartInput = document.getElementById('week_start');
    var weekEndInput = document.getElementById('week_end');
    if (weekStartInput && weekEndInput) {
        var startDate = new Date(weekStartInput.value);
        if (!isNaN(startDate.getTime())) {
            var endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + 6);
            var yyyy = endDate.getFullYear();
            var mm = String(endDate.getMonth() + 1).padStart(2, '0');
            var dd = String(endDate.getDate()).padStart(2, '0');
            weekEndInput.value = yyyy + '-' + mm + '-' + dd;
        }
    }
}
</script>

 <?php include './admin_footer.php'; ?>
</body>
</html>