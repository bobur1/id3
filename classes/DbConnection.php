<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.10.2019
 * Time: 20:56
 */
include ('config.php');

Class DbConnection{
    function getDbConnect(){

        /* Attempt to connect to MySQL database */

        $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Check connection
        if($conn === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        return $conn;
    }
}
