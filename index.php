<?php

// INCLUDED ONLY FOR REFERENCE/EXAMPLE WILL BE REMOVED PRIOR TO MERGE!!!!!

use League\Container\Container;
use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\Response;
use Refinery29\Piston\Stubs\FooController;

require 'vendor/autoload.php';

class MiddlewareTwo implements \League\Pipeline\StageInterface
{
    public function process($payload)
    {
        /** @var Response $response */
        $response = $payload->getResponse();

//        $response->setErrors(ResourceFactory::errorCollection([ResourceFactory::error('something', 'blach')]));
        return $payload;
    }
}

class Middleware implements \League\Pipeline\StageInterface
{
    public function process($payload)
    {
        $payload->getSubject()->group('/prefix', function (\Refinery29\Piston\Router\RouteGroup $router) {

            $router->get('/something', FooController::class . '::test')->setName('something'); // also still have convenience http methods (get, post, put etc
        })
        ->addMiddleWare(new \MiddlewareTwo());

        $payload->getSubject()->get('/somethingelse', FooController::class . '::test');
    }
}

$container = new Container();
$container->add(FooController::class, new FooController());

$request = \Refinery29\Piston\RequestFactory::fromGlobals()->withUri(new \Zend\Diactoros\Uri('/somethingelse?fields=yolo,yoko,ono'));

$app = new \Refinery29\Piston\Piston($container, $request);

$app->addMiddleware(new Middleware());
$app->launch();
