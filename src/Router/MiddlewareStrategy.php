<?php

namespace Refinery29\Piston\Router;

use League\Route\Route;
use League\Route\Strategy\RequestResponseStrategy;
use League\Route\Strategy\StrategyInterface;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Middleware\PipelineProcessor;
use Refinery29\Piston\Response;

class MiddlewareStrategy extends RequestResponseStrategy implements StrategyInterface
{
    /**
     * @param callable|string $controller
     * @param array           $vars
     * @param Route           $route
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function dispatch(callable $controller, array $vars = [], Route $route = null)
    {
        if ($group = $route->getParentGroup()) {
            $this->response = (new PipelineProcessor())
                ->handlePayload(new Payload($group, $this->request, $this->response))
                ->getResponse();
        }


        $this->response = (new PipelineProcessor())
            ->handlePayload(new Payload($route, $this->request, $this->response))
            ->getResponse();


        return call_user_func_array($controller,
            [$this->request, $this->response, $vars]
        );
    }
}
