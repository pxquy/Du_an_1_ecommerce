<?php
class OrderController
{
    private $order;
    public function __construct()
    {
        $this->order = new Order();
    }
}