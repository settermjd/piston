<?php

namespace spec\Refinery29\Piston\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\ResponseNegotiator;
use Refinery29\Piston\Stubs\FooBarResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseNegotiatorSpec extends ObjectBehavior
{
    public function let(Request $request)
    {
        $request->getAcceptableContentTypes()->willReturn(['application/foobar']);
        $this->beConstructedWith($request);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ResponseNegotiator::class);
    }

    public function it_can_add_custom_responses()
    {
        $this->addResponseType('application/foobar', new FooBarResponse());

        $this->negotiateResponse()->shouldHaveType(FooBarResponse::class);
    }

    public function it_returns_json_response_by_default()
    {
        $this->negotiateResponse()->shouldHaveType(JsonResponse::class);
    }
}
