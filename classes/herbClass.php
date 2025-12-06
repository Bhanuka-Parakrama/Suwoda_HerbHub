<?php

require_once '../includes/dbconnect.php';

class Herb {
    private $herb_id;
    public $name;
    public $scientific_name;
    public $uses;
    public $images;
   
    
    // Constructor
    public function __construct($herb_id = null, $name = '', $scientific_name = '', $uses = '', $images = '') {
        global $conn;
        $this->conn = $conn;
        $this->herb_id = $herb_id;
        $this->name = $name;
        $this->scientific_name = $scientific_name;
        $this->uses = $uses;
        $this->images = $images;
    }
    
    
    // Get all herbs or a specific herb - public
    public function getHerbs($herb_id = null) {
        if ($herb_id !== null) {
            $sql = "SELECT * FROM herb WHERE herb_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $herb_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT * FROM herb ORDER BY name";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // Add new herb -- admin
    public function addHerb($name, $scientific_name, $uses, $image) {
        $sql = "INSERT INTO herb (name, scientific_name, uses, image) VALUES (:name, :scientific_name, :uses, :image)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':scientific_name' => $scientific_name,
            ':uses' => $uses,
            ':image' => $image
        ]);
    }

    // Update herb -- admin
    public function updateHerb($herb_id, $name, $scientific_name, $uses, $image) {
        $sql = "UPDATE herb SET name=:name, scientific_name=:scientific_name, uses=:uses, image=:image WHERE herb_id=:herb_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':herb_id' => $herb_id,
            ':name' => $name,
            ':scientific_name' => $scientific_name,
            ':uses' => $uses,
            ':image' => $image
        ]);
    }

    // Delete herb -- admin
    public function deleteHerb($herb_id) {
        $sql = "DELETE FROM herb WHERE herb_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $herb_id]);
    }

    // Get herb image by ID -- admin
    public function getHerbImage($herb_id) {
        $sql = "SELECT image FROM herb WHERE herb_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $herb_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['image'] : null;
    }
}