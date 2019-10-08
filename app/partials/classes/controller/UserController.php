<?php

namespace Controller\User;

use Model\User;
use Model\Session;
require_once ('app/partials/classes/model/User.php');
require_once ('app/partials/classes/model/Session.php');
use Entity\UserEntity;
require_once('app/partials/classes/entities/UserEntity.php');

class UserController
{
    private $model;
    private $entity;

    function __construct($data = null)
    {   
        $this->model = new User($data['username'] ?? null, $data['pwd'] ?? null);
        $this->entity = new UserEntity($this->model);
    }

    function getName()
    {
        return $this->model->getName();
    }

    function setToken($utok)
    {
        $this->model->setToken($utok);
    }

    function makeLogin()
    {
        $this->model = $this->entity->trust();

        if($this->model == false) return false;

        __REGISTER_TOKENS__ 
        ? $this->model = $this->entity->registerToken()
        : null;

        if($this->model == false) return false;
        if(!is_object($this->model) && $this->model == 2) return 2;

        Session::set('logged_in', true);
        Session::set('user_name', $this->model->getName());
        Session::set('user_login', $this->model->getUName());
        Session::set('user_email', $this->model->getEmail());
        Session::set('_tok', __INTERNAL_TOKEN_HASH__);
        Session::set('_user', $this->model);

        __LOGIN_LOGGER__
        ? $this->entity->loginLogger()
        : null;

        return true;
    }

    function makeLogout()
    {
        Session::set('logged_in', false);
        Session::abort();
        Session::start();
        return true;
    }

    function tokenVerification($token)
    {
        $this->model->setToken($token);

        if($this->model->tokenVerification(Session::get('_user'))){
            $this->model = Session::get('_user');
            Session::set('logged_in', true);
            Session::set('user_name', $this->model->getName());
            Session::set('user_login', $this->model->getUName());
            Session::set('user_email', $this->model->getEmail());
            

            return true;
        }

        return false;
    }

    function getSessionToken()
    {
        return Session::get('_user')->getToken();
    }


}
