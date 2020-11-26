<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24/10/2019
 * Time: 20:49
 */


class Furniture extends Product {

    private $height, $width, $length;

    public function __construct($sku=null, $name=null, $price=null,  $height=null, $width =null, $length=null){
        parent::__construct($sku, $name, $price);
        $this->type = "Furniture";
        $this->setHeight($height);
        $this->setWidth($width);
        $this->setLength($length);
        $this->setValue(null);
    }

    public function setHeight($height){
        if(is_numeric($height)) {
            $this->height = $height;
        }else{
            $this->setProductError("Invalid height '".$height."'. Must be numeric value");
        }
    }
    public function  getHeight(){
        return $this->height;
    }

    public function setWidth($width){
        if(is_numeric($width)) {
            $this->width = $width;
        }else{
            $this->setProductError("Invalid width '".$width."'. Must be numeric value");
        }
    }
    public function  getWidth(){
        return $this->width;
    }

    public function setLength($length){
        if(is_numeric($length)) {
            $this->length = $length;
        }else{
            $this->setProductError("Invalid length '".$length."'. Must be numeric value");
        }
    }
    public function  getLength(){
        return $this->length;
    }

    public function setValue($value){
        if(empty($this->getProductError())) {
            $this->value = $this->getHeight() . "x" . $this->getWidth() . "x" . $this->getLength();
        }else{
            $this->setProductError("incorrect value");
        }
    }




}