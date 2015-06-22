<?php namespace Refinery29\Piston;

use ArrayAccess;
use League\Container\Container;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerInterface;
use League\Container\ServiceProvider;
use Refinery29\Piston\Hooks\Hookable;
use Refinery29\Piston\Hooks\Worker;
use Refinery29\Piston\Request\Filters\Fields;
use Refinery29\Piston\Request\Filters\IncludedResource;
use Refinery29\Piston\Request\Filters\Pagination;
use Refinery29\Piston\Request\Request;
use Refinery29\Piston\Router\PistonStrategy;
use Refinery29\Piston\Router\RouteCollection;
use Refinery29\Piston\Router\Routes\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class Piston implements ContainerAwareInterface, ArrayAccess
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

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $config;


    /**
     * @param ContainerInterface $container
     * @param array $config_array
     */
    public function __construct(ContainerInterface $container = null, array $config_array = [] )
    {
        $this->container = $container ?: new Container();

        $this->bootstrapRouter();
        $this->bootstrapHooks();

        if (!is_null($config_array)){
            $this->config = $config_array;
        };

        $this->container->add('app', $this);
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request|\Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        $request = $this->request ?: Request::createFromGlobals();

        $request = Pagination::apply($request);
        $request = IncludedResource::apply($request);
        $request = Fields::apply($request);

        $this->container->add('Symfony\Component\HttpFoundation\Request', $request, true);

        return $request;
    }

    /**
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $this->router->addRoute($route);
    }

    /**
     * @return Response
     */
    public function launch()
    {
        $routeData = $this->router->getData();

        $this->router->findRoute($routeData);

        $dispatcher = $this->router->getDispatcher();

        $request = $this->getRequest();

        $response = Worker::work($this->getPreHooks(), $request, new Response());

        $this->container->add('Symfony\Component\HttpFoundation\Response', $response, true);

        $response = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());

        $response = Worker::work($this->getPostHooks(), $request, $response);

        return $response->send();
    }

    /**
     * @param ServiceProvider $service_provider
     */
    public function register(ServiceProvider $service_provider)
    {
        $this->container->addServiceProvider($service_provider);
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    private function bootstrapRouter()
    {
        $this->router = new RouteCollection($this->container);
        $this->router->setStrategy(new PistonStrategy);
    }

    /**
     * @return Response
     */
    public function notFound()
    {
        return new Response('', 404);
    }

    /**
     * @param $url
     * @return RedirectResponse
     */
    static public function redirect($url)
    {
        return new RedirectResponse($url);
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * Array Access get.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->container->get($key);
    }

    /**
     * Array Access set.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->container->singleton($key, $value);
    }

    /**
     * Array Access unset.
     *
     * @param string $key
     *
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->container->offsetUnset($key);
    }

    /**
     * Array Access isset.
     *
     * @param string $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->container->isRegistered($key) || $this->container->isSingleton($key);
    }

    /**
     * @return ArrayAccess
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param ArrayAccess $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}
