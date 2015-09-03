<?php

namespace spec\Refinery29\Piston\Http\Pipeline;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\JsonResponse;

class ResponsePipelineSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Http\Pipeline\ResponsePipeline');
    }

    public function it_can_be_processed(JsonResponse $response)
    {
        $this->process($response)->shouldReturn($response);
    }
}
