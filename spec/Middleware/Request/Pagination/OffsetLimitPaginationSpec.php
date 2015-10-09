<?php

namespace spec\Refinery29\Piston\Middleware\Request\Pagination;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Middleware\Request\Pagination\OffsetLimitPagination;
use Refinery29\Piston\RequestFactory;
use Refinery29\Piston\Response;

class OffsetLimitPaginationSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(OffsetLimitPagination::class);
    }

    public function it_will_not_allow_pagination_on_non_get_requests()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['limit' => 20, 'offset' => 40])->withMethod('PUT');

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$this->getPayload($request)]);
    }

    public function it_returns_a_payload_with_request()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['limit' => 20, 'offset' => 40]);

        $response = $this->process($this->getPayload($request));
        $response->shouldHaveType(Payload::class);
        $response->getRequest()->shouldReturn($request);
    }

    public function it_does_not_allow_usage_with_multiple_pagination_strategies()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['limit' => 20, 'offset' => 40]);
        $request->setBeforeCursor('abc');

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$this->getPayload($request)]);
    }

    public function it_assigns_limit_to_request_as_integer()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['limit' => '20', 'offset' => '40']);
        $request = $this->process($this->getPayload($request));

        $request->getRequest()->getOffsetLimit()->shouldBe(['offset' => 40, 'limit' => 20]);
    }

    public function it_assigns_offset_to_request_as_integer()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['limit' => '20', 'offset' => '40']);
        $request = $this->process($this->getPayload($request));

        $request->getRequest()->getOffsetLimit()->shouldBe(['offset' => 40, 'limit' => 20]);
    }

    public function it_assigns_default_limit_of_ten_when_none_given()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['offset' => '20']);
        $request = $this->process($this->getPayload($request));

        $request->getRequest()->getOffsetLimit()->shouldBe(['offset' => 20, 'limit' => 10]);
    }

    public function it_assigns_default_offset_of_zero_when_none_given()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['limit' => '20']);
        $request = $this->process($this->getPayload($request));

        $request->getRequest()->getOffsetLimit()->shouldBe(['offset' => 0, 'limit' => 20]);
    }

    public function it_throws_if_offset_is_not_numeric()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['offset' => '20', 'limit' => 'nope']);

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$this->getPayload($request)]);
    }

    public function it_throws_if_limit_is_not_numeric()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['limit' => '20', 'offset' => 'nope']);
        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$this->getPayload($request)]);
    }

    public function it_throws_if_offset_is_not_an_integer()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['limit' => '20', 'offset' => '10.34']);

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$this->getPayload($request)]);
    }

    public function it_throws_if_limit_is_not_an_integer()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['limit' => '10.35', 'offset' => '20']);

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$this->getPayload($request)]);
    }

    private function getPayload($request)
    {
        return new Payload($request, $request, new Response());
    }
}
