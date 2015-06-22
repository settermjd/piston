<?php namespace Refinery29\Piston\Router;

use FastRoute\RouteParser\Std;
use League\Container\ContainerInterface;
use League\Route\RouteCollection as Router;
use Refinery29\Piston\Router\Routes\Route;
use Refinery29\Piston\Router\Routes\RouteGroup;

class RouteCollection extends Router
{
    /**
     * @var Route[]
     */
    protected $route_objects;

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
        parent::__construct($container);
        $this->parser = new Std();
    }

    /**
     * @param Route $route
     */
    public function add(Route $route)
    {
        $route_alias = $this->parseAlias($route);
        $route->setParsedAlias($route_alias);

        parent::addRoute($route->getVerb(), $route->getAlias(), $route->getAction());
        $this->route_objects[] = $route;
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
        $parsed_alias = $this->parseRouteString($route->getAlias());
        $parsed_alias = $this->parser->parse($parsed_alias);

        return $this->buildRegexForRoute($parsed_alias);
    }

    /**
     * @param RouteGroup $group
     */
    public function addRouteGroup(RouteGroup $group)
    {
        foreach ($group->getRoutes() as $route) {
            $this->add($route);
            $this->groups = $group;
        }
    }

    public function byVerb($verb)
    {
        $return = [];
        foreach ($this->route_objects as $route) {
            if ($route->getVerb() == $verb) {
                $return[] = $route;
            }
        }

        return $return;
    }

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
}
