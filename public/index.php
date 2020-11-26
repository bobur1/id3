<?php

//include_once '../classes/DbConnection.php';

include_once '../classes/Product.php';
include_once '../classes/Book.php';

//add header
include('shared/_header.php');
////new object of the Product class
//$gateway = new DbConnection();
//if (isset($_POST["checkboxvar"])) {
//    $gateway->deleteProducts($_POST["checkboxvar"]);
//    unset($_POST["checkboxvar"]);
//}
////get all product from db
//$products = $gateway->showProduct();
$gateway = new Book();
$errorMessage = [];
if (isset($_POST["checkboxvar"])) {
    $gateway->setDeleteIds($_POST["checkboxvar"]);
    $response = $gateway->deleteProducts();
    if(!is_array($response)){
        unset($_POST["checkboxvar"]);

    } else{
        $errorMessage = $response;
    }
}
$products = $gateway->showProducts();



?>
    <nav class="navbar navbar-expand navbar-light bg-light">


        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand">Product List</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="product_add.php">Product add</a>
                </li>
            </ul>
        <div class="inline">
            <select class="mr-sm-2 py-1">
                <option selected>Mass delete</option>
            </select>
            <button class="btn border btn-info my-2 my-sm-0" name="submit" formmethod="post" form="delete_product">Apply</button>
        </div>
        </div>
    </nav>
    <div class="container">
        <form id="delete_product" action="" method="post">
            <?php if (!empty($errorMessage)) { ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Error!</strong>
                    <ul>
                        <?php foreach ($errorMessage as $errorText) { ?>
                            <li><?= $errorText ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        <div class="row">

            <?php
            //check if there any data returns
            if ($products) {

                foreach ($products as $product) {

                    ?>
                    <div class="col-md-3 col-sm-6 col-12" id="prod<?= $product["id"]; ?>">
                        <div class="my-list">
                            <span class="pull-right"><input type="checkbox" name='checkboxvar[]' value="<?= $product["id"]; ?>" class="prod_checkbox"
                                                            data-prod-id="<?= $product["id"]; ?>"></span>
                            <div class="px-4 text-center">
                                <h3><?= $product['name'] ?></h3>
                                <div>SKU: <?= $product['SKU'] ?></div>
                                <span>Price: <?= $product['price'] / 100 ?>$</span>
                                <div><?= $product['type'] ?>: <?= $product['value'] ?></div>
                            </div>
                        </div>
                    </div>
                    <?php

                }
            }
            ?>

        </div>
        </form>

    </div>


<?php include('shared/_footer.php'); ?>