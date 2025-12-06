<?php

require_once '../includes/dbconnect.php';
require_once  '../classes/ReportClass.php';

//DAILY SALES REPORT

class DailySalesReport extends Report {
    
    public function getAverageDetails(array $params): array {
        $date = $params['date'] ?? date('Y-m-d');
        $details = [];

        // Orders count
        $sql = "SELECT COUNT(*) as total FROM `orders` WHERE DATE(order_date) = :date";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        $details['orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Users
        $sql = "SELECT COUNT(*) as total FROM user WHERE status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $details['users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Products
        $sql = "SELECT COUNT(*) as total FROM product";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $details['products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Revenue
        $sql = "SELECT SUM(total_price) as total FROM `orders` WHERE DATE(order_date) = :date AND status IN ('Confirmed', 'Out for Delivery', 'Delivered')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        $details['revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        //start and end time for a day
        $start = $date . ' 00:00:00';
        $end = $date . ' 23:59:59';

        // Top Selling Products
        $details['top_selling_products'] = $this->getTopSellingProducts($start, $end);

        // Order Status Summary
        $details['order_status_summary'] = $this->getOrderStatusSummary($start, $end);

        return $details;
    }
}



//WEEKLY SALES REPORT

class WeeklySalesReport extends Report {

    public function getAverageDetails(array $params): array {
        $year = $params['year'] ?? date('Y');
        $week = $params['week'] ?? 1;
        $details = [];

        // Orders
        $sql = "SELECT COUNT(*) as total FROM `orders` WHERE YEAR(order_date) = :year AND WEEK(order_date, 1) = :week";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':week', $week, PDO::PARAM_INT);
        $stmt->execute();
        $details['orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Users
        $sql = "SELECT COUNT(*) as total FROM user WHERE status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $details['users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Products
        $sql = "SELECT COUNT(*) as total FROM product";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $details['products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Revenue
        $sql = "SELECT SUM(total_price) as total FROM `orders` WHERE YEAR(order_date) = :year AND WEEK(order_date, 1) = :week AND status IN ('Confirmed', 'Out for Delivery', 'Delivered')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':week', $week, PDO::PARAM_INT);
        $stmt->execute();
        $details['revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Date range for week
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $start = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $end = $dto->format('Y-m-d');

        // Top Selling Products
        $details['top_selling_products'] = $this->getTopSellingProducts($start, $end);

        // Order Status Summary
        $details['order_status_summary'] = $this->getOrderStatusSummary($start, $end);

        return $details;
    }
}



//MONTHLY SALES REPORT

class MonthlySalesReport extends Report {
  
    public function getAverageDetails(array $params): array {
        $year = $params['year'] ?? date('Y');
        $month = $params['month'] ?? date('n');
        $start = sprintf('%04d-%02d-01', $year, $month);
        $end = date('Y-m-t', strtotime($start));
        $details = [];

        // Orders 
        $sql = "SELECT COUNT(*) as total FROM `orders` WHERE YEAR(order_date) = :year AND MONTH(order_date) = :month";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->execute();
        $details['orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Users
        $sql = "SELECT COUNT(*) as total FROM user WHERE status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $details['users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Products
        $sql = "SELECT COUNT(*) as total FROM product";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $details['products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Revenue
        $sql = "SELECT SUM(total_price) as total FROM `orders` WHERE YEAR(order_date) = :year AND MONTH(order_date) = :month AND status IN ('Confirmed', 'Out for Delivery', 'Delivered')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->execute();
        $details['revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Top Selling Products
        $details['top_selling_products'] = $this->getTopSellingProducts($start, $end);

        // Order Status Summary
        $details['order_status_summary'] = $this->getOrderStatusSummary($start, $end);

        return $details;
    }
}







