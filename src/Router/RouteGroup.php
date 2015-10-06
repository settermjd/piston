<?php

namespace Refinery29\Piston\Router;

use League\Pipeline\StageInterface;
use Refinery29\Piston\Middleware\HasMiddleware;
use Refinery29\Piston\Middleware\HasPipeline;

/**
 * Class RouteGroup
 */
class RouteGroup extends \League\Route\RouteGroup implements HasPipeline
{
    use HasMiddleware;

    protected $routes;

    /**
     * {@inheritdoc}
     */
    public function map($method, $path, $handler)
    {
        $route = parent::map($method, $path, $handler);

        $this->routes[] = $route;

        return $route;
    }
}
