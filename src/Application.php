<?php namespace Refinery29\Piston;

use Dotenv\Dotenv;
use League\Container\Container;
use League\Container\ContainerInterface;
use League\Route\RouteCollection;
use Refinery29\Piston\Hooks\HookQueue;
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
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var RouteCollection
     */
    protected $router;

    /**
     * @var HookQueue
     */
    protected $pre_hooks;

    /**
     * @var HookQueue
     */
    protected $post_hooks;

    protected $default_permission = "PUBLIC";

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
        if ($route->getPermission() == null) {
            $route->setPermission($this->default_permission);
        }

        $this->router->addRoute($route->getVerb(), $route->getAlias(), $route->getAction());
    }

    public function addPreHook()
    {

    }

    public function addPostHook()
    {

    }

    public function getPreHooks()
    {

    }

    public function getPostHooks()
    {

    }

    public function setDefaultPermission($permission)
    {
        $this->default_permission = $permission;
    }

    public function getDefaultPermission()
    {
        return $this->default_permission;
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

    private function bootstrapHooks()
    {
        $this->pre_hooks = new HookQueue();
        $this->post_hooks = new HookQueue();
    }

}
