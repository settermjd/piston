<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace spec\Refinery29\Piston\Middleware;

use League\Pipeline\Pipeline;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Request;

class PipelineProcessorSpec extends ObjectBehavior
{
    public function it_handles_a_subject(Piston $middleware)
    {
        $pipeline = new Pipeline([]);
        $middleware->getPipeline()->willReturn($pipeline);

        $request = new Request();
        $response = new ApiResponse();
        $subject = new Payload($middleware->getWrappedObject(), $request, $response);
        $this->handlePayload($subject)->shouldHaveType(Payload::class);
    }
}
