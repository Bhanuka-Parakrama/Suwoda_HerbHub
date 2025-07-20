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

    // Static method to get all blogs
    public static function showDetail($conn) {
        $query = "SELECT * FROM blog ORDER BY published_date DESC";
        $result = $conn->query($query);

        $blogs = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $blogs[] = $row;
            }
        }
        return $blogs;
    }

    // Optional: Show one blog detail (by instance)
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
        return null;
    }
}
?>
