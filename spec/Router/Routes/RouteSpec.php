<?php namespace spec\Refinery29\Piston\Router\Routes;

use League\Pipeline\StageInterface;
use League\Pipeline\Pipeline;
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
        $this->addPreHook($operation);
        $this->getPreHooks()->shouldHaveType(Pipeline::class);
    }

    public function it_can_add_post_hooks(StageInterface $operation)
    {
        $this->addPostHook($operation);
        $this->getPostHooks()->shouldHaveType(Pipeline::class);
    }
}
