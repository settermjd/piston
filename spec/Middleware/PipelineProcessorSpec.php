<?php

namespace spec\Refinery29\Piston\Middleware;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class PipelineProcessorSpec extends ObjectBehavior
{
    public function it_handles_a_subject()
    {
        $request = new Request();
        $response = new Response();
        $subject = new Payload($request, $request, $response);
        $this->handleSubject($subject)->shouldHaveType(Payload::class);
    }
}
