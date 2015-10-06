<?php

namespace Refinery29\Piston;

use League\Container\Container;
use League\Container\ContainerInterface;
use League\Container\ServiceProvider;
use League\Route\RouteCollection;
use Psr\Http\Message\RequestInterface;
use Refinery29\Piston\Middleware\Request\RequestPipeline;
use Refinery29\Piston\Request;
use Refinery29\Piston\RequestFactory;
use Refinery29\Piston\Response;
use Refinery29\Piston\Middleware\HasMiddleware;
use Refinery29\Piston\Middleware\HasPipeline;
use Refinery29\Piston\Middleware\PipelineProcessor;
use Refinery29\Piston\Middleware\Subject;
use Refinery29\Piston\Router\MiddlewareStrategy;
use Refinery29\Piston\Router\RouteGroup;
use Zend\Diactoros\Response as DiactorosResponse;
use Zend\Diactoros\Response\EmitterInterface;
use Zend\Diactoros\Response\SapiEmitter;

final class Piston extends RouteCollection implements HasPipeline
{
    use HasMiddleware;

    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @var Response
     */
    protected $response;


    /**
     * @var SapiEmitter
     */
    protected $emitter;

    /**
     * @param ContainerInterface $container
     * @param RequestInterface $request
     * @param EmitterInterface $emitter
     */
    public function __construct(
        ContainerInterface $container = null,
        RequestInterface $request = null,
        EmitterInterface $emitter = null
    ) {
        $this->container = $container ?: new Container();
        $this->emitter = $emitter ?: new SapiEmitter();
        $this->request = $request ?: RequestFactory::fromGlobals();
        $this->response = $this->response ?: new Response();

        $this->loadContainer();
        parent::__construct($this->container);

        $this->setStrategy(new MiddlewareStrategy($this->container));
    }

    /**
     * Add a group of routes to the collection.
     *
     * @param string $prefix
     * @param callable $group
     *
     * @return \League\Route\RouteGroup
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
        $this->response = (new PipelineProcessor())
            ->processPipeline(new Subject($this, $this->request, $this->response));

        $this->response = $this->dispatch($this->request, $this->response);
        $this->response->compileContent();

        $this->emitter->emit($this->response);
    }

    private function loadContainer()
    {
        (new RequestPipeline())->process(new Subject($this->request, $this->request, $this->response));

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
}
