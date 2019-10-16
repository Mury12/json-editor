<?php

namespace Controller\Robot;
use Model\Robot\Order;
use Entity\Robot\OrderEntity;
\get_class_file('model', 'RobotOrder');
\get_class_file('entities', 'OrderEntity');

class OrderController
{
    public $order;
    public $entity;

    function __construct($data = null)
    {
        $this->order = new Order($data);
        $this->entity = new OrderEntity($this->order);
    }

    function getOrders()
    {
        return $this->entity->getOrders();
    }

    function saveOrder()
    {
        return $this->entity->saveOrder();    
    }

    function delItem($item_id)
    {
        return $this->entity->delItem($item_id);
    }
}