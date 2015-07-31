<?php namespace spec\Refinery29\Piston\Hooks\Pagination;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;

class OffsetLimitPaginationSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Hooks\Pagination\OffsetLimitPagination');
    }

    public function it_will_not_allow_pagination_on_non_get_requests()
    {
        $request = Request::create('123/yolo?limit=20&offset=40', 'PUT');

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$request]);
    }

    public function it_returns_a_request()
    {
        $request = Request::create('123/yolo?limit=20&offset=40', 'GET');

        $this->process($request)->shouldReturn($request);
    }

    public function it_does_not_allow_usage_with_multiple_pagination_strategies()
    {
        $request = Request::create('123/yolo?limit=20&offset=40&before=abc', 'GET');
        $request->setBeforeCursor('abc');

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$request]);
    }

    public function it_assigns_limit_to_request_as_integer()
    {
        $request = $this->process(Request::create('123/yolo?limit=20&offset=40', 'GET'));

        $request->limit->shouldBe(20);
    }

    public function it_assigns_offset_to_request_as_integer()
    {
        $request = $this->process(Request::create('123/yolo?limit=20&offset=40', 'GET'));

        $request->offset->shouldBe(40);
    }

    public function it_assigns_default_limit_of_ten_when_none_given()
    {
        $request = $this->process(Request::create('123/yolo?offset=20', 'GET'));

        $request->limit->shouldBe(10);
    }

    public function it_assigns_default_offset_of_zero_when_none_given()
    {
        $request = $this->process(Request::create('123/yolo?limit=20', 'GET'));

        $request->offset->shouldBe(0);
    }

    public function it_throws_if_offset_is_not_numeric()
    {
        $request = Request::create('123/yolo?limit=20&offset=nope', 'GET');

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$request]);
    }

    public function it_throws_if_limit_is_not_numeric()
    {
        $request = Request::create('123/yolo?limit=nope&offset=40', 'GET');

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$request]);
    }

    public function it_throws_if_offset_is_not_an_integer()
    {
        $request = Request::create('123/yolo?limit=20&offset=10.34', 'GET');

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$request]);
    }

    public function it_throws_if_limit_is_not_an_integer()
    {
        $request = Request::create('123/yolo?limit=20.15&offset=10', 'GET');

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$request]);
    }
}
