<?php

class Format
{
    public function __construct(){
        $_GET       = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $_POST      = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $_REQUEST   = (array)$_POST + (array)$_GET + (array)$_REQUEST;
    }

//test input data
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

//simplify using
    function redirect_to($location)
    {
        header("Location: " . $location);
        exit;
    }

    public function sqlWithArray($connection,$array){
        $return = array();
        foreach($array as $field=>$val){
            $return[$field] = "'".mysqli_real_escape_string($connection,$this->test_input($val))."'";
        }
        return $return;
    }
}