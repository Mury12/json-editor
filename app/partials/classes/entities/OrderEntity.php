<?php

namespace Entity\Robot;
use \PDO;
use Model\Robot\Order;
require_once('app/partials/classes/model/RobotOrder.php');

class OrderEntity
{
    public $orders;
    private $conn;
    private $o;

    function __construct($order = null)
    {
        global $conn;
        $this->o = $order;
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
            
            return $r;
        }
        return false;
    }

    function saveOrder()
    {

        $this->o->key   = $this->o->editing ? $this->o->key      : \getUniquid(6)['res'];
        $this->o->pass  = $this->o->editing ? $this->o->password : \getUniquid(8)['res'];
        $this->o->token = $this->o->editing ? $this->o->token    : \getUniquid(32, $this->o->owner->owner_name)['res'];



        $_renew_expires = strlen($this->o->renew_expires_at ?? 0) < 10 ? null : $this->o->renew_expires_at;
        $_oid = $this->o->editing ? $this->o->order_id : 0;
        $query = "call sp_create_order(?,?,?,?,?,?,?,?,?,?,?)";

        $q = $this->conn->prepare($query);
        $q->bindParam(1, $this->o->owner->owner_name);
        $q->bindParam(2, $this->o->robot_number);
        $q->bindParam(3, $this->o->platform->platform_code);
        $q->bindParam(4, $this->o->account_freed);
        $q->bindParam(5, $this->o->expires_at);
        $q->bindParam(6, $_renew_expires);
        $q->bindParam(7, $this->o->token);
        $q->bindParam(8, $this->o->key);
        $q->bindParam(9, $this->o->pass);
        $q->bindParam(10,$this->o->comment);
        $q->bindParam(11, $_oid);
        
        // print_r($_renweal);
        // print_r($this->o->comment);
        try {
            if($q->execute()){
                return true;
            }
            file_put_contents('app/partials/classes/log.txt', implode(" ",$q->errorInfo())."\n", FILE_APPEND);
        } catch (PDOException $th) {
            file_put_contents('app/partials/classes/log.txt', $th."\n", FILE_APPEND);
        }
        return false;
    }



    function delItem($item_id)
    {
        $query = "call sp_delete_item(?)";

        $q = $this->conn->prepare($query);
        $q->bindParam(1, $item_id);

        return $q->execute();

    }

}