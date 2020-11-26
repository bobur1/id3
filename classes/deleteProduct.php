<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.10.2019
 * Time: 20:46
 */
include ('DbConnection.php');
if(isset($_POST['prod_id'])) {
    //create db object
    $Dbobj = new DbConnection();
    //connect
    $conn = $Dbobj->getdbconnect();
    // prod id will come in "val1,val2,.."
    $prod_id = trim($_POST['prod_id']);
    //search prod in "val1 val2 ..."
    $sql = "DELETE FROM products WHERE id in ($prod_id)";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
//return product id's which was deleted
echo $prod_id;
}