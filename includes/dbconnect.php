<?php

class DbConnector {
    private $host = 'localhost';
    private $dbuser = 'root';
    private $dbpw = '';
    private $dbname = 'suwoda';
    private $port = 3307;

    public function getConnection() {
        $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname;
        
        try {
            $con = new PDO($dsn, $this->dbuser, $this->dbpw);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }
}

?>


