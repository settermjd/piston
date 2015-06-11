<?php

namespace spec\Refinery29\Piston;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
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
        $this->shouldThrow('\InvalidArgumentException')->during('setEnvConfig', ['yolo']);
    }

    function it_can_add_a_route(Route $route)
    {
        $route->beADoubleOf('Refinery29\Piston\Router\Routes\Route');

        $this->addRoute($route);
    }

    function it_can_set_default_permission()
    {
        $this->getDefaultPermission()->shouldReturn('PUBLIC');
        $this->setDefaultPermission('ADMIN');

        $this->getDefaultPermission()->shouldReturn('ADMIN');


    }

}
