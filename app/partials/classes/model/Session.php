<?php

namespace Model;

class Session
{
    private $ssid;
    private $ssval;
    private $hash = 'sha256';

    function initSession()
    {
        session_start();
    }

    function endSession(){
        $_SESSION = [];
        session_destroy();
    }

    function setHash($hashName){
        $this->hash = $hashName;
    }

    function newSessionValue($ssid = null, $ssval = null){
        if($ssid != null){
            $_SESSION[hash($this->hash, $ssid)] = $ssval;
        }
    }
}