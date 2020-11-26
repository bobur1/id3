<?php

//include_once '../classes/DbConnection.php';

include_once '../classes/questions.php';

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
$gateway = new Questions();
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
$gateway->show();


?>



<?php include('shared/_footer.php'); ?>