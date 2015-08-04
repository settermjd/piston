<?php namespace Refinery29\Piston\Router\Routes;

use Refinery29\Piston\Hooks\HasHooks;
use Refinery29\Piston\Hooks\Hookable;
use Kayladnls\Seesaw\RouteGroup as SeesawGroup;

/**
 * Class RouteGroup
 * @package Refinery29\Piston\Router\Routes
 */
class RouteGroup extends SeesawGroup implements HasHooks
{
    use Hookable;
}
