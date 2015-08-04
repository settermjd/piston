<?php namespace Refinery29\Piston;

use ArrayAccess;
use Kayladnls\Seesaw\Seesaw;
use League\Container\Container;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerInterface;
use League\Container\ServiceProvider;
use Refinery29\Piston\Hooks\Hookable;
use Refinery29\Piston\Hooks\Fields;
use Refinery29\Piston\Hooks\Pagination\OffsetLimitPagination;
use Refinery29\Piston\Hooks\Pagination\CursorBasedPagination;
use Refinery29\Piston\Hooks\IncludedResource;
use Refinery29\Piston\Hooks\RequestedFields;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\RequestTypeNegotiator;
use Refinery29\Piston\Router\PistonStrategy;
use Refinery29\Piston\Router\Routes\Route;
use Refinery29\Piston\Router\Routes\RouteGroup;
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
     * @var Seesaw
     */
    protected $router;

    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @var array
     */
    protected $config;


    /**
     * @param ContainerInterface $container
     * @param array $config_array
     */
    public function __construct(ContainerInterface $container = null, array $config_array = [])
    {
        $this->container = $container ?: new Container();
        $this->container['app'] = $this;

        $this->bootstrapRouter();
        $this->bootstrapHooks();

        if (!is_null($config_array)) {
            $this->config = $config_array;
        };
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request ? $this->request : Request::createFromGlobals();
    }

    public function getResponse(Request $request)
    {
        $negotiator = new RequestTypeNegotiator($request);

        return $negotiator->negotiateResponse();
    }

    /**
     * @param Route $route
     * @return Piston
     */
    public function addRoute(Route $route)
    {
        $this->router->add($route);

        return $this;
    }

    /**
     * @param RouteGroup $group
     * @return $this
     */
    public function addRouteGroup(RouteGroup $group)
    {
        $this->router->addGroup($group);

        return $this;
    }

    /**
     * @param string $name
     * @param Route $route
     */
    public function addNamedRoute($name, Route $route)
    {
        $this->router->addNamedRoute($name, $route->getVerb(), $route->getUrl(), $route->getAction());
    }

    /**
     * @return Response
     */
    public function launch()
    {
        $dispatcher = $this->router->getDispatcher();

        $this->loadContainer();

        $response = $dispatcher->dispatch($this->request->getMethod(), $this->request->getPathInfo());


        return $response->send();
    }

    protected function loadContainer()
    {
        $this->preProcessRequest();

        $this->container->singleton('PistonRequest', $this->request);
        $this->container->singleton('Symfony\Component\HttpFoundation\Request', $this->request);

        $this->container->add('Symfony\Component\HttpFoundation\Response', $this->getResponse($this->request), true);
    }

    protected function preProcessRequest()
    {
        $request = $this->getRequest();
        $request = (new CursorBasedPagination())->process($request);
        $request = (new OffsetLimitPagination())->process($request);
        $request = (new IncludedResource())->process($request);
        $request = (new RequestedFields())->process($request);

        $this->request = $request;

        return $request;
    }

    /**
     * @param ServiceProvider $service_provider
     */
    public function register(ServiceProvider $service_provider)
    {
        $this->container->addServiceProvider($service_provider);
    }

    public function addDecorator(Decorator $decorator)
    {
        $app = $decorator->register();

        if (!$app instanceof Piston) {
            throw new \InvalidArgumentException('Decorators Must Return an Instance of Piston');
        }

        return $app;
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
        $this->router = new Seesaw(null, null, $this->container);
        $this->router->setStrategy(new PistonStrategy);
        $this->container->add('PistonRouter', $this->router);
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
    public static function redirect($url)
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
