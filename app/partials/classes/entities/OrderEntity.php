<?php

namespace Entity\Robot;
use \PDO;
use Model\Robot\Order;
require_once('app/partials/classes/model/RobotOrder.php');

class OrderEntity
{
    public $orders;
    private $conn;
    function __construct()
    {
        global $conn;
        if($conn) 
            $this->conn = $conn; 
        else echo 'DB Connection not available.';
    }

    function getOrders($lim = 100)
    {
        $query = "SELECT * FROM show_orders_list ORDER BY expires_at DESC LIMIT ".$lim;

        $q = $this->conn->prepare($query);
        
        if($q->execute() && $q->rowCount() > 0){
            
            $r = Array();
            $r = makeArrayFromQuery($q, 'Model\Robot\Order');
            
            $this->orders = $r;
            return true;
        }
        return false;
    }

}