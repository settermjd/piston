<?php

namespace spec\Refinery29\Piston;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Response;
use Zend\Diactoros\Stream;

class ResponseSpec extends ObjectBehavior
{
    public function it_can_be_constructed_without_response_body(Stream $stream)
    {

        $this->beConstructedWith(null, $stream);

        $this->compileContent();
        $this->getBody()->shouldReturn($stream);

        $stream->write("{}")->shouldBeCalled(true);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Response::class);
    }
}
