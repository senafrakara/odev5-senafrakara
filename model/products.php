<?php

class Product
{

    private $conn;

    private $DBTable = "products";

    public string $uniqid;
    public string $name;
    public float $price;
    public string $description;
    public string $content;
    public string $categoryID;



    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function getProducts()
    {
        $products = $this->conn->prepare("SELECT uniqid, name, price, description, content, category FROM " . $this->DBTable . "");
        $products->execute();

        return $products;
    }

    public function addProduct()
    {
        $query = "INSERT INTO " . $this->DBTable . "(uniqid, name, price, description, content, category) VALUES 
                                                (:uniqid, :name, :price, :description, :content, :category)";

        $product = $this->conn->prepare($query);


        $product->bindParam(":uniqid", $this->uniqid, PDO::PARAM_STR);
        $product->bindParam(":name", $this->name, PDO::PARAM_STR);
        $product->bindParam(":price", $this->price, PDO::PARAM_INT);
        $product->bindParam(":description", $this->description, PDO::PARAM_STR);
        $product->bindParam(":content", $this->content, PDO::PARAM_STR);
        $product->bindParam(":category", $this->categoryID, PDO::PARAM_STR);


        $bool = $product->execute();
        if ($bool) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProduct()
    {
        $query = "UPDATE `" . $this->DBTable . "`SET 
        name= ?, price= ?, description= ?, content= ?, category= ? WHERE uniqid= ?";

        $product = $this->conn->prepare($query);

        $product->bindParam(1, $this->name, PDO::PARAM_STR);
        $product->bindParam(2, $this->price, PDO::PARAM_STR);
        $product->bindParam(3, $this->description, PDO::PARAM_STR);
        $product->bindParam(4, $this->content, PDO::PARAM_STR);
        $product->bindParam(5, $this->categoryID, PDO::PARAM_STR);
        $product->bindParam(6, $this->uniqid, PDO::PARAM_STR);


        $bool = $product->execute();
        if ($bool) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProduct()
    {
        $query = "DELETE FROM " . $this->DBTable . " WHERE uniqid = ?";

        $product = $this->conn->prepare($query);

        $product->bindParam(1, $this->uniqid, PDO::PARAM_STR);

        $bool = $product->execute();
        if ($bool) {
            return true;
        } else {
            return false;
        }
    }


    public function getCategory($id)
    {
        $query = "SELECT * FROM " . $this->DBTable . " p, category c where p.uniqid=? && p.category=c.uniqueid";
       

        $category = $this->conn->prepare($query);

        $category->bindParam(1, $id);
        $category->execute();

        $row = $category->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function getProduct()
    {
        $sqlQuery = "SELECT
                    uniqid, 
                    name, 
                    price, 
                    description, 
                    content, 
                    category
                  FROM
                    " . $this->db_table . "
                WHERE 
                   uniqid = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->uniqid);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $dataRow['name'];
        $this->price = $dataRow['price'];
        $this->description = $dataRow['description'];
        $this->content = $dataRow['content'];
        $this->categoryID = $dataRow['categoryID'];
    }

    //     public function appendProduct($id, $name, $price, $descr, $content, $cat){

    //     $this->uniqid = $id;
    //     $this->name = $name;
    //     $this->price = $price;
    //     $this->description = $descr;
    //     $this->content = $content;
    //     $this->categoryID = $cat;

    //     return $this;

    // }
}
