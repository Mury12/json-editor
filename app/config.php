<?php
use Model\Session;
use Model\Router;
use Model\Connection;
require_once 'app/partials/classes/model/Session.php';
require_once 'functions.php';
require_once 'app/partials/classes/model/Router.php';
require_once 'app/partials/classes/model/Connection.php';

Session::start();

$_ith = $_SERVER['DOCUMENT_ROOT'];
$_ith.= '\\_sec@_';
$_ith.= $_SERVER['REMOTE_ADDR'];

$ith = 'tok_h';
$ith.= hash('sha256', $_ith);

setcookie('_itok', $ith);

// ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));


define('_USER_ADMIN_NAME_', 'admin');
define('_USER_ADMIN_PSWD_', 'admin');

// Encryption
define('__PW_ENCRYPTION__', true);
define('__OPENSSL_ENCRYPTION__', true);
define('__OPENSSL_ALGORITHM__', 'AES-256');
// Loggers
define('__LOGIN_LOGGER__', false);
define('__ROBOT_AUTH_LOGGER__', false);
// Tokens
define('__SEND_TOKENS__', false);
define('__INTERNAL_TOKEN_HASH__', $ith);
define('__REGISTER_TOKENS__', false);

// DB
if( file_exists ('local-db.php')){
    define('DB_HOST', '');
    define('DB_NAME', '');
    define('DB_USER', '');
    define('DB_PASS', '');
}else{
    require_once ('local-db.php');
}

$c_db = new Connection(DB_HOST, DB_NAME, DB_USER, DB_PASS);

try{
    $conn = $c_db->connectMysql();
}catch(PDOException $e){
    makeAlert($e->getMessage());
    $conn = null;
}

// Routes
define('__WS_ROUTE_PREFIX__', 'ws/v2/');
define('__ROOT_ROUTE_PREFIX__', 'adm-golden/');

$r = new Router();
$routes = require_once('routes.php');
$api_routes = require_once('api-routes.php');

$routes = array_merge($api_routes, $routes);

$r->new_route($routes);

$layout  = $r->getPage();
