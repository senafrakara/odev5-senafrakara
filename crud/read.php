<?php
header("Content-Type: application/json");
header("Content-Disposition: attachment; filename=products.json");

// include_once 'conn.php';
// include_once 'model\products.php';
// include_once 'model\categories.php';
include_once '..\conn.php';
include_once '..\model\products.php';
include_once '..\model\categories.php';

$db = new Database();
$conn = $db->getConn();

$product = new Product($conn);

$products = $product->getProducts();
$productCount = $products->rowcount();


if ($productCount > 0) { //if there are some products in db

    $productsArr = array();

    while ($row = $products->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $p = array(
            "uniqid" => $uniqid,
            "name" => $name,
            "price" => $price,
            "description" => $description,
            "content" => $content,
            "category" => array(
                "uniqid" => $category,
                "name" => getCatName($category)

            )

        );

        array_push($productsArr, $p);
    }

    echo json_encode($productsArr, JSON_PRETTY_PRINT);
} else {
    http_response_code(404);

    echo json_encode(array("message" => "There is no record"));
}

function getCatName($id)
{
    $DB = new Database();
    $connection = $DB->getConn();
    $cat = $connection->prepare("SELECT * FROM category WHERE uniqueid = ?");
    $cat->bindParam(1, $id);
    $cat->execute();
    $data = $cat->fetch(PDO::FETCH_ASSOC);
    
    return $data['name'];
       
    
}
