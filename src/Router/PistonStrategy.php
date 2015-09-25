<?php

namespace Refinery29\Piston\Router;

use Kayladnls\Seesaw\RouteCollection;
use League\Route\Strategy\RequestResponseStrategy;
use League\Route\Strategy\StrategyInterface;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;
use Refinery29\Piston\Pipeline\PipelineProcessor;
use Refinery29\Piston\Router\Routes\Routeable;

class PistonStrategy extends RequestResponseStrategy implements StrategyInterface
{
    use PipelineProcessor;

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

    /**
     * @param string $controller
     * @param array  $vars
     *
     * @return Response
     */
    public function dispatch($controller, array $vars = [])
    {
        $this->request = $this->container->get('Request');
        $this->response = $this->container->get('Response');
        $this->router = $this->container->get('PistonRouter');
        $app = $this->container->get('app');

        $this->response = $this->processPipeline($app, $this->request, $this->response);

        $this->handleGroupPipeline($controller);

        $response = $this->invokeAction($controller, [$this->request, $this->response, $vars]);

        return $this->validateResponse($response);
    }

    /**
     * @param string $controller
     */
    private function handleGroupPipeline($controller)
    {
        $route = $this->router->findByAction($controller);
        if ($route) {
            $group = $this->router->findGroupByRoute($route);
            if ($group !== false) {
                $this->response = $this->processPipeline($group, $this->request, $this->response);
            }
        }
    }

    /**
     * Invoke a controller action
     *
     * @param string|\Closure $action
     * @param array           $vars
     *
     * @return Response
     */
    private function invokeAction($action, array $vars = [])
    {
        $controller = $this->resolveController($action);

        return call_user_func_array($controller, $vars);
    }

    /**
     * @param $action
     *
     * @return array
     */
    private function resolveController($action)
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
