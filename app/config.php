<?php
use Model\Session;
use Model\Router;
use Model\Connection;
require_once 'app/partials/classes/model/Session.php';
require_once 'functions.php';
require_once 'app/partials/classes/model/Router.php';

$_s = new Session();

// ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));

define('__INTERNAL_TOKEN__', hash('whirlpool', '_SEKURIT_UNICK_PWD_'));

define('_USER_ADMIN_NAME_', 'admin');
define('_USER_ADMIN_PSWD_', 'admin');

$r = new Router();
$routes = require_once('routes.php');

$r->new_route($routes);


$layout  = $r->getPage();
