<?php namespace Refinery29\Piston\Router;

use Closure;
use League\Route\Strategy\StrategyInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/4/15
 * Time: 1:45 PM
 */
class PistonStrategy implements StrategyInterface
{
    /**
     * @var
     */
    private $container;

    function __construct($container)
    {
        $this->container = $container;
    }

    public function dispatch($controller, array $vars = [])
    {
        $response = $this->invokeAction($controller, [
            Request::createFromGlobals(),
            Response::create(),
            $vars
        ]);

        return $this->validateResponse($response);
    }

    /**
     * Invoke a controller action
     *
     * @param  string|\Closure $action
     * @param  array $vars
     * @return ResponseInterface
     */
    public function invokeAction($action, array $vars = [])
    {
        if ($action instanceof Closure) {
            return $this->dispatchClosure($action, $vars);
        }

        return $this->dispatchController($action, $vars);

    }

    public function dispatchController($action, $vars)
    {
        $controller = $this->resolveController($action);

//        $controller[0]->beforeController();
        $response = call_user_func_array($controller, $vars);

        return $this->validateResponse($response);

//        return $controller[0]->afterController($response);
    }

    public function resolveController($action)
    {
        if (is_array($action) && !($action[0] instanceof Routeable)) {
            return [
                $this->container->get($action[0]),
                $action[1]
            ];
        } else {
            return $action;
        }

    }

    public function dispatchClosure($action, $vars = [])
    {
        $response = $action(array_shift($vars), array_shift($vars), $vars);

        return $this->validateResponse($response);
    }

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