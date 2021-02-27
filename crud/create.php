<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");;
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once 'conn.php';
include_once 'model\products.php';

$db = new Database();
$conn = $db->getConn();

$product = new Product($conn);

$data = json_decode(file_get_contents("php://input"));

foreach ($data as $item) {
    $item->name = $item['name'];
    $item->uniqid = $item['uniqid'];
    $item->description = $item['description'];
    $item->content = $item['content'];
    foreach ($item['category'] as $cat) {
        $item->categoryID = $cat['uniqid'];
        $item->name = $cat['name'];
    }
    if ($item->addProduct()) {
        echo 'Product created successfully.';
    } else {
        echo 'Product could not be created.';
    }

}
