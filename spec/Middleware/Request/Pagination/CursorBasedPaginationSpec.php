<?php

namespace spec\Refinery29\Piston\Middleware\Request\Pagination;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Middleware\Request\Pagination\CursorBasedPagination;
use Refinery29\Piston\RequestFactory;
use Refinery29\Piston\Response;

class CursorBasedPaginationSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CursorBasedPagination::class);
    }

    public function it_will_not_allow_pagination_on_non_get_requests()
    {
        $request = RequestFactory::fromGlobals()->withMethod('PUT')->withQueryParams(['before' => 123]);

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$this->getPayload($request)]);
    }

    public function it_will_not_allow_before_an_after()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['before' => 123, 'after' => 456]);

        $this->shouldThrow('League\Route\Http\Exception\BadRequestException')->during('process', [$this->getPayload($request)]);
    }

    public function it_will_allow_before_cursor_on_get_requests()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['before' => 123]);
        $this->process($this->getPayload($request))
            ->getRequest()
            ->getPaginationCursor()->shouldReturn(['before' => 123]);
    }

    public function it_will_allow_after_cursor_on_get_requests()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['after' => 123]);
        $this->process($this->getPayload($request))
            ->getRequest()
            ->getPaginationCursor()->shouldReturn(['after' => 123]);
    }

    public function it_returns_a_payload_with_request()
    {
        $request = RequestFactory::fromGlobals()->withQueryParams(['before' => 123]);

        $response = $this->process($this->getPayload($request));
        $response->shouldHaveType(Payload::class);
        $response->getRequest()->shouldReturn($request);
    }

    private function getPayload($request)
    {
        return new Payload($request, $request, new Response());
    }
}
