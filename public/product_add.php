<?php
/**
 * Created by PhpStorm.
 * User: Bobur
 * Date: 11.10.2019
 * Time: 8:17
 */
//create empty vars for using

$errorMessage = [];

include_once '../classes/Product.php';
include_once '../classes/Book.php';
include_once '../classes/Dvd.php';
include_once '../classes/Furniture.php';

//check is there post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($_POST["switcher"]) {
        case "book":
            $product = new Book($_POST["sku"], $_POST["name"], $_POST["price"], $_POST["weight"]);
            if ($product->add()) {

            } else {
                $errorMessage = $product->getProductError();
            }
            break;
        case "dvd":

            $product = new Dvd($_POST["sku"], $_POST["name"], $_POST["price"], $_POST["size"], $_POST["size_type"]);
            if ($product->add()) {

            } else {
                $errorMessage = $product->getProductError();
            }
            break;
        case "furniture":
            $product = new Furniture($_POST["sku"], $_POST["name"], $_POST["price"], $_POST["height"], $_POST["width"], $_POST["length"]);
            if ($product->add()) {

            } else {
                $errorMessage = $product->getProductError();
            }
            break;
        default:
            $errorMessage=["Not right type of the Switcher"];
    }


            /*if ($product->insertProductWithAttribute($_POST)) {
                unset($_POST);
                //redirect_to('index.php');
        //        header("Location: " . $location);
        //        exit;
            } else {
                //else add to error message
                $errorMessage = $product->getError();
            }*/
        }


//include_once '../classes/DbConnection.php';
//
////check is there post request
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    $product = new DbConnection();
//    $helper = new Format();
//    if ($product->insertProductWithAttribute($_POST)) {
//        unset($_POST);
//        $helper->redirect_to('index.php');
//    } else {
//        //else add to error message
//        $errorMessage = $product->getError();
//    }
//}

include('shared/_header.php');
?>
<nav class="navbar navbar-expand navbar-light bg-light">


    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

        <a class="navbar-brand">Product Add</a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Product list </a>
            </li>

        </ul>
        <button class="btn border my-2 my-sm-0 btn-success" formmethod="post" form="new_product_form" name="submit">
            Save
        </button>
    </div>
</nav>
<div class="container-fluid">


    <div class="row p-3">

        <div class="col-md-6">
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
            <form id="new_product_form" method="post">
                <div class="form-group py-2 row">
                    <label class="px-2 col-2">SKU</label>
                    <input type="text" class="form-control col-6 <?= $products ? "is-invalid" : "" ?>"
                           value="<?= $_POST['sku'] ?? "" ?>" name="sku" placeholder="sku" required>
                </div>
                <div class="form-group py-2 row">
                    <label class="px-2 col-2">Name</label>
                    <input type="text" class="form-control col-6" value="<?= $_POST['name'] ?? "" ?>" name="name"
                           placeholder="Product Name" required>
                </div>
                <div class="form-group py-2 row">
                    <label class="px-2 col-2">Price</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" class="form-control col-5" value="<?= $_POST['price'] ?? "" ?>"
                           name="price" placeholder="999.99" step="0.01"
                           required max="42949672.95">
                </div>

                <div class="form-group py-2 row">
                    <label for="switcher" class="px-2 col-3">Type Switcher</label>
                    <select id="switcher" name="switcher" class="custom-select col-6" required>
                        <option value="" <?= isset($_POST['switcher']) ? "" : "selected" ?>>Type Switcher</option>
                        <option value="dvd" <?= (isset($_POST['switcher']) and $_POST['switcher'] == "dvd") ? "selected" : "" ?>>
                            DVD-disc
                        </option>
                        <option value="book" <?= (isset($_POST['switcher']) and $_POST['switcher'] == "book") ? "selected" : "" ?>>
                            Book
                        </option>
                        <option value="furniture" <?= (isset($_POST['switcher']) and $_POST['switcher'] == "furniture") ? "selected" : "" ?>>
                            Furniture
                        </option>
                    </select>
                </div>

                <div id="dvd">
                    <div class="form-group py-2 row">
                        <label for="size" class="px-2 col-2">Size</label>
                        <input type="number" id="size" value="<?= $_POST['size'] ?? "" ?>" name="size"
                               class="form-control col-3"
                               placeholder="1024">
                        <div class="input-group-append">
                            <select class="custom-select" name="size_type" required>
                                <option value="MB" selected>MB</option>
                                <option value="GB">GB</option>
                                <option value="TB">TB</option>
                            </select>
                        </div>
                    </div>
                    <span>Please provide size and select size type</span>
                </div>

                <div id="book">
                    <div class="form-group py-2 row">
                        <label for="weight" class="px-2 col-2">Weight</label>
                        <input type="text" id="weight" value="<?= $_POST['weight'] ?? "" ?>" name="weight"
                               class="form-control col-6" placeholder="700">
                    </div>
                    <span>Please provide weight in grams</span>
                </div>

                <div id="furniture">
                    <div class="form-group py-2 row">
                        <label for="height" class="px-2 col-2">Height</label>
                        <input type="number" id="height" value="<?= $_POST['height'] ?? "" ?>" name="height"
                               class="form-control col-6" placeholder="1" step="0.01">
                    </div>
                    <div class="form-group py-2 row">
                        <label for="width" class="px-2 col-2">Width</label>
                        <input type="number" id="width" value="<?= $_POST['width'] ?? "" ?>" name="width"
                               class="form-control col-6" placeholder="2" step="0.01">
                    </div>
                    <div class="form-group py-2 row">
                        <label for="length" class="px-2 col-2">Length</label>
                        <input type="number" id="length" value="<?= $_POST['length'] ?? "" ?>" name="length"
                               class="form-control col-6" placeholder="3" step="0.01">
                    </div>
                    <span>Please provide dimensions in HxWxL in meters</span>
                </div>

            </form>

        </div>

    </div>
</div>


<?php
include('shared/_footer.php');
?>

