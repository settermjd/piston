<?php namespace Refinery29\Piston\Router\Routes;

use Kayladnls\Seesaw\Route as SeesawRoute;
use Refinery29\Piston\Hooks\HasHooks;
use Refinery29\Piston\Hooks\Hookable;

class Route extends SeesawRoute implements HasHooks
{
    use Hookable;
}
