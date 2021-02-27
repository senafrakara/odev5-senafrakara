<?php 
session_start();
ob_start();

class Database{

    private $host="localhost";
    private $dbName="bootcampProducts";
    private $user = "root";
    private $pass = "";

    public $conn;

    public function getConn(){
        $this->conn=null;

        try{
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->dbName, $this->user, $this->pass);
    
        } catch(PDOException $e){
            echo "Databasase connection is failed!";
        }

        return $this->conn;
    }

}

?>
