<?php namespace spec\Refinery29\Piston\Routes;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RouteSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('get', ['alias', 'something']);
    }

    function it_can_create_a_get_route()
    {
        $this->beConstructedThrough('get', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Routes\Route');
        $this->getVerb()->shouldReturn('GET');
    }

    function it_can_create_a_post_route()
    {
        $this->beConstructedThrough('post', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Routes\Route');
        $this->getVerb()->shouldReturn('POST');
    }

    function it_can_create_a_put_route()
    {
        $this->beConstructedThrough('put', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Routes\Route');
        $this->getVerb()->shouldReturn('PUT');
    }

    function it_can_create_a_delete_route()
    {
        $this->beConstructedThrough('delete', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Routes\Route');
        $this->getVerb()->shouldReturn('DELETE');
    }

    function it_can_get_Alias()
    {
        $this->beConstructedThrough('get', ['alias', 'something']);

        $this->getAlias()->shouldReturn('alias');
    }

    function it_can_get_action()
    {
        $this->beConstructedThrough('get', ['alias', 'action']);

        $this->getAction()->shouldReturn('action');
    }

    function it_cannot_use_invalid_verbs()
    {
        $this->shouldThrow('\Exception')->during('__construct', ['YOLO', 'something', 'something']);
    }

    function it_cannot_add_invalid_pre_hook()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('addPreHook', [new \stdClass()]);
    }

    function it_cannot_add_invalid_post_hook()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('addPostHook', [new \stdClass()]);
    }

    function it_can_add_pre_hooks()
    {
        $closure = function($request, $response){
            return $response;
        };

        $this->addPreHook($closure);

        $pre_hooks = $this->getPreHooks();

        $pre_hooks->shouldHaveType('Refinery29\Piston\Hooks\Queue');

        $pre_hooks->getNext()->shouldReturn($closure);

    }
    function it_can_add_post_hooks()
    {
        $closure = function($request, $response){
            return $response;
        };

        $this->addPostHook($closure);

        $pre_hooks = $this->getPostHooks();

        $pre_hooks->shouldHaveType('Refinery29\Piston\Hooks\Queue');

        $pre_hooks->getNext()->shouldReturn($closure);
    }

    function it_can_get_pre_hooks()
    {
        $this->getPreHooks()->shouldHaveType('Refinery29\Piston\Hooks\Queue');
    }

    function it_can_get_post_hooks()
    {
        $this->getPostHooks()->shouldHaveType('Refinery29\Piston\Hooks\Queue');
    }
}
