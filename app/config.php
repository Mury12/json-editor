<?php
use Model\Router;
use Model\Connection;
use Model\Session;

require_once 'functions.php';
require_once 'app/partials/classes/model/Session.php';
require_once 'app/partials/classes/model/Router.php';

ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));

define('__INTERNAL_TOKEN__', hash('whirlpool', '_SEKURIT_UNICK_PWD_'));

define('_USER_ADMIN_NAME_', 'admin');
define('_USER_ADMIN_PSWD_', 'admin');

$r = new Router();
$routes = require_once('routes.php');

$r->new_route($routes);

$_s = new Session();
$_s->initSession();

$layout  = $r->getPage();
