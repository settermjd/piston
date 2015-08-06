<?php namespace spec\Refinery29\Piston;

use League\Container\Container;
use League\Container\ContainerInterface;
use League\Container\ServiceProvider;
use League\Pipeline\StageInterface;
use League\Pipeline\Pipeline;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Decorator;
use Refinery29\Piston\Http\JsonResponse;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\ResponseNegotiator;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Router\Routes\Route;
use Refinery29\Piston\Router\Routes\RouteGroup;

class PistonSpec extends ObjectBehavior
{
    public function let(Container $container)
    {
        $container->beADoubleOf('League\Container\Container');
        $this->beConstructedWith($container, []);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Piston');
    }

    public function it_should_create_container_if_none_is_injected()
    {
        $this->beConstructedWith(null, []);
        $this->getContainer()->shouldHaveType('League\Container\Container');
    }

    public function it_can_add_a_route(Route $route)
    {
        $route->getVerb()->willReturn("GET");
        $route->getAction()->willReturn('Foo::Bar');
        $route->getUrl()->willReturn("/yolo");

        $this->addRoute($route);
    }

    public function it_can_add_named_route(Route $route)
    {
        $route->getVerb()->willReturn("GET");
        $route->getAction()->willReturn('Foo::Bar');
        $route->getUrl()->willReturn("/yolo");

        $this->addNamedRoute('ThisIsSomeName', $route);
    }

    public function it_can_negotiate_response_based_on_request(Request $request)
    {
        $request->getAcceptableContentTypes()->willReturn([]);
        $this->getResponse($request)->shouldHaveType(JsonResponse::class);
    }

    public function it_can_negotiate_json_response_based_on_request(Request $request)
    {
        $request->getAcceptableContentTypes()->willReturn(['application/json']);
        $this->getResponse($request)->shouldHaveType(JsonResponse::class);
    }

    public function it_can_add_a_route_group(RouteGroup $group)
    {
        $group->getRoutes()->willReturn([]);
        $group->updateRoutes()->willReturn(null);
        $this->addRouteGroup($group);
    }

    public function it_can_set_a_container(ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->getContainer()->shouldReturn($container);
    }

    public function it_can_add_pre_hooks(StageInterface $operation)
    {
        $this->addPre($operation);
        $this->getPrePipeline()->shouldHaveType(Pipeline::class);
    }

    public function it_can_add_post_hooks(StageInterface $operation)
    {
        $this->addPost($operation);
        $this->getPostPipeline()->shouldHaveType(Pipeline::class);
    }

    public function it_can_set_a_request(Request $request)
    {
        $request->beADoubleOf(Request::class);

        $this->setRequest($request);

        $this->getRequest()->shouldReturn($request);
    }

    public function it_creates_a_request_if_one_is_not_provided()
    {
        $this->getRequest()->shouldHaveType('Refinery29\Piston\Http\Request');
    }

    public function it_can_add_service_providers(ServiceProvider $provider)
    {
        $provider->beADoubleOf('League\Container\ServiceProvider');

        $this->register($provider);
    }

    public function it_can_add_a_decorator(Decorator $decorator)
    {
        $piston = new Piston();

        $decorator->beConstructedWith([$piston]);

        $decorator->register()->willReturn($piston);

        $this->addDecorator($decorator)->shouldBeAnInstanceOf(Piston::class);
    }

    public function it_will_ensure_decorator_returns_app(Decorator $decorator)
    {
        $piston = new Piston();

        $decorator->beConstructedWith([$piston]);

        $this->shouldThrow('\InvalidArgumentException')->duringAddDecorator($decorator);
    }

    public function it_can_redirect()
    {
        $this->redirect('123/something')->shouldHaveType('Symfony\Component\HttpFoundation\RedirectResponse');
    }

    public function it_can_404()
    {
        $response = $this->notFound();
        $response->shouldHaveType('Symfony\Component\HttpFoundation\Response');
        $response->getStatusCode()->shouldReturn(404);
    }

    public function it_can_set_config()
    {
        $this->setConfig(['yellow' => 'submarine']);

        $this->getConfig()->shouldReturn(['yellow' => 'submarine']);
    }

    public function it_can_set_config_on_construct()
    {
        $this->beConstructedWith(null, ['yolo']);

        $this->getConfig()->shouldContain('yolo');
    }
}
