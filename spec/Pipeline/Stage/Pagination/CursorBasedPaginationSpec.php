<?php

namespace spec\Refinery29\Piston\Pipeline\Stage\Pagination;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Pipeline\Stage\Pagination\CursorBasedPagination;

class CursorBasedPaginationSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CursorBasedPagination::class);
    }

    public function it_will_not_allow_pagination_on_non_get_requests()
    {
        $request = Request::create('123/yolo?before=123', 'PUT');

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$request]);
    }

    public function it_will_not_allow_before_an_after()
    {
        $request = Request::create('123/yolo?before=123&after=456', 'GET');

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$request]);
    }

    public function it_will_allow_before_cursor_on_get_requests()
    {
        $request = Request::create('123/yolo?before=123', 'GET');
        $this->process($request);
    }

    public function it_will_allow_after_cursor_on_get_requests()
    {
        $request = Request::create('123/yolo?after=123', 'GET');
        $this->process($request);
    }

    public function it_returns_a_request()
    {
        $request = Request::create('123/yolo?before=123', 'GET');
        $this->process($request)->shouldReturn($request);
    }
}
