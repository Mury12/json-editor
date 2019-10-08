<?php
/**
 * Esta aplicação controla a autenticação do usuário. Ela servirá para limitar o acesso de páginas 
 * tanto a usuários não autenticados quanto ao contrário, isto é, se no momento da definição de 
 * uma rota, for definido Layout::permission('not'), o usuário autenticado não terá acesso à página
 * (como uma página de cadastro ou login, por exemplo) e, caso seja como Layout::permission('auth'),
 * o usuário não autenticado não poderá acessar a página (como um painel de usuário).
 */
use Model\Session;
require_once 'app/partials/classes/model/Session.php';

$access = $layout->getAccessLevel();

if($access === 'not'){
    if(Session::get('logged_in')){

        header('HTTP/1.0 401 Unauthorized.');
        header('Location: /adm-golden/robos');
        return false;
    }
    return true;
}else

if($access === 'auth'){
    if(!Session::get('logged_in')){
        header('HTTP/1.0 401 Unauthorized.');
        header('Location: /adm-golden');
        return false;
    }
    return true;
}else

return true;
