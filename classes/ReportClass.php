<?php
//USE POLYMORPHISM TO CREATE DIFFERENT REPORT TYPES

//abstract class
abstract class Report {

      protected $conn;

    public function __construct() {
        require_once __DIR__ . '/../includes/dbconnect.php';
        $db = new DbConnector();
        $this->conn = $db->getConnection();
    }
 
    //Abstract method
    abstract public function getAverageDetails(array $params): array;


    
     //Get top selling products between two dates
     public function getTopSellingProducts($start, $end) {
        $sql = "SELECT p.product_name, SUM(oi.quantity) as total_sold FROM order_item oi JOIN product p ON oi.product_id = p.product_id JOIN orders o ON oi.order_id = o.order_id WHERE o.order_date BETWEEN :start AND :end GROUP BY p.product_id ORDER BY total_sold DESC LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


     //Get order status summary
     public function getOrderStatusSummary($start, $end) {
        $sql = "SELECT status, COUNT(*) as count FROM orders WHERE order_date BETWEEN :start AND :end GROUP BY status";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
  

}
