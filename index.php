<?php
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/4/15
 * Time: 4:44 PM
 */

use Refinery29\Piston\Router\Routes\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require(__DIR__."/vendor/autoload.php");


$app = new \Refinery29\Piston\Application();

$route = Route::get('/', function(Request $req, Response $resp){
    $resp->setContent("Hello World");
    return $resp;
});

$app->addRoute($route);

$app->launch();

