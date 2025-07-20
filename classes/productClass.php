<?php

class Product {
    private $product_id;
    private $product_name;
    private $category_id;
    private $price;
    private $quantity;
    private $image;
    private $description;
   

    // Constructor
    public function __construct($product_id = null, $product_name = null, $category_id = null, $price = null, $quantity = null, $image = null, $description = null) {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->category_id = $category_id;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->image = $image;
        $this->description = $description;
    }


    // Static methods for retrieving products
    public static function getAll($conn) {
        $query = "SELECT p.*, c.name as category_name FROM product p 
                  LEFT JOIN category c ON p.category_id = c.category_id 
                  ORDER BY p.product_id DESC";
        return $conn->query($query);
    }


}

?>