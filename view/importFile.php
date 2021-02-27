<?php

include_once '..\conn.php';
include_once '..\model\products.php';
$db = new Database();
$conn = $db->getConn();

if (isset($_POST['buttomImport'])) {

    $json = file_get_contents($_FILES['jsonFile']['tmp_name'], 'jsonFiles/' . $_FILES['jsonFile']['name']);

    $data = json_decode($json, true);


    $bool = false;

    foreach ($data as $item) {
        extract($item);
        $query = $conn->prepare("SELECT uniqid FROM products WHERE uniqid= :uniqid");
        $query->bindParam(':uniqid', $uniqid);
        $query->execute();
       
        $count = $query->rowCount();
        if ($count > 0) {
            $_SESSION['error-import']= "";
            header("Location: index.php");
        } else {
            $stmt = $conn->prepare("INSERT INTO products(uniqid, name, price, description, content, category) 
        VALUES (:uniqid, :name, :price, :description, :content, :category)");
            // var_dump($item['name']);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':uniqid', $uniqid);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':content', $content);

            $stmt->bindParam(':category', $category['uniqid']);

            $bool = $stmt->execute();
            $bool = false;

            if ($bool = $stmt->execute()) {
                $_SESSION['success-import']= "";
                header("Location: index.php");
            } else {
                $_SESSION['error-import']= "";
                header("Location: index.php");
            }
           
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUCTS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="odev5-senafrakara\assets\style.css">


    <style>
        .import-json-form {
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
        }
    </style>

</head>


<body>
    <nav class="navbar navbar-light bg-light">
        <span class="navbar-brand mb-0 h1">PRODUCTS</span>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="import-json-form col-md-4 col-lg-4">
                <!-- <div class="import-json-form">
                <form method="post" enctype="multipart/form-data">
                    JSON File <input type="file" name="jsonFile">
                    <br>
                    <input type="submit" value="Import" name="buttomImport">
                </form>


            </div> -->
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1">JSON FILE</label>
                        <input type="file" class="form-control" name="jsonFile">
                    </div>
                    <button type="submit" name="buttomImport" class="btn btn-primary">Import</button>
                </form>
            </div>

        </div>



        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>