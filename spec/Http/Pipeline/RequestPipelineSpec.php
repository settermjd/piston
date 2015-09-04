<?php

namespace spec\Refinery29\Piston\Http\Pipeline;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Http\Pipeline\RequestPipeline;
use Refinery29\Piston\Http\Request;

class RequestPipelineSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(RequestPipeline::class);
    }

    public function it_can_be_processed(Request $request)
    {
        $this->process($request)->shouldReturn($request);
    }
}
