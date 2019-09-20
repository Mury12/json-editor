<?php

$data = $_POST;

if($data['exec'] == 'save_json'){

    $json = $data['data'];
    
    file_put_contents('assets/js/vue.components/util/items.json',json_encode($json));

    sendJsonResponse(['res'=>'OK', 'err'=>false, 'written' => $json]);

}else
if($data['exec'] == 'get_json'){
    $content = file_get_contents('assets/js/vue.components/util/items.json');

    sendJsonResponse(json_decode($content));

}