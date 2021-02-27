<?php

class Category
{

    private $conn;

    private $DBTable = "category";

    public $uniqid;
    public $name;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function getCategories()
    {
        $cats = $this->conn->prepare("SELECT uniqueid, name FROM " . $this->DBTable . " ORDER BY name ASC");
        $cats->execute();

        return $cats;
    }


    public function addCategory()
    {
        $query = "INSERT INTO " . $this->DBTable . "(uniqueid, name) VALUES 
                                                (:uniqid, :name)";

        $category = $this->conn->prepare($query);


        $category->bindParam(":uniqid", $this->uniqid, PDO::PARAM_STR);
        $category->bindParam(":name", $this->name, PDO::PARAM_STR);


        $bool = $category->execute();
        if ($bool) {
            return true;
        } else {
            return false;
        }
    }


}
