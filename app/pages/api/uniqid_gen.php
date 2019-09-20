<?php

    $d = time();
    $pre = 'unique_id_mm@@_';
    $pre = hash('sha256', $pre.$d);
    $uid ='';
    $len = 6;

    if(array_key_exists('len', $_GET)){
        $size = filter_input(INPUT_GET, 'len');
        if(ctype_digit($size) && $size <= 128){
            $len = $size;
        }else{
            sendJsonResponse(['res'=>'Length must be an integer below 128!', 'err'=>true]);
        return;
        }
    }

    for($i = 0; $i<$len; $i++){
        $uid .= substr($pre, rand(0, $len), 1);
    }
    sendJsonResponse(['res'=>$uid, 'length'=>strlen($uid), 'hash'=>$pre]);
    return;