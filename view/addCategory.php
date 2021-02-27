<?php
include_once '..\conn.php';
include_once '..\model\categories.php';

$db = new Database();
$conn = $db->getConn();

$cat = new Category($conn);

if (isset($_GET['name'])) {

    $cat->name = $_GET['name'];

    while (true) {

        $uniqid = uniqid();
        
        $query = $conn->prepare("SELECT uniqueid FROM category WHERE uniqueid= :uniqid");
        $query->bindParam(':uniqid', $uniqid);
        $query->execute();

        $count = $query->rowCount();

        if ($count == 0) {
            $id = $uniqid;
            // return false; //break the loop
            break;
        }
        
    }

    $cat->uniqid = $id;


    if ($cat->addCategory()) {
        $success = "Category is added succesfully!";
        header("Location: index.php?success=$success");
    } else {
        echo "Category eklenemedi allahın cezası";
    }
}
