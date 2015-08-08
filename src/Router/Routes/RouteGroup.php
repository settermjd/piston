<?php

namespace Refinery29\Piston\Router\Routes;

use Kayladnls\Seesaw\RouteGroup as SeesawGroup;
use Refinery29\Piston\Pipeline\HasPipelines;
use Refinery29\Piston\Pipeline\LifeCyclePipelines;

/**
 * Class RouteGroup
 */
class RouteGroup extends SeesawGroup implements HasPipelines
{
    use LifeCyclePipelines;
}
