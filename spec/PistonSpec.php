<?php

namespace spec\Refinery29\Piston;

use League\Container\Container;
use League\Container\ServiceProvider;
use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Piston;
use Refinery29\Piston\RequestFactory;
use Refinery29\Piston\Router\RouteGroup;
use Refinery29\Piston\Stubs\FooController;
use Refinery29\Piston\Stubs\TestEmitter;
use Zend\Diactoros\Uri;

class PistonSpec extends ObjectBehavior
{
    public function let(Container $container)
    {
        $container->beADoubleOf('League\Container\Container');
        $this->beConstructedWith($container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Piston::class);
    }

    public function it_can_add_a_route_group()
    {
        $this->shouldHaveType(Piston::class);
        $this->group('prefix', function () {})->shouldHaveType(RouteGroup::class);
    }

    public function it_can_add_middleware(StageInterface $operation)
    {
        $this->addMiddleware($operation);
        $this->buildPipeline()->shouldHaveType(Pipeline::class);
    }

    public function it_can_add_service_providers(ServiceProvider\AbstractServiceProvider $provider)
    {
        $provider->beADoubleOf('League\Container\ServiceProvider\AbstractServiceProvider');

        $this->register($provider);
    }

    public function it_launches_with_expected_result()
    {
        $request = RequestFactory::fromGlobals()->withUri(new Uri('/prefix/something'));
        $emitter = new TestEmitter();

        $this->beConstructedWith(null, $request, $emitter);
        $this->group('/prefix', function (RouteGroup $router) {
            $router->get('/something', FooController::class . '::test')->setName('something'); // also still have convenience http methods (get, post, put etc
        });

        $this->launch()->shouldReturn('{"result":{"something":"yolo"}}');
    }
}
