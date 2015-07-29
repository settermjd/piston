<?php

namespace spec\Refinery29\Piston\Router;

use League\Container\Container;
use League\Container\ContainerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\Response;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Http\Request;
use Kayladnls\Seesaw\RouteCollection;
use Refinery29\Piston\Router\Routes\Route;
use Refinery29\Piston\Router\Routes\RouteGroup;
use Refinery29\Piston\Stubs\FooController;

class PistonStrategySpec extends ObjectBehavior
{
    public function let(RouteCollection $collection, ContainerInterface $container)
    {
        $container->get('PistonRequest')->willReturn(Request::create('/alias'));
        $container->get('Symfony\Component\HttpFoundation\Request')->willReturn(Request::create('/alias'));
        $container->get('Symfony\Component\HttpFoundation\Response')->willReturn(Response::create());
        $container->get('Refinery29\Piston\Stubs\FooController')->willReturn(new FooController());
        $container->get('app')->willReturn(new Piston());

        $collection->beConstructedWith([$container->getWrappedObject()]);
        $route = Route::get('alias', 'yolo');
        $route2 = Route::get('/one/two/three', 'FooControlle::fooAction');
        $group = new RouteGroup();
        $group->addRoute($route);
        $group->addRoute($route2);
        $collection->addGroup($group);

        $container->get('PistonRouter')->willReturn($collection);

        $this->setContainer($container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Router\PistonStrategy');
    }

    public function it_must_return_a_response()
    {
        $this->dispatch(
            function ($req, $resp) {
                return $resp;
            }, [])->shouldHaveType('Symfony\Component\HttpFoundation\Response');

        $this->dispatch(
            function ($req, $resp) {
                $resp->setContent('YOLO');
                return $resp;
            }, [])->getContent()->shouldReturn('YOLO');
    }

    public function it_throws_exceptions_on_invalid_response()
    {
        $this->shouldThrow('\Exception')->duringValidateResponse('YOLO');
    }

    public function it_can_resolve_injected_controller()
    {
        $controller = new FooController();
        $this->resolveController([$controller, 'fooAction'])->shouldReturn([$controller, 'fooAction']);
    }

    public function it_can_resolve_string_controller()
    {
        $controller = $this->resolveController(['Refinery29\Piston\Stubs\FooController', 'fooAction'])[0];
        $controller->shouldHaveType('Refinery29\Piston\Stubs\FooController');
    }

    public function it_can_resolve_controller(Request $request, Response $response)
    {
        $controller_response = $this->invokeAction(['Refinery29\Piston\Stubs\FooController', 'fooAction'], [$request, $response]);
        $controller_response->shouldHaveType('Symfony\Component\HttpFoundation\Response');
    }

    public function it_can_dispatch_controller()
    {
        $controller_response = $this->dispatch(['Refinery29\Piston\Stubs\FooController', 'fooAction']);
        $controller_response->shouldHaveType('Symfony\Component\HttpFoundation\Response');
    }
}
