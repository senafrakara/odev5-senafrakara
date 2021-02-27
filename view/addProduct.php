<?php
include_once '..\conn.php';
include_once '..\model\products.php';


$db = new Database();
$conn = $db->getConn();

$product = new Product($conn);

if (isset($_GET['name'])) {

    $product->name = $_GET['name'];
    $product->price = $_GET['price'];
    $product->description = $_GET['description'];
    $product->content = $_GET['content'];
    $product->categoryID = $_GET['cats'];

  

    while (true) {

        $uniqid = uniqid();
        
        $query = $conn->prepare("SELECT uniqid FROM products WHERE uniqid= :uniqid");
        $query->bindParam(':uniqid', $uniqid);
        $query->execute();

        $count = $query->rowCount();

        if ($count == 0) {
            $id = $uniqid;
            // return false; //break the loop
            break;
        }
        
    }

    $product->uniqid = $id;
    
     if ($product->addProduct()) {
        $_SESSION['success-add']= "";
        header("Location: index.php");
    } else {
        $_SESSION['error-add']= "";
        header("Location: index.php");
    }
}
