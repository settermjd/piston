<?php

namespace spec\Refinery29\Piston;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Hooks\HookQueue;
use Refinery29\Piston\Router\Routes\Route;

class ApplicationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Application');
    }

    function it_should_create_container_if_none_is_injected()
    {
        $this->getContainer()->shouldHaveType('League\Container\Container');
    }

    function it_cannot_set_environ_config_to_nonexistant_directory()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('setEnvConfig', ['not a folder']);
    }

    function it_can_add_a_route(Route $route)
    {
        $route->beADoubleOf('Refinery29\Piston\Router\Routes\Route');

        $this->addRoute($route);
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

        $pre_hooks->shouldHaveType('Refinery29\Piston\Hooks\HookQueue');

        $pre_hooks->getNext()->shouldReturn($closure);

    }
    function it_can_add_post_hooks()
    {
        $closure = function($request, $response){
            return $response;
        };

        $this->addPostHook($closure);

        $pre_hooks = $this->getPostHooks();

        $pre_hooks->shouldHaveType('Refinery29\Piston\Hooks\HookQueue');

        $pre_hooks->getNext()->shouldReturn($closure);
    }

    function it_can_get_pre_hooks()
    {
        $this->getPreHooks()->shouldHaveType('Refinery29\Piston\Hooks\HookQueue');
    }

    function it_can_get_post_hooks()
    {
        $this->getPostHooks()->shouldHaveType('Refinery29\Piston\Hooks\HookQueue');
    }
}
