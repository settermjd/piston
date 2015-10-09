<?php

namespace spec\Refinery29\Piston;

use League\Container\Container;
use League\Container\ServiceProvider;
use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Router\RouteGroup;

class PistonSpec extends ObjectBehavior
{
    public function let(Container $container)
    {
        $container->beADoubleOf('League\Container\Container');
        $this->beConstructedWith($container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Piston::class);
    }

    public function it_can_add_a_route_group()
    {
        $this->shouldHaveType(Piston::class);
        $this->group('prefix', function () {})->shouldHaveType(RouteGroup::class);
    }

    public function it_can_add_middleware(StageInterface $operation)
    {
        $this->addMiddleware($operation);
        $this->buildPipeline()->shouldHaveType(Pipeline::class);
    }

    public function it_can_add_service_providers(ServiceProvider\AbstractServiceProvider $provider)
    {
        $provider->beADoubleOf('League\Container\ServiceProvider\AbstractServiceProvider');

        $this->register($provider);
    }
}
