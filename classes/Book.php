<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24/10/2019
 * Time: 20:49
 */


class Book extends Product {

    public function __construct($sku=null, $name=null, $price=null, $value=null){
        parent::__construct($sku, $name, $price);
        $this->type = "Book";
        $this->setValue($value);
    }

    public function setValue($value){
     $this->value=$value." gram";
    }




}