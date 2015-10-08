<?php

namespace Refinery29\Piston\Router;

use League\Route\Http\RequestAwareInterface;
use League\Route\Http\RequestAwareTrait;
use League\Route\Http\ResponseAwareInterface;
use League\Route\Http\ResponseAwareTrait;
use League\Route\Route;
use League\Route\RouteCollection;
use League\Route\Strategy\RequestResponseStrategy;
use League\Route\Strategy\StrategyInterface;
use Refinery29\Piston\Response;
use Refinery29\Piston\Middleware\PipelineProcessor;
use Refinery29\Piston\Middleware\Subject;

class MiddlewareStrategy extends RequestResponseStrategy implements StrategyInterface, RequestAwareInterface, ResponseAwareInterface
{
    use RequestAwareTrait;
    use ResponseAwareTrait;

    /**
     * @var RouteCollection
     */

    /**
     * @param callable|string $controller
     * @param array $vars
     *
     * @param Route $route
     * @return Response
     * @throws \Exception
     */
    public function dispatch(callable $controller, array $vars = [], Route $route = null)
    {
        if ($group = $route->getParentGroup()) {
            $this->response = (new PipelineProcessor())->processPipeline(new Subject($group, $this->request, $this->response));
        }

        return call_user_func_array($controller,
            [$this->request, $this->response, $vars]
        );
    }
}
