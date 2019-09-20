<?php
/**
 * This document is used to put the global functions
 */


$_loginEnabled = true;
$_loginSection = 'app/partials/pieces/login-section.php';

function getRootUri()
{
    return getenv('HTTP_HOST');
}

function is_home()
{
    return substr($_SERVER['REQUEST_URI'],1) == "" || substr($_SERVER['REQUEST_URI'],1) == 'home';
}

function makeAlert($message, $ttl=100)
{
    return print_r('<script>setTimeout(function(){simpleAlert.show({message:"'.$message.'", type:"danger"})},'.$ttl.')</script>');
}

function sendJsonResponse($message){
    header('Content-Type: application/json');
    print_r(json_encode($message));
}


function setLoginSection($file)
{
    $_loginSection = 'app/partials/pieces/'.$file.'.php';
    return $this;
}

function getLoginSection()
{
    global $_loginSection;
    return require_once($_loginSection);
}

function enableLogin($bool)
{
    $_loginEnabled = $bool;
    return $this;
}

function isLoginEnabled()
{
    global $_loginEnabled;
    return $_loginEnabled;
}

function swapChars($string)
{
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}	
