<?php
include_once '..\conn.php';
include_once '..\model\products.php';


$db = new Database();
$conn = $db->getConn();

$product = new Product($conn);


if (isset($_GET['id']) && $_GET['id']) {

    $product->uniqid = $_GET['id'];
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->content = $_POST['content'];
    $product->categoryID = $_POST['cats'];
    
  
    if ($product->updateProduct()) {
        $_SESSION['success-update']= "";
        header("Location: index.php");
    } else {
        $_SESSION['error-update']= "";
        header("Location: index.php");
    }
}
