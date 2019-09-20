<?php

namespace Controller\User;

use Model\User;
require_once ('app/partials/classes/model/User.php');
use Entity\UserEntity;
require_once('app/partials/classes/entities/UserEntity.php');

class UserController
{
    private $usr;
    private $ue;
    function __construct($request = null){
        if($request != null){
            $this->usr = new User($request);
            $this->ue  = new UserEntity($request);
        }
    }

    function login()
    {
        global $_s;
        if($uid = $this->ue->bindUserPassword()){
                \sendJsonResponse(['res'=> "Você entrou!", 'err'=>false]);
                $_s->newSessionValue('auth', true);
                $_s->newSessionValue('uid', $uid);
            return true;
        }else{
            \sendJsonResponse(['res'=>'Seu e-mail ou senha estão incorretos!','err'=>true]);
        }
        return false;
    }

    function isLoggedIn()
    {
        if(\array_key_exists(hash('sha256', 'auth'), $_SESSION) && $_SESSION[hash('sha256', 'auth')]){
            return true;
        }   
        return false;
    }

    function logOut()
    {
        $_SESSION = [];
        session_destroy();
        \sendJsonResponse(['res'=>'Você saiu.']);
    }


}
