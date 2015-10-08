<?php

namespace spec\Refinery29\Piston\Router;

use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;
use League\Route\RouteCollection;
use League\Route\RouteGroup;
use PhpSpec\ObjectBehavior;

class RouteGroupSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(
            '/yolo',
            function ($router) {},
            new RouteCollection());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RouteGroup::class);
    }

    public function it_can_add_middleware(StageInterface $operation)
    {
        $this->addMiddleware($operation);
        $this->buildPipeline()->shouldHaveType(Pipeline::class);
    }
}
