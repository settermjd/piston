<?php

namespace spec\Refinery29\Piston\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;
use Refinery29\Piston\Stubs\FooBarResponse;

class RequestTypeNegotiatorSpec extends ObjectBehavior
{
    public function let(Request $request)
    {
        $request->getAcceptableContentTypes()->willReturn(['application/foobar']);
        $this->beConstructedWith($request);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Http\RequestTypeNegotiator');
    }

    public function it_can_add_custom_responses()
    {
        $this->addResponseType('application/foobar', new FooBarResponse());

        $this->negotiateResponse()->shouldHaveType(FooBarResponse::class);
    }

    public function it_has_default_response()
    {
        $this->negotiateResponse()->shouldHaveType(Response::class);
    }
}
