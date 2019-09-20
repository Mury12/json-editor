<?php
use Controller\User\UserController;
require_once('app/partials/classes/controller/UserController.php');

$u = new UserController($_POST);
if(filter_input(INPUT_POST, 'execution') == 'login_execute'){
    $u->login();
}
if(filter_input(INPUT_POST, 'execution') == 'is_logged_in'){
    sendJsonResponse(['res'=>$u->isLoggedIn()]);
}
if(filter_input(INPUT_POST, 'execution') == 'logout_execute'){
    $u->logOut();
}
