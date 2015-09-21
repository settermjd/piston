<?php

namespace spec\Refinery29\Piston\Router;

use Kayladnls\Seesaw\Route;
use Kayladnls\Seesaw\RouteCollection;
use League\Container\ContainerInterface;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Router\PistonStrategy;
use Refinery29\Piston\Router\Routes\RouteGroup;
use Refinery29\Piston\Stubs\FooController;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class PistonStrategySpec extends ObjectBehavior
{
    public function let(RouteCollection $collection, ContainerInterface $container)
    {
        $container->get('Request')->willReturn(Request::create('/alias'));
        $container->get('Response')->willReturn(new Response(SymfonyResponse::create()));
        $container->get('Refinery29\Piston\Stubs\FooController')->willReturn(new FooController());
        $container->get('app')->willReturn(new Piston());
        $container->get('FooController')->willReturn(new FooController());

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
        $this->shouldHaveType(PistonStrategy::class);
    }

    public function it_must_return_a_response()
    {
        $this->dispatch(
           ['FooController', 'fooAction'], [])->shouldHaveType(Response::class);
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
        $controller_response->shouldHaveType(Response::class);
    }

    public function it_can_dispatch_controller()
    {
        $controller_response = $this->dispatch(['Refinery29\Piston\Stubs\FooController', 'fooAction']);
        $controller_response->shouldHaveType(Response::class);
    }
}
