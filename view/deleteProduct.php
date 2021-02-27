<?php
include_once '..\conn.php';
include_once '..\model\products.php';


$db = new Database();
$conn = $db->getConn();

$product = new Product($conn);

try {

    if (isset($_GET['id']) && $_GET['id']) {
        $product->uniqid = $_GET['id'];

        if ($product->deleteProduct()) {
            $_SESSION['success-delete']= "";
            header("Location: index.php");
        } else {
            $_SESSION['error-delete']= "";
            header("Location: index.php");
        }
    }
} catch (PDOException $e) {
    die('ERROR: ' . $e->getMessage());
}
