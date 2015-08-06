<?php namespace Refinery29\Piston\Router\Routes;

use Refinery29\Piston\Pipeline\HasPipelines;
use Refinery29\Piston\Pipeline\LifeCyclePipelines;
use Kayladnls\Seesaw\RouteGroup as SeesawGroup;

/**
 * Class RouteGroup
 * @package Refinery29\Piston\Router\Routes
 */
class RouteGroup extends SeesawGroup implements HasPipelines
{
    use LifeCyclePipelines;
}
