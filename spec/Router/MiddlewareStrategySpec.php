<?php

namespace spec\Refinery29\Piston\Router;

use League\Container\ContainerInterface;
use League\Pipeline\Pipeline;
use League\Route\Route;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Request;
use Refinery29\Piston\RequestFactory;
use Refinery29\Piston\Response;
use Refinery29\Piston\Router\MiddlewareStrategy;
use Refinery29\Piston\Router\RouteGroup;
use Refinery29\Piston\Stubs\FooController;

class MiddlewareStrategySpec extends ObjectBehavior
{
    public function let(ContainerInterface $container)
    {
        $container->get('Request')->willReturn(RequestFactory::createFromUri('/alias'));
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

        $this->setResponse($response)
            ->setRequest($request);

        $this->dispatch(
            [$foo, 'test'], [], $route)->shouldHaveType(Response::class);
    }

    public function it_handles_group_middleware(RouteGroup $group, Route $route, FooController $foo, Request $request, Response $response)
    {
        $route->getParentGroup()->willReturn($group);
        $group->buildPipeline()->willReturn(new Pipeline());

        $group->buildPipeline()->shouldBeCalled();

        $this->setResponse($response)
            ->setRequest($request);

        $this->getResponse()->shouldReturn($response);

        $this->dispatch(
            [$foo, 'test'], [], $route);
    }
}
