<?php

// INCLUDED ONLY FOR REFERENCE/EXAMPLE WILL BE REMOVED PRIOR TO MERGE!!!!!

use League\Container\Container;
use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\Response;
use Refinery29\Piston\Stubs\FooController;

require "vendor/autoload.php";


class MiddlewareTwo implements \League\Pipeline\StageInterface
{
    public function process($payload)
    {
        /** @var Response $response */
        $response = $payload->getResponse();

        $response->setErrors(ResourceFactory::errorCollection([ResourceFactory::error('something', 'blach')]));
    }
}

class Middleware implements \League\Pipeline\StageInterface
{
    public function process($payload)
    {
        $payload->getSubject()->group('/prefix', function ($router) {

            $router->get('/something', FooController::class . "::test")->setName('something'); // also still have convenience http methods (get, post, put etc
        })
        ->addMiddleWare(new \MiddlewareTwo);
    }
}


$container = new Container();
$container->add(FooController::class, new FooController());

$app = new \Refinery29\Piston\Piston($container);


$app->addMiddleware(new Middleware());
$app->launch();
