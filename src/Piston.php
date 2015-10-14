<?php

namespace Refinery29\Piston;

use League\Container\Container;
use League\Container\ContainerInterface;
use League\Container\ServiceProvider;
use League\Route\RouteCollection;
use Psr\Http\Message\RequestInterface;
use Refinery29\Piston\Middleware\HasMiddleware;
use Refinery29\Piston\Middleware\HasMiddlewareTrait;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Middleware\PipelineProcessor;
use Refinery29\Piston\Middleware\Request\RequestPipeline;
use Refinery29\Piston\Router\MiddlewareStrategy;
use Refinery29\Piston\Router\RouteGroup;
use Zend\Diactoros\Response\EmitterInterface;
use Zend\Diactoros\Response\SapiEmitter;

final class Piston extends RouteCollection implements HasMiddleware
{
    use HasMiddlewareTrait;

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
        $this->response = (new PipelineProcessor())->handlePayload($this->getSubject())
                            ->getResponse();

        $this->response = $this->dispatch($this->request, $this->response);
        $this->response->compileContent();

        return $this->emitter->emit($this->response);
    }

    private function loadContainer()
    {
        (new RequestPipeline())->process($this->getSubject());

        $this->container->add('Request', $this->request, true);
        $this->container->add('Response', $this->response, true);
    }

    /**
     * @param ServiceProvider\AbstractServiceProvider $serviceProvider
     */
    public function register(ServiceProvider\AbstractServiceProvider $serviceProvider)
    {
        $this->container->addServiceProvider($serviceProvider);
    }

    /**
     * @return Payload
     */
    private function getSubject()
    {
        return new Payload($this, $this->request, $this->response);
    }
}
