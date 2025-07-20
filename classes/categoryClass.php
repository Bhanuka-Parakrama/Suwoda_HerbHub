<?php
class Category {
    private $category_id;
    private $name;
    private $description;
    private $image;

    public function __construct($category_id = null) {
        $this->category_id = $category_id;
    }

 public static function getAllCategories($conn) {
    $sql = "SELECT * FROM category";
    $result = $conn->query($sql);

    $categories = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    return $categories;
}


    // Show category details using object method
    public function showDetails($conn) {
        if (!$this->category_id) {
            return null;
        }

        $query = "SELECT * FROM category WHERE category_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $this->category_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            $this->name = $result['name'];
            $this->image = $result['image'];
        }

        return $result;
    }
}
?>
