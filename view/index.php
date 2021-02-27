<?php
// header("Content-Type: application/json");
// header("Access-Control-Allow-Origin: *");;
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '..\conn.php';
include_once '..\model\products.php';
include_once '..\model\categories.php';

$db = new Database();
$conn = $db->getConn();

$pr = new Product($conn);
$allProducts = $pr->getProducts();
$productCount = $allProducts->rowcount();


$category = new Category($conn);
$allCats = $category->getCategories();
$catRowCounts = $allCats->rowCount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUCTS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        .import-json-form {
            display: flex !important;
            flex-direction: row !important;
        }

        .products-index {
            margin: 5%;
        }

        .modal-title,
        .modal-body-text,
        .delete-button-modal,
        .cancel-button-modal {
            color: black !important;
        }
    </style>

</head>


<body>
    <nav class="navbar navbar-light bg-light">
        <span class="navbar-brand mb-0 h1">PRODUCTS</span>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="import-json-form col-md-8 col-lg-8">
                <?php if (isset($_SESSION['success-update'])) : ?>

                    <script>
                        setTimeout(function() {
                            alert('Product is updated successfully!');
                        }, 1000);
                    </script>

                <?php unset($_SESSION['success-update']);
                elseif (isset($_SESSION['error-update'])) : ?>
                    <script>
                        setTimeout(function() {
                            alert('Product isnot updated!');
                        }, 1000);
                    </script>
                <?php unset($_SESSION['error-update']);
                endif; ?>

                <?php if (isset($_SESSION['success-delete'])) : ?>

                    <script>
                        setTimeout(function() {
                            alert('Product is deleted successfully!');
                        }, 1000);
                    </script>

                <?php unset($_SESSION['success-delete']);
                elseif (isset($_SESSION['error-delete'])) : ?>
                    <script>
                        setTimeout(function() {
                            alert('Product isnot deleted!');
                        }, 1000);
                    </script>
                <?php unset($_SESSION['error-deleted']);
                endif; ?>

                <?php if (isset($_SESSION['success-add'])) : ?>

                    <script>
                        setTimeout(function() {
                            alert('Product is added successfully!');
                        }, 1000);
                    </script>

                <?php unset($_SESSION['success-add']);
                elseif (isset($_SESSION['error-add'])) : ?>
                    <script>
                        setTimeout(function() {
                            alert('Product isnot added!');
                        }, 1000);
                    </script>
                <?php unset($_SESSION['error-added']);
                endif; ?>


                <?php if (isset($_SESSION['success-import'])) : ?>

                    <script>
                        setTimeout(function() {
                            alert('File is uploaded successfully!');
                        }, 1000);
                    </script>

                <?php unset($_SESSION['success-import']);
                elseif (isset($_SESSION['error-import'])) : ?>
                    <script>
                        setTimeout(function() {
                            alert('File isnot uploaded! Please update the file!');
                        }, 1000);
                    </script>
                <?php unset($_SESSION['error-import']);
                endif; ?>




                <div class="list-group" style="margin-right: 3%;">
                    <a href="..\crud\read.php" class="list-group-item list-group-item-action list-group-item-success">Export File</a>
                </div>

                <div class="list-group" style="margin-right: 3%;">
                    <a href="importFile.php" class="list-group-item list-group-item-action list-group-item-success">Import File</a>
                </div>


                <div id="addProduct" style="margin-right: 3%;"><button type="button" class="btn btn-info btn list-group-item list-group-item-action list-group-item-success" data-toggle="modal" data-target="#addProduct-modal">Add Product</button></div>
                <div id="addProduct-modal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a class="close" data-dismiss="modal">×</a>
                                <h3>Add Product Form</h3>
                            </div>
                            <form id="productForm" name="addProduct" role="form" action="addProduct.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input  type="number" name="price" step="any" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea name="content" class="form-control" required></textarea>
                                    </div>
                                    <?php if ($catRowCounts > 0) :
                                        $count = 1;
                                    ?>
                                        <div class="form-group">
                                            <label for="cat">Choose a Category:</label>
                                            <select id="cats" name="cats" required>
                                                <?php foreach ($allCats as $cat) {

                                                    echo '<option value="' . $cat['uniqueid'] . '">' . $cat['name'] . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-success" id="AddProductsubmit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div id="addCategory"><button type="button" class="btn btn-info btn list-group-item list-group-item-action list-group-item-success" data-toggle="modal" data-target="#addCategory-modal">Add Category</button></div>
                <div id="addCategory-modal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a class="close" data-dismiss="modal">×</a>
                                <h3>Add Category Form</h3>
                            </div>
                            <form id="categoryForm" name="addCategory" role="form" action="addCategory.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-success" id="AddCategorysubmit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="products-index col-md-10 col-lg-10">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Description</th>
                            <th scope="col">Content</th>
                            <th scope="col">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($productCount > 0) {
                            $count = 0;


                            foreach ($allProducts as $product) {
                                $productID = 0;
                                $productID = $product['uniqid'];
                                // $catNAME =  $pr->getCategory($productID)['uniqueid'];
                        ?>
                                <tr>
                                    <th scope="row"><?= $count ?></th>
                                    <td><?= $productID ?></td>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= $product['price'] ?></td>
                                    <td><?= $product['description'] ?></td>
                                    <td><?= $product['content'] ?></td>
                                    <td><?= $pr->getCategory($productID)['name'] ?></td>
                                    <td> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal<?= $productID ?>">DELETE </button> </td>

                                    <!-- DELETE Modal -->
                                    <td>
                                        <div class="modal fade" id="deleteModal<?= $productID ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="modal-body-text">Do you really want to delete these records? This process cannot be undone.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary close-button-modal" data-dismiss="modal">Close</button>
                                                        <a href="deleteProduct.php?id=<?= $productID ?>" class="btn btn-primary delete-button-modal">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div id="updateProduct"><button type="button" class="btn btn-info btn-xs edit_data" data-toggle="modal" data-target="#updateProduct-modal<?= $productID ?>">Update Product</button></div>
                                    </td>
                                    <div id="updateProduct-modal<?= $productID ?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="color: black !important;">
                                                    <a class="close" data-dismiss="modal">×</a>
                                                    <h3 style="color: black !important;">Update Product Form</h3>
                                                </div>
                                                <form id="productForm" name="updateProduct" action="updateProduct.php?id=<?= $productID ?>" method="POST">
                                                    <div class="modal-body">
                                                        <div class="form-group" style="color: black !important;">
                                                            <label for="name">Name</label>
                                                            <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
                                                        </div>
                                                        <div class="form-group" style="color: black !important;">
                                                            <label for="price">Price</label>
                                                            <input type="number" name="price" class="form-control" step="any" value="<?= $product['price'] ?>" required>
                                                        </div>
                                                        <div class="form-group" style="color: black !important;">
                                                            <label for="description">Description</label>
                                                            <textarea name="description" class="form-control" required><?= $product['description'] ?></textarea>
                                                        </div>
                                                        <div class="form-group" style="color: black !important;">
                                                            <label for="content">Content</label>
                                                            <textarea name="content" class="form-control" required><?= $product['content'] ?></textarea>
                                                        </div>
                                                        <?php
                                                        $category = new Category($conn);
                                                        $cats = $category->getCategories();
                                                        $catRowCounts = $cats->rowCount();

                                                        if ($catRowCounts > 0) :
                                                            $count = 1;
                                                        ?>
                                                            <div class="form-group" style="color: black !important;">
                                                                <label for="cat">Choose a Category:</label>
                                                                <select id="cats" name="cats" required>
                                                                    <?php foreach ($cats as $cat) {
                                                                        if ($product['category'] == $cat['uniqueid']) {
                                                                            echo '<option value="' . $cat['uniqueid'] . '" selected>' . $cat['name'] . '</option>';
                                                                        } else {
                                                                            echo '<option value="' . $cat['uniqueid'] . '" >' . $cat['name'] . '</option>';
                                                                        }
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="modal-footer" style="color: black !important;">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success" id="UpdateProductsubmit">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                </tr>

                        <?php $count++;
                            }
                        } else {
                            echo '<h1>There is no product!</h1>';
                        }

                        ?>

                    </tbody>
                </table>

                <!-- EDIT MODAL -->
                <!-- <div id="updateProduct" style="margin-right: 3%;"><button type="button" class="btn btn-info btn list-group-item list-group-item-action list-group-item-success" data-toggle="modal" data-target="#addProduct-modal">Add Product</button></div> -->

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#productForm").submit(function(event) {
                event.preventDefault();
                var post_url = $(this).attr("action");
                var request_method = $(this).attr("method");
                var form_data = $(this).serialize();

                $.ajax({
                    url: post_url,
                    type: request_method,
                    data: form_data
                }).done(function(response) {
                    $("#server-results").html(response);
                });

            });
            $("#categoryForm").submit(function(event) {
                event.preventDefault();
                var post_url = $(this).attr("action");
                var request_method = $(this).attr("method");
                var form_data = $(this).serialize();

                $.ajax({
                    url: post_url,
                    type: request_method,
                    data: form_data
                }).done(function(response) {
                    $("#server-results").html(response);
                });

            });

            function updateProduct(productID) {
                $.ajax(

                )
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="hhttps://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>

</html>