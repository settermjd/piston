<?php

ini_set('display_errors', '1');

require(__DIR__.'/vendor/autoload.php');

use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Router\Routes\Route;

$app = new \Refinery29\Piston\Piston();


$request = Request::create('/?limit=20&offset=40&before=abc', 'GET');
$request->headers->set('accept', 'application/json');
$app->setRequest($request);

$app->addRoute(Route::get('/', function ($req, $resp) {

return $resp;
}));

echo $app->launch();
