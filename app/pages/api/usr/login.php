<?php
use Controller\User\UserController;
use Model\Session;
require_once('app/partials/classes/controller/UserController.php');
require_once('app/partials/classes/model/Session.php');

$data = decode_request($_POST['_']);

if (is_array($data) && array_key_exists('_', $data)){

    $_req = $data['req'] ?? false;

    if($_req){
        if($data['_'] == 'login'
            && array_key_exists('username', $_req)
            && array_key_exists('pwd', $_req)){

            $u = new UserController($_req);
            if($u->makeLogin()){
                sendJsonResponse(['res'=>'Você entrou!']);
            }else{
                sendJsonResponse(['res'=>'Usuário ou senha incorretos', 'err'=>true]);                
            }

        }
    }else{
        $u = new UserController('', '');
    }

    if($data['_'] == 'is_logged_in'){
        sendJsonResponse(['res'=>Session::get('logged_in') ?? false]);
    }

    if($data['_'] == 'logout'){
        if($u->makeLogout()){
            sendJsonResponse(['res'=>'Você saiu.']);
        }
    }
}
else
{
     sendJsonResponse(['res' => 'What did you said?']);
}

