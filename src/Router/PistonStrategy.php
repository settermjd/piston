<?php namespace Refinery29\Piston\Router;

use Closure;
use League\Route\Strategy\RequestResponseStrategy;
use League\Route\Strategy\StrategyInterface;
use Refinery29\Piston\Router\Routes\Routeable;
use Symfony\Component\HttpFoundation\Response;

class PistonStrategy extends RequestResponseStrategy implements StrategyInterface
{
    /**
     * @param array|callable|string $controller
     * @param array $vars
     * @return mixed
     */
    public function dispatch($controller, array $vars = [])
    {
        $request = $this->container->get('PistonRequest');

        $original_response = $this->container->get('Symfony\Component\HttpFoundation\Response');

        $app = $this->container->get('app');

        $response = $this->processPreHooks($app, $request, $original_response);

        if (is_array($controller) && is_string($controller[0])) {
            /** @var RouteCollection */
            $router = $this->container->get('PistonRouter');

            $active_route = $router->findByAction($controller);

            if ($active_route !== false) {
                $group = $router->findGroupByRoute($active_route);
                if ($group !== false) {
                    $response = $this->processPreHooks($group, $request, $original_response);
                }

                $response = $this->processPreHooks($active_route, $request, $original_response);
            }
        }

        $response = $this->invokeAction($controller, [
            $request,
            $response,
            $vars
        ]);

        if (is_array($controller) && is_string($controller[0]) && $active_route !== false) {
            if ($group !== false) {
                $this->processPostHooks($group, $request, $original_response);
            }

            $response = $this->processPostHooks($active_route, $request, $original_response);
        }


        $this->processPostHooks($app, $request, $original_response);

        return $this->validateResponse($response);
    }

    /**
     * @param $item
     * @param $request
     * @param $original_response
     * @return Response
     */
    protected function processPreHooks($item, $request, $original_response)
    {
        $response = $item->getPreHooks()->process([$request, $original_response]);
        return $response instanceof Response ? $response : $original_response;
    }

    /**
     * @param $item
     * @param $request
     * @param $original_response
     * @return Response
     */
    protected function processPostHooks($item, $request, $original_response)
    {
        $response = $item->getPostHooks()->process([$request, $original_response]);
        return $response instanceof Response ? $response : $original_response;
    }

    /**
     * Invoke a controller action
     *
     * @param  string|\Closure $action
     * @param  array $vars
     * @return Response
     */
    public function invokeAction($action, array $vars = [])
    {
        if ($action instanceof Closure) {
            return $this->dispatchClosure($action, $vars);
        }

        return $this->dispatchRoutable($action, $vars);
    }

    /**
     * @param $action
     * @param $vars
     * @return mixed
     */
    public function dispatchRoutable($action, $vars)
    {
        $controller = $this->resolveController($action);

        $response = call_user_func_array($controller, $vars);

        return $this->validateResponse($response);
    }

    /**
     * @param $action
     * @return array
     */
    public function resolveController($action)
    {
        if (is_array($action) && !($action[0] instanceof Routeable)) {
            return [
                $this->container->get($action[0]),
                $action[1]
            ];
        }

        return $action;
    }

    /**
     * @param $action
     * @param array $vars
     * @return mixed
     */
    public function dispatchClosure($action, $vars = [])
    {
        $response = $action(array_shift($vars), array_shift($vars), $vars);

        return $this->validateResponse($response);
    }

    /**
     * @param $response
     * @return mixed
     */
    public function validateResponse($response)
    {
        if ($response instanceof Response) {
            return $response;
        }
        throw new \RuntimeException(
            'Your request must return an instance of Response'
        );
    }
}
