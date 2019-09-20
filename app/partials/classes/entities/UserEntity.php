<?php

namespace Entity;
use \PDO;

class UserEntity
{
    private $name;
    private $email;
    private $pwd;
    private $st = 1;

    function __construct($data)
    {
        if($data!=null){
            if(array_key_exists('name', $data)){
                $this->name  = $data['name'];
            }
            
            if(array_key_exists('email', $data)){
                $this->email = $data['email'];
                error_log($this->email);
            }

            if(array_key_exists('pwd', $data)){
                $this->pwd   = hash('sha256',$data['pwd']);
            }
        }

    }


    function bindUserPassword()
    {
        \error_log($this->pwd .' | '. $this->email);
        return (_USER_ADMIN_NAME_ == $this->email && hash('sha256', _USER_ADMIN_PSWD_) == $this->pwd);
    }



}