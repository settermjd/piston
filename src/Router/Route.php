<?php

namespace Refinery29\Piston\Router;

use Refinery29\Piston\Middleware\HasMiddleware;
use Refinery29\Piston\Middleware\HasMiddlewareTrait;

/**
 * Class RouteGroup
 */
class Route extends \League\Route\Route implements HasMiddleware
{
    use HasMiddlewareTrait;
}
