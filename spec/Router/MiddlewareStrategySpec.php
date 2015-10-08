<?php

namespace spec\Refinery29\Piston\Router;

use League\Container\ContainerInterface;
use League\Route\Route;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;
use Refinery29\Piston\Router\MiddlewareStrategy;
use Refinery29\Piston\Stubs\FooController;

class MiddlewareStrategySpec extends ObjectBehavior
{
    public function let(ContainerInterface $container)
    {
        $container->get('Request')->willReturn(Request::createFromUri('/alias'));
        $container->get('Response')->willReturn(new Response());
        $container->get('Refinery29\Piston\Stubs\FooController')->willReturn(new FooController());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MiddlewareStrategy::class);
    }

    public function it_can_dispatch_controller(Route $route, FooController $foo, Request $request, Response $response)
    {
        $route->getParentGroup()->willReturn(false);
        $foo->test($request, $response, [])->willReturn($response);

        $this->setResponse($response);
        $this->setRequest($request);

        $this->dispatch(
           [$foo, 'test'], [], $route)->shouldHaveType(Response::class);
    }
}
