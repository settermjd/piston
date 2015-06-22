<?php namespace spec\Refinery29\Piston\Router\Routes;

use League\Pipeline\OperationInterface;
use League\Pipeline\Pipeline;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RouteSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedThrough('get', ['alias', 'something']);
    }

    public function it_can_create_a_get_route()
    {
        $this->beConstructedThrough('get', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Router\Routes\Route');
        $this->getVerb()->shouldReturn('GET');
    }

    public function it_can_create_a_post_route()
    {
        $this->beConstructedThrough('post', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Router\Routes\Route');
        $this->getVerb()->shouldReturn('POST');
    }

    public function it_can_create_a_put_route()
    {
        $this->beConstructedThrough('put', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Router\Routes\Route');
        $this->getVerb()->shouldReturn('PUT');
    }

    public function it_can_create_a_delete_route()
    {
        $this->beConstructedThrough('delete', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Router\Routes\Route');
        $this->getVerb()->shouldReturn('DELETE');
    }

    public function it_can_get_Alias()
    {
        $this->beConstructedThrough('get', ['alias', 'something']);

        $this->getAlias()->shouldReturn('alias');
    }

    public function it_can_get_action()
    {
        $this->beConstructedThrough('get', ['alias', 'action']);

        $this->getAction()->shouldReturn('action');
    }

    public function it_cannot_use_invalid_verbs()
    {
        $this->shouldThrow('\Exception')->during('__construct', ['YOLO', 'something', 'something']);
    }

    public function it_can_add_pre_hooks(OperationInterface $operation)
    {
        $this->addPreHook($operation);
        $this->getPreHooks()->shouldHaveType(Pipeline::class);
    }

    public function it_can_add_post_hooks(OperationInterface $operation)
    {
        $this->addPostHook($operation);
        $this->getPostHooks()->shouldHaveType(Pipeline::class);
    }

    public function it_can_be_paginated()
    {
        $this->beConstructedThrough('get', ['alias', 'something', true]);

        $this->isPaginated()->shouldReturn(true);
    }
}
