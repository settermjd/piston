<?php

namespace Refinery29\Piston\Router;

use League\Route\Route;
use League\Route\Strategy\RequestResponseStrategy;
use League\Route\Strategy\StrategyInterface;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;
use Refinery29\Piston\Middleware\PipelineProcessor;
use Refinery29\Piston\Middleware\Subject;

class MiddlewareStrategy extends RequestResponseStrategy implements StrategyInterface
{
    /**
     * @var RouteCollection
     */
    protected $router;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    public function __construct($container)
    {
        $this->container = $container;
    }

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
        $this->request = $this->container->get('Request');
        $this->response = $this->container->get('Response');

        if ($group = $route->getParentGroup()) {
            (new PipelineProcessor())->processPipeline(new Subject($group, $this->request, $this->response));
        }

        $response = call_user_func_array(
            $this->resolveController($controller),
            [$this->request, $this->response, $vars]
        );

        return $this->validateResponse($response);
    }

    /**
     * @param $action
     *
     * @return array
     */
    private function resolveController($action)
    {
        if (is_array($action)) {
            $controller = $action[0];
            $class = get_class($controller);
            return [
                $this->container->get($class),
                $action[1],
            ];
        }

        return $action;
    }

    /**
     * @param $response
     *
     * @throws \Exception
     *
     * @return mixed
     */
    private function validateResponse($response)
    {
        if ($response instanceof Response) {
            return $response;
        }

        throw new \Exception('Your request must return an instance of ' . Response::class);
    }
}
