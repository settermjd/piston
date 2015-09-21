<?php

namespace spec\Refinery29\Piston\Http;

use PhpSpec\ObjectBehavior;
use Refinery29\ApiOutput\ResponseBody;
use Refinery29\Piston\Http\Response;

class ResponseSpec extends ObjectBehavior
{
    public function let(ResponseBody $body)
    {
        $this->beConstructedWith(\Symfony\Component\HttpFoundation\Response::create(), $body);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Response::class);
    }
}
