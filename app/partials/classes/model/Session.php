<?php

namespace Model;
use \Exception;

class Session
{

    static function start()
    {
        if(!isset($_SESSION)) 
        {
            session_cache_expire(180);
            session_start();
        } 
    }

    static function abort()
    {
        isset($_SESSION)  ? session_destroy() : null;
    }

    static function restart()
    {
        if(isset($_SESSION)){
            session_reset();
            session_regenerate_id();
        }else{
            start();
        }
    }

    static function set($name, $value = null)
    {
        if(!isset($_SESSION)) session_start();
        if (!\is_object($value)) {
            $_SESSION[strrev(hash('whirlpool', $name))] = strrev(base64_encode(trim($value)));
        }else{
            $_SESSION[strrev(hash('whirlpool', $name))] = $value;
        }
    }

    static function get($name)
    {
        if (isset($_SESSION)) {
            $value = isset($_SESSION[strrev(hash('whirlpool', $name))])
                ? $_SESSION[strrev(hash('whirlpool', $name))]
                : false;

            if($value === false) return false;
            return is_object($value) ? $value : base64_decode(strrev($value));
        }

        throw new Exception("Session not registered.", 1);

    }

    static function unset($name)
    {
        if (isset($_SESSION)) {
            unset($_SESSION[strrev(hash('whirlpool', $name))]);
        }else{
            throw new Exception("Session not registered.", 1);
        }
    }

}