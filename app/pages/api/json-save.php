<?php

use Entity\Robot\OrderEntity;
get_class_file('entities', 'OrderEntity');

$data = decode_request($_POST['_'] ?? null);

if($data['_'] == 'save_json'){

    $oe = new OrderEntity();
    print_r($oe->order);

    $json = $data['req'] ?? '';
    
    file_put_contents('assets/js/vue.components/util/items.json',json_encode($json));

    sendJsonResponse(['res'=>'OK', 'err'=>false, 'written' => $json]);

}else
// if($data['_'] == 'get_json'){
    $oe = new OrderEntity();
    $oe->getOrders();
    // print_r($oe->orders[1]->password);
    sendJsonResponse($oe->orders);
    // $content = file_get_contents('assets/js/vue.components/util/items.json');

    // sendJsonResponse(json_decode($content));

// }