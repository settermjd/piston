<?php

namespace spec\Refinery29\Piston\Router\Routes;

use League\Pipeline\StageInterface;
use League\Pipeline\Pipeline;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Router\Routes\Route;

class RouteGroupSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Router\Routes\RouteGroup');
    }

    public function it_can_add_a_route(Route $route)
    {
        $route->beADoubleOf('Refinery29\Piston\Router\Routes\Route');
        $this->addRoute($route);

        $this->getRoutes()->shouldContain($route);
    }

    public function it_can_add_pre_hooks(StageInterface $operation)
    {
        $this->addPreHook($operation);
        $this->getPreHooks()->shouldHaveType(Pipeline::class);
    }

    public function it_can_add_post_hooks(StageInterface $operation)
    {
        $this->addPostHook($operation);
        $this->getPostHooks()->shouldHaveType(Pipeline::class);
    }
}
