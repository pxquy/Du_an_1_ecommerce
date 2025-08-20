<?php
class ProductControllerImage {
    private $productImages;

    public function __construct(){
        $this->productImages = new ProductImage();
    }
}