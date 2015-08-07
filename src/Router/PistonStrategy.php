<?php namespace Refinery29\Piston\Router;

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
     * @param array $vars
     * @return mixed
     */
    public function dispatch($controller, array $vars = [])
    {
        $request = $this->container->get('Symfony\Component\HttpFoundation\Request');

        $original_response = $this->container->get('Symfony\Component\HttpFoundation\Response');

        $app = $this->container->get('app');

        $response = $this->processPrePipeline($app, $request, $original_response);

        if (is_array($controller) && is_string($controller[0])) {
            /** @var RouteCollection */
            $router = $this->container->get('PistonRouter');

            $active_route = $router->findByAction($controller);

            if (!empty($active_route)) {
                $group = $router->findGroupByRoute($active_route);
                if ($group !== false) {
                    $response = $this->processPrePipeline($group, $request, $original_response);
                }
            }
        }

        $response = $this->invokeAction($controller, [
            $request,
            $response,
            $vars
        ]);

        if (is_array($controller) && is_string($controller[0]) && isset($active_route) && !empty($active_route)) {
            if ($group !== false) {
                $this->processPostHooks($group, $request, $original_response);
            }

            $response = $this->processPostHooks($active_route, $request, $original_response);
        }

        $this->processPostHooks($app, $request, $original_response);

        return $this->validateResponse($response);
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
