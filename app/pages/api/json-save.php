<?php

use Controller\Robot\OrderController;
get_class_file('controller', 'OrderController');

$data = decode_request($_POST['_'] ?? null);

if($data['_'] == 'save_json'){


    $oc = new OrderController($data['req']);

    if($oc->saveOrder()){
        sendJsonResponse(['res'=>'OK', 'err'=>false]);   
    }else{
        sendJsonResponse(['res'=>'NOK', 'err'=>true]);
    }

}else
if($data['_'] == 'get_json'){
    
    $oc = new OrderController();
    $r = $oc->getOrders();

    sendJsonResponse($r ? $r : [Array('')]);

}else
if($data['_'] == 'del_item'){

    $oc = new OrderController();
    if ($oc->delItem($data['req']['item_id'])){
        sendJsonResponse(['res' => 'Item excluído com sucesso.', 'err' => false]);    
        return;
    }
    sendJsonResponse(['res' => 'Houve um problema ao excluir este item.', 'err' => true]);    
    return;
}else
if($data['_'] == 'change_json'){
    $oc = new OrderController($data['req']);
    sendJsonResponse(['res' => 'OK', 'err' => false]);        
}