<?php

namespace Refinery29\Piston\Router;

use Refinery29\Piston\Middleware\HasMiddleware;
use Refinery29\Piston\Middleware\HasMiddlewareTrait;

/**
 * Class RouteGroup
 */
class RouteGroup extends \League\Route\RouteGroup implements HasMiddleware
{
    use HasMiddlewareTrait;

    /**
     * {@inheritdoc}
     */
    public function map($method, $path, $handler)
    {
        $route = parent::map($method, $path, $handler);

        return $route;
    }
}
