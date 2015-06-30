<?php namespace spec\Refinery29\Piston\Hooks;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\Request;

class PaginationSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Hooks\Pagination');
    }

    public function it_will_not_allow_pagination_on_non_get_requests()
    {
        $request = Request::create('123/yolo?before=123&after=456', "PUT");

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$request]);
    }

    public function it_will_allow_pagination_on_get_requests()
    {
        $request = Request::create('123/yolo?before=123&after=456', "GET");
        $this->process($request);
    }
}
