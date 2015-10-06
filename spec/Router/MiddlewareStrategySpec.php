<?php

namespace spec\Refinery29\Piston\Router;

use League\Container\ContainerInterface;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Piston;
use Refinery29\Piston\PistonException;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;
use Refinery29\Piston\Router\MiddlewareStrategy;
use Refinery29\Piston\Router\RouteGroup;
use Refinery29\Piston\Stubs\FooController;

class MiddlewareStrategySpec extends ObjectBehavior
{
    public function let(ContainerInterface $container)
    {
        $container->get('Request')->willReturn(Request::createFromUri('/alias'));
        $container->get('Response')->willReturn(new Response());
        $container->get('Refinery29\Piston\Stubs\FooController')->willReturn(new FooController());


        $this->beConstructedWith($container);
//        $route = Route::get('alias', 'yolo');
//        $route2 = Route::get('/one/two/three', 'FooControlle::fooAction');
//        $group = new RouteGroup('/prefix', function($router){
//
//        });
//        $group->addRoute($route);
//        $group->addRoute($route2);
//        $collection->addGroup($group);
//
//        $container->get('PistonRouter')->willReturn($collection);
//
//        $this->setContainer($container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MiddlewareStrategy::class);
    }

    public function it_must_return_a_response()
    {
        $this->dispatch(
           ['FooController', 'fooAction'], [])->shouldHaveType(s::class);
    }

    public function it_throws_exceptions_on_invalid_response()
    {
        $this->shouldThrow(PistonException::class)->duringValidateResponse('YOLO');
    }

    public function it_can_dispatch_controller()
    {
        $controller_response = $this->dispatch([new FooController(), 'fooAction']);
        $controller_response->shouldHaveType(Response::class);
    }
}
