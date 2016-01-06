<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace spec\Refinery29\Piston\Router;

use League\Pipeline\StageInterface;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Middleware\ExceptionalPipeline;
use Refinery29\Piston\Router\Route;

class RouteSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Route::class);
    }

    public function it_can_add_middleware(StageInterface $operation)
    {
        $this->addMiddleware($operation);
        $this->getPipeline()->shouldHaveType(ExceptionalPipeline::class);
    }
}
