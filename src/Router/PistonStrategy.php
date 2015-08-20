<?php

namespace Refinery29\Piston\Router;

use Closure;
use League\Route\Strategy\RequestResponseStrategy;
use League\Route\Strategy\StrategyInterface;
use Refinery29\Piston\Pipeline\PipelineProcessor;
use Refinery29\Piston\Router\Routes\Routeable;
use Symfony\Component\HttpFoundation\Response;

class PistonStrategy extends RequestResponseStrategy implements StrategyInterface
{
    use PipelineProcessor;

    /**
     * @param array|callable|string $controller
     * @param array                 $vars
     *
     * @return mixed
     */
    public function dispatch($controller, array $vars = [])
    {
        $request = $this->container->get('Request');
        $original_response = $this->container->get('Response');
        $router = $this->container->get('PistonRouter');
        $app = $this->container->get('app');

        $response = $this->processPrePipeline($app, $request, $original_response);

        if ($controller instanceof Closure) {
            return $controller($request, $response, $vars);
        }

        $active_route = $router->findByAction($controller);

        if (!empty($active_route)) {
            $group = $router->findGroupByRoute($active_route);
            if ($group !== false) {
                $response = $this->processPrePipeline($group, $request, $original_response);
            }
        }

        $response = $this->invokeAction($controller, [$request, $response, $vars]);

        if (!empty($active_route) && isset($group)) {
            $response = $this->processPrePipeline($group, $request, $original_response);
        }

        $this->processPostPipeline($app, $request, $original_response);

        return $this->validateResponse($response);
    }

    /**
     * Invoke a controller action
     *
     * @param string|\Closure $action
     * @param array           $vars
     *
     * @return Response
     */
    public function invokeAction($action, array $vars = [])
    {
        $controller = $this->resolveController($action);

        return call_user_func_array($controller, $vars);
    }

    /**
     * @param $action
     *
     * @return array
     */
    public function resolveController($action)
    {
        if (is_array($action) && !($action[0] instanceof Routeable)) {
            return [
                $this->container->get($action[0]),
                $action[1],
            ];
        }

        return $action;
    }

    /**
     * @param $action
     * @param $request
     * @param $response
     * @param array $vars
     *
     * @return mixed
     */
    public function dispatchClosure($action, $request, $response, $vars = [])
    {
        return $action($request, $response, $vars);
    }

    /**
     * @param $response
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function validateResponse($response)
    {
        if ($response instanceof Response) {
            return $response;
        }

        throw new \Exception('Your request must return an instance of Response');
    }
}
