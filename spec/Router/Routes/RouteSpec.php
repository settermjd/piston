<?php

namespace spec\Refinery29\Piston\Router\Routes;

use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RouteSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedThrough('get', ['alias', 'something']);
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
