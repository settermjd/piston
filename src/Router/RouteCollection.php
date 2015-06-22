<?php namespace Refinery29\Piston\Router;

use FastRoute\RouteParser\Std;
use League\Container\ContainerInterface;
use League\Route\RouteCollection as Router;
use Refinery29\Piston\Router\Routes\Route;
use Refinery29\Piston\Router\Routes\RouteGroup;

class RouteCollection
{
    /**
     * @var Route[]
     */
    protected $routes;

    /**
     * @var RouteGroup[]
     */
    protected $groups;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->router = new Router($container);
        $this->parser = new Std();
    }

    /**
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $route_alias = $this->parseAlias($route);
        $route->setParsedAlias($route_alias);

        $this->router->addRoute($route->getVerb(), $route->getAlias(), $route->getAction());
        $this->routes[] = $route;
    }

    protected function buildRegexForRoute($routeData)
    {
        $regex = '';
        foreach ($routeData as $part) {
            if (is_string($part)) {
                $regex .= preg_quote($part, '/');
                continue;
            }

            $regexPart = array_pop($part);

            $regex .= '(' . $regexPart . ')';
        }

        return "~".$regex."~";
    }

    private function parseAlias($route)
    {
        $parsed_alias = $this->router->parseRouteString($route->getAlias());
        $parsed_alias = $this->parser->parse($parsed_alias);

        return $this->buildRegexForRoute($parsed_alias);

    }

    /**
     * @param RouteGroup $group
     */
    public function addRouteGroup(RouteGroup $group)
    {
        foreach ($group->getRoutes() as $route) {
            $this->addRoute($route);
            $this->groups = $group;
        }
    }

    public function byVerb($verb)
    {
        $return = [];
        foreach ($this->routes as $route) {
            if ($route->getVerb() == $verb) {
                $return[] = $route;
            }
        }

        return $return;
    }

    /**
     * @param array $data
     */
    public function findRoute()
    {
        $request = $this->container->get('app')->getRequest();

        $path = $request->getPathInfo();
        $method = $request->getMethod();



        foreach ($this->byVerb($method) as $route) {
//            echo print_r($route->getParsedAlias()."\n", true);
//            ~^(?|/john/bob/([a-zA-Z]+)|/john/joseph/([a-zA-Z]+)()|/john/lala/([a-zA-Z]+)()())$~

            if (preg_match($route->getParsedAlias(), $path, $matches)) {
                echo "<pre>".print_r($matches, true)."</pre>";
            }
        }

//        exit;

    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    function __call($name, $arguments)
    {
        return call_user_func_array([$this->router, $name], $arguments);
    }

    /**
     * @param $name
     * @return mixed
     */
    function __get($name)
    {
        if (property_exists($this->router, $name)) {
            return $this->router->$name;
        }
    }

}