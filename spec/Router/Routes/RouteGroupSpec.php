<?php

namespace spec\Refinery29\Piston\Router\Routes;

use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Router\Routes\RouteGroup;

class RouteGroupSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(RouteGroup::class);
    }

    public function it_can_add_pre_hooks(StageInterface $operation)
    {
        $this->addPre($operation);
        $this->getPrePipeline()->shouldHaveType(Pipeline::class);
    }

    public function it_can_add_post_hooks(StageInterface $operation)
    {
        $this->addPost($operation);
        $this->getPostPipeline()->shouldHaveType(Pipeline::class);
    }
}
