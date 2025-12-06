<?php
require_once '../includes/dbconnect.php';

class Blog {
    private $blog_id;
    private $title;
    private $content;
    private $image;
    private $published_date;
    private $db;

    public function __construct($blog_id = null) {
        $this->blog_id = $blog_id;
        $this->db = new DbConnector();
    }

    
    // Get all blogs or a single blog - public
    public function getBlogs($conn, $blog_id = null) {
        if ($blog_id !== null) {
            $sql = "SELECT * FROM blog WHERE blog_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $blog_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT * FROM blog ORDER BY published_date DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // Add new blog - admin
    public function addBlog($conn, $title, $content, $image, $date) {
        $sql = "INSERT INTO blog (title, content, image, published_date) VALUES (:title, :content, :image, :date)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':image' => $image,
            ':date' => $date
        ]);
    }

    // Delete blog - admin
    public function deleteBlog($conn, $blog_id) {
        $sql = "DELETE FROM blog WHERE blog_id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $blog_id]);
    }

  
}
?>