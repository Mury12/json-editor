<?php

namespace Entity;
use \PDO;

class UserEntity
{
    private $_object;
    private $_con;

    function __construct($object)
    {
        global $conn;
        $this->_object = $object;
        $this->_con    = $conn;
    }

    /**
     * verify informations
     */
    function trust()
    {
        __PW_ENCRYPTION__
            ? $this->_object->setPass(hash('sha256', $this->_object->getPass()))
            : null;

        $uname = $this->_object->getUName();
        $upass = $this->_object->getPass();

        $query = " SELECT user_id as _id, user_name, user_email FROM users WHERE ";
        $query.= " user_name = ? AND user_pass = ?";

        $q = $this->_con->prepare($query);

        $q->bindParam(1, $uname);
        $q->bindParam(2, $upass);

        if($q->execute() && $q->rowCount() === 1){

            $r = $q->fetch(PDO::FETCH_NUM);

            $this->_object->setId($r[0]);
            $this->_object->setName($r[1]);
            $this->_object->setEmail($r[2]);

           return $this->_object;
        }
        return false;
    }

    /**
     * Records the login into the database
     */
    function loginLogger()
    {
        $remote  = quote_content($_SERVER['REMOTE_ADDR']);
        $forwar  = quote_content($_SERVER['HTTP_X_FORWARDED_FOR']);
        $uagent  = quote_content($_SERVER['HTTP_USER_AGENT']);
        $day  = date("Y-m-d");
	    $time = date("H:i:s");
        $type = "admin";

        $query = " INSERT INTO log_acesso (login, ip1, ip2, ip3, dia, hora, tipo) ";
        $query.= " VALUES (?, ?, ?, ?, ?, ?, ?)";

        $q = $this->_con->prepare($query);
        $uname = $this->_object->getUName();
        $q->bindParam(1, $uname);
        $q->bindParam(2, $remote);
        $q->bindParam(3, $forwar);
        $q->bindParam(4, $uagent);
        $q->bindParam(5, $day);
        $q->bindParam(6, $time);
        $q->bindParam(7, $type);

        return $q->execute();
    }

    /**
     * Registers the daily token
     */
    function registerToken()
    {
        $query = "select fnc_registro_token_diario(?, ?, ?, ?)";

        $umail = $this->_object->getEmail();
        $token = token_gen();
        $from  = quote_content($_SERVER['REMOTE_ADDR']);
        $itok  = __INTERNAL_TOKEN_HASH__;

        $q = $this->_con->prepare($query);
        $q->bindParam(1, $umail);
        $q->bindParam(2, $token);
        $q->bindParam(3, $from);
        $q->bindParam(4, $itok);

        if($q->execute()){
            $r = $q->fetch(PDO::FETCH_NUM);

            $this->_object->setToken($r[0]);

            if(__SEND_TOKENS__ && $this->_object->getToken() == $token):
                if(!$this->_object->sendToken()){
                    error_log("New token sent.");
                    return 2;
                }
            endif;

            return $this->_object;
        }
        return false;
    }



}