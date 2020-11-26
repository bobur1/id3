<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24/10/2019
 * Time: 20:49
 */

class Dvd extends Product {

    private $sizeType;

    public function __construct($sku=null, $name=null, $price=null, $value=null, $sizeType=null){
        parent::__construct($sku, $name, $price);

        $this->type = "Dvd-disc";
        $this->setSizeType($sizeType);
        $this->setValue($value);

    }

    public function setSizeType($sizeType){

        if(in_array($sizeType, array("MB", "TB", "GB"))){
            $this->sizeType = $sizeType;
        }else{
            $this->setProductError("Invalid size type '".$sizeType."'");
        }
    }
    public function getSizeType(){
        return $this->sizeType;
    }

    public function setValue($value){

            $this->value = $value . " " . $this->getSizeType();

    }

}