<?php
require_once '../includes/dbconnect.php';

class Category {
    private $category_id;
    private $name;
    private $image;
    private $db;

    public function __construct($category_id = null) {
        $this->category_id = $category_id;
        $this->db = new DbConnector();
    }

    //GET ALL CATEGORIES FUNCTION -- USER & ADMIN
    public static function getAllCategories($conn) {
        try {
            $sql = "SELECT * FROM category ORDER BY name ASC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting categories: " . $e->getMessage());
            return [];
        }
    }

        // Add new category -- admin
        public function addCategory($conn, $name, $image) {
            $sql = "INSERT INTO category (name, image) VALUES (:name, :image)";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':image' => $image
            ]);
        }

        // Remove category -- admin
        public function removeCategory($conn, $category_id) {
            $sql = "DELETE FROM category WHERE category_id = :id";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([':id' => $category_id]);
        }




}