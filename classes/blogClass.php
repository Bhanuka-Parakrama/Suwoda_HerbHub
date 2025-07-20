<?php

class Blog {
    private $blog_id;
    private $title;
    private $content;
    private $published_date;
    private $image;

    public function __construct($blog_id = null) {
        $this->blog_id = $blog_id;
    }

    
    // Show blog details using object method
    public function showDetails($conn) {
        if (!$this->blog_id) {
            return null;
        }

        $query = "SELECT * FROM blog WHERE blog_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $this->blog_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            $this->title = $result['title'];
            $this->content = $result['content'];
            $this->published_date = $result['published_date'];
            $this->image = $result['image'];

        return $result;
    }

} 
}   
?>