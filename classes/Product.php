<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24/10/2019
 * Time: 20:14
 */
require_once  ('class.Database.php');
abstract class Product extends Database
{
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    protected $value;
    protected $productError;
    protected $deleteIds;
    public function __construct($sku, $name, $price){
        parent::__construct();
        $this->setSku($sku);
        $this->setName($name);
        $this->setPrice($price);


    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setSku($sku)
    {
        $this->sku = $this->test_input($sku);
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setName($name)
    {
        $this->name = $this->test_input($name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice($price)
    {
        if (is_numeric($price))
        $this->price = ($this->test_input($price))*100;
        else
            $this->SetProductError("Price should be in numeric format");
    }

    public function getPrice()
    {
        return $this->price;
    }
    public function setProductError($productError)
    {
        $this->productError[] = $productError;
    }

    public function getProductError()
    {
        return $this->productError;
    }

    public function setType($type)
    {
        return $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }

    public function setValue($value)
    {
        return $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }

    public function showProducts(){
        return $this->Select("products","products.*, attributes.type, attributes.value","","attributes on products.id = attributes.product_id", "products.id", "desc");

    }

    public function setDeleteIds($ids){
        $this->deleteIds = implode("','", $ids);
    }
    public function getDeleteIds(){
        return $this->deleteIds;
    }

    public function deleteProducts(){

        return $this->Delete("products", "id", $this->getDeleteIds());

    }


    public function add(){
        if (empty($this->getProductError())){

            $insertProduct =  $this->Insert("products", ["SKU"=>$this->getSku(), "name"=>$this->getName(), "price"=>$this->getPrice()]);
            if(!is_array($insertProduct)){

                $insertProductAttribute =  $this->Insert("attributes", ["type"=>$this->getType(), "value"=>$this->getValue(), "product_id"=>$insertProduct]);
                if (!is_array($insertProductAttribute)){
                    return true;
                }else{
                    $this->setProductError($insertProductAttribute["error"]);
                    return false;
                }
            }else{
                $this->setProductError($insertProduct["error"]);
                return false;
            }

        }
        return false;
    }





}