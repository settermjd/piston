<?php
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/15/15
 * Time: 3:02 PM
 */
use League\Container\Container;
use Refinery29\Piston\Hooks\QueryString\ValidatePaginationHook;
use Symfony\Component\HttpFoundation\Request;

require(__DIR__ . "/vendor/autoload.php");


$app = new \Refinery29\Piston\Piston(new Container(), __DIR__);

$route = new \Refinery29\Piston\Routes\Route('GET', '/', function ($req, $resp) {
    echo "<pre>" . print_r("YOLO", true) . "</pre>";
    exit;
});

$request = Request::create('/?pagination=123&something=somethingelse');
$app->setRequest($request);

$app->addRoute($route);

$app->launch();

