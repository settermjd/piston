<?php

namespace spec\Refinery29\Piston\Router;

use League\Pipeline\StageInterface;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Middleware\ExceptionalPipeline;
use Refinery29\Piston\Router\Route;

class RouteSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Route::class);
    }

    public function it_can_add_middleware(StageInterface $operation)
    {
        $this->addMiddleware($operation);
        $this->getPipeline()->shouldHaveType(ExceptionalPipeline::class);
    }
}
