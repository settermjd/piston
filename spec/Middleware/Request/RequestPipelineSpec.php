<?php

namespace spec\Refinery29\Piston\Middleware\Request;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Middleware\Request\RequestPipeline;
use Refinery29\Piston\Middleware\Subject;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class RequestPipelineSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(RequestPipeline::class);
    }

    public function it_can_be_processed()
    {
        $request = new Request();

        $this->process(new Subject($request, $request, new Response()))->shouldReturn($request);
    }
}
