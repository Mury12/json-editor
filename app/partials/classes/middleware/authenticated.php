<?php
/**
 * Esta aplicação controla a autenticação do usuário. Ela servirá para limitar o acesso de páginas 
 * tanto a usuários não autenticados quanto ao contrário, isto é, se no momento da definição de 
 * uma rota, for definido Layout::permission('not'), o usuário autenticado não terá acesso à página
 * (como uma página de cadastro ou login, por exemplo) e, caso seja como Layout::permission('auth'),
 * o usuário não autenticado não poderá acessar a página (como um painel de usuário).
 */

use Controller\User\UserController;
require_once('app/partials/classes/controller/UserController.php');
$access = $layout->getAccessLevel();
$ue = new UserController();

if($access === 'not'){
    if($ue->isLoggedIn()){
        header('HTTP/1.0 401 Unauthorized.');
        header('Location: /adm-golden/robos');
        return false;
    }
    return true;
}else

if($access === 'auth'){
    if(!$ue->isLoggedIn()){
        header('HTTP/1.0 401 Unauthorized.');
        header('Location: /adm-golden');
        return false;
    }
    return true;
}else

return true;
