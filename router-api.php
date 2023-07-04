<?php
require_once 'libs/Router.php';
require_once 'ApiControllers/api_travel_controller.php';
require_once 'ApiControllers/api_user_controller.php';
require_once 'ApiControllers/api_truck_load_controller.php';

$router = new Router();

$router->addRoute('travel', 'GET', 'api_travel_controller', 'getAll');
$router->addRoute('travel/:ID', 'GET', 'api_travel_controller', 'getOne');
$router->addRoute('travel/:ID', 'DELETE', 'api_travel_controller', 'delete');
$router->addRoute('travel', 'POST', 'api_travel_controller','add');
$router->addRoute('travel/:ID', 'PUT', 'api_travel_controller','update');

$router->addRoute('truck_load', 'GET', 'api_truck_load_controller', 'getAll');
$router->addRoute('truck_load/:ID', 'GET', 'api_truck_load_controller', 'getOne');
$router->addRoute('truck_load/:ID', 'DELETE', 'api_truck_load_controller', 'delete');
$router->addRoute('truck_load', 'POST', 'api_truck_load_controller','add');
$router->addRoute('truck_load/:ID', 'PUT', 'api_truck_load_controller','update');

$router->addRoute('user', 'GET', 'user_controller','gettoken');




$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);