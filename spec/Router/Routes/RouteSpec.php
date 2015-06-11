<?php namespace spec\Refinery29\Piston\Router\Routes;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RouteSpec extends ObjectBehavior
{
    function it_can_create_a_get_route()
    {
        $this->beConstructedThrough('get', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Router\Routes\Route');
        $this->getVerb()->shouldReturn('GET');
    }

    function it_can_create_a_post_route()
    {
        $this->beConstructedThrough('post', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Router\Routes\Route');
        $this->getVerb()->shouldReturn('POST');
    }

    function it_can_create_a_put_route()
    {
        $this->beConstructedThrough('put', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Router\Routes\Route');
        $this->getVerb()->shouldReturn('PUT');
    }

    function it_can_create_a_delete_route()
    {
        $this->beConstructedThrough('delete', ['something', 'something']);
        $this->shouldHaveType('Refinery29\Piston\Router\Routes\Route');
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

    function it_can_get_permissions()
    {
        $this->beConstructedThrough('get', ['alias', 'something', 'ADMIN']);

        $this->getPermission()->shouldReturn('ADMIN');
    }

    function it_can_set_permission()
    {
        $this->beConstructedThrough('get', ['alias', 'something']);
        $this->setPermission('POODLE');
        $this->getPermission()->shouldReturn('POODLE');
    }

    function it_cannot_change_permission_once_set_via_constructor()
    {
        $this->beConstructedThrough('get', ['alias', 'something', 'ADMIN']);

        $this->shouldThrow('\Exception')->during('setPermission', ['PUBLIC']);
    }

    function it_cannot_change_permission_once_set_via_setter()
    {
        $this->beConstructedThrough('get', ['alias', 'something']);

        $this->setPermission('ADMIN');

        $this->shouldThrow('\Exception')->during('setPermission', ['PUBLIC']);
    }
}
