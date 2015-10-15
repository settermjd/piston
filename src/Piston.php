<?php

namespace Refinery29\Piston;

use League\Container\Container;
use League\Container\ContainerInterface;
use League\Container\ServiceProvider;
use League\Route\RouteCollection;
use Psr\Http\Message\RequestInterface;
use Refinery29\Piston\Router\MiddlewareStrategy;
use Refinery29\Piston\Router\RouteGroup;
use Zend\Diactoros\Response\EmitterInterface;
use Zend\Diactoros\Response\SapiEmitter;

class Piston extends RouteCollection implements Middleware\HasMiddleware
{
    use Middleware\HasMiddlewareTrait;

    /**
     * @var Request
     */
    private $request = null;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var EmitterInterface
     */
    private $emitter;

    public function __construct(
        ContainerInterface $container = null,
        RequestInterface $request = null,
        EmitterInterface $emitter = null
    ) {
        $this->container = $container ?: new Container();
        $this->request = $request ?: RequestFactory::fromGlobals();
        $this->emitter = $emitter ?: new SapiEmitter();

        $this->response = new Response();

        $this->loadContainer();
        parent::__construct($this->container);

        $this->setStrategy(new MiddlewareStrategy($this->container));
    }

    /**
     * Add a group of routes to the collection.
     *
     * @param string   $prefix
     * @param callable $group
     *
     * @return RouteGroup
     */
    public function group($prefix, callable $group)
    {
        $group = new RouteGroup($prefix, $group, $this);

        $this->groups[] = $group;

        return $group;
    }

    /**
     * @return Response
     */
    public function launch()
    {
        $this->processPipeline();

        $this->response = $this->dispatch($this->request, $this->response);
        $this->response->compileContent();

        $this->request = $this->request->fromCookieJar();

        return $this->emitter->emit($this->response);
    }

    /**
     * @param ServiceProvider\AbstractServiceProvider $serviceProvider
     */
    public function register(ServiceProvider\AbstractServiceProvider $serviceProvider)
    {
        $this->container->addServiceProvider($serviceProvider);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    private function processPipeline()
    {
        (new Middleware\PipelineProcessor())->handlePayload($this->getSubject());
    }

    private function loadContainer()
    {
        (new Middleware\Request\RequestPipeline())->process($this->getSubject());

        $this->container->add(Request::class, $this->request, true);
        $this->container->add(Response::class, $this->response, true);
    }

    /**
     * @return Middleware\Payload
     */
    private function getSubject()
    {
        return new Middleware\Payload($this, $this->request, $this->response);
    }
}
