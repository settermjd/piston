<?php

namespace Refinery29\Piston\Router\Routes;

use Kayladnls\Seesaw\RouteGroup as SeesawGroup;
use Refinery29\Piston\Pipeline\HasPipeline;
use Refinery29\Piston\Pipeline\LifeCyclePipelines;

/**
 * Class RouteGroup
 */
class RouteGroup extends SeesawGroup implements HasPipeline
{
    use LifeCyclePipelines;
}
