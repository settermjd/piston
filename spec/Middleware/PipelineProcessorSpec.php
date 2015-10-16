<?php

namespace spec\Refinery29\Piston\Middleware;

use League\Pipeline\Pipeline;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class PipelineProcessorSpec extends ObjectBehavior
{
    public function it_handles_a_subject(Piston $middleware)
    {
        $pipeline = new Pipeline([]);
        $middleware->getPipeline()->willReturn($pipeline);

        $request = new Request();
        $response = new Response();
        $subject = new Payload($middleware->getWrappedObject(), $request, $response);
        $this->handlePayload($subject)->shouldHaveType(Payload::class);
    }
}
