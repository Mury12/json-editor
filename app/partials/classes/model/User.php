<?php

namespace Model;

use Entity\UserEntity;
require_once('app/partials/classes/entities/UserEntity.php');

class User
{
    private $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    function login()
    {
        $ue = new UserEntity($this->request);
        if($uid = $ue->bindUserPassword()){
            $_SESSION[hash('sha256','auth')] = true;
            $_SESSION[hash('sha256','uid')]  = $uid;
            return $this->generateLoginToken($uid);
        }
        return false;
    }

    function isLoggedIn(){
        if($_SESSION[hash('sha256', 'auth')]){
            return true;
        }   
        return false;
    }

    function logOut(){
        $_SESSION = [];
        session_destroy();
        \sendJsonResponse(['res'=>'Você saiu.']);
    }

    function generateLoginToken($uid)
    {
        $tok    = "tok_mmadvq_";
        $_h     = microtime(true).$this->request['pwd'].$uid."tok@m..OklH44";
        $hash   = hash("sha256", $_h);
        $tok   .= $hash;

        return $tok;
    }

    function getName()
    {
        return $this->name;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getPwd()
    {
        return $this->pwd;
    }

    function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    function setPwd($pwd)
    {
        $this->pwd = hash('sha256', $pwd);
        return $this;
    }


}





