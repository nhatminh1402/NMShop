<?php
// Hàm kết nối đến database
class DataConnect {
  public $conn;
  protected $servername = "localhost";
  protected $username = "root";
  protected $password = "root";
  protected $dbName = "NMSHOP";

  function __construct() {
      try {
        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbName", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        die;
      }
  }

  
}
