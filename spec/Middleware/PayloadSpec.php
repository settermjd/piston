<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace spec\Refinery29\Piston\Middleware;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Middleware\HasMiddleware;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Request;

class PayloadSpec extends ObjectBehavior
{
    public function let(HasMiddleware $subject, Request $request, ApiResponse $response)
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
        $this->getResponse()->shouldHaveType(ApiResponse::class);
    }
}
