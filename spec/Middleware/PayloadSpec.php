<?php

namespace spec\Refinery29\Piston\Middleware;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Middleware\HasMiddleware;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class PayloadSpec extends ObjectBehavior
{
    public function let(HasMiddleware $subject, Request $request, Response $response)
    {
        $this->beConstructedWith($subject, $request, $response);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Payload::class);
    }

    public function it_can_get_subject()
    {
        $this->getSubject()->shouldHaveType(HasMiddleware::class);
    }

    public function it_can_get_request()
    {
        $this->getRequest()->shouldHaveType(Request::class);
    }

    public function it_can_get_response()
    {
        $this->getResponse()->shouldHaveType(Response::class);
    }
}
