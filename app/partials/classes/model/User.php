<?php

namespace Model;

use Entity\UserEntity;
require_once('app/partials/classes/entities/UserEntity.php');

class User
{
    private $uname;
    private $upass;
    private $realname;
    private $umail;
    private $uid;
    private $utoke;
    public  $verified;

    function __construct($uname = null, $upass = null)
    {
        $this->uname = $uname;
        $this->upass = $upass;

        $this->verify();
    }

    private function verify()
    {
        if($this->uname != null && $this->upass != null){
            $this->uname = addslashes($this->uname);
            $this->upass = addslashes($this->upass);

            $this->verified = true;
            return;
        }
        $this->verified = false;
    }

    function tokenVerification($_object)
    {
        if (is_object($_object) && ($_object instanceof LoginModel)) {
            return $this->utoke === $_object->getToken();
        }
        return false;
    }

    function sendToken()
    {

        $msg = '<html>Olá, '.$this->uname.'.<br/>';
        $msg.= '<br>Seu token de acesso diário é: '.$this->utoke.'<br/>';
        $msg.= 'Atenciosamente, UNICK Administrativo.<br/></html>';

        $data = array(
            'msg' => $msg,
            'target' => $this->umail,
            'subject' => 'Seu token de acesso diário'
        );

        $w = new Email($data);

        return $w->send();
    }

    /**
     * getters/setters
     */
    function setToken($tok)
    {
        $this->utoke = addslashes($tok);
    }

    function setId($uid)
    {
        $this->uid = addslashes($uid);
    }

    function setName($name)
    {
        $this->realname = $name;
    }

    public function setPass($upass)
    {
        $this->upass = $upass;
    }

    public function getUName()
    {
        return $this->uname;
    }

    function getName()
    {
        return $this->realname;
    }

    function getToken()
    {
        return $this->utoke;
    }

    public function getPass()
    {
        return $this->upass;
    }

    function setEmail($umail)
    {
        $this->umail = $umail;
    }

    function getEmail()
    {
        return $this->umail;
    }
    public function getId()
    {
        return $this->uid;
    }


}





