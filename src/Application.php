<?php namespace Refinery29\Piston;

use Dotenv\Dotenv;
use League\Container\Container;
use League\Container\ContainerInterface;
use League\Route\RouteCollection;
use Refinery29\Piston\Hooks\Hookable;
use Refinery29\Piston\Router\PistonStrategy;
use Refinery29\Piston\Router\Routes\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/4/15
 * Time: 1:37 PM
 */
class Application
{
    use Hookable;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var RouteCollection
     */
    protected $router;

    public function __construct(ContainerInterface $container = null)
    {
        if (is_null($container)) {
            $this->container = new Container();
        }

        $this->container->add('app', $this);

        $this->bootstrapRouter();
        $this->bootstrapHooks();
    }

    public function setEnvConfig($directory)
    {
        $env = new Dotenv($directory);
        $env->load();
    }

    public function addRoute(Route $route)
    {
        $this->router->addRoute($route->getVerb(), $route->getAlias(), $route->getAction());
    }

    public function launch()
    {
        $dispatcher = $this->router->getDispatcher();

        $request = Request::createFromGlobals();
        $response = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
        $response->send();
    }

    public function getContainer()
    {
        return $this->container;
    }

    private function bootstrapRouter()
    {
        $this->router = new RouteCollection($this->container);
        $this->router->setStrategy(new PistonStrategy($this->container));
    }
}
