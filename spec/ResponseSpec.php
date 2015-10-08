<?php

namespace spec\Refinery29\Piston\Http;

use PhpSpec\ObjectBehavior;
use Refinery29\ApiOutput\ResponseBody;
use Refinery29\Piston\Response;

class ResponseSpec extends ObjectBehavior
{
    public function let(ResponseBody $body)
    {
        $this->beConstructedWith($body);
    }

    public function it_can_be_constructed_without_response_body()
    {
        $this->getContent()->shouldReturn('{}');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Response::class);
    }
}
