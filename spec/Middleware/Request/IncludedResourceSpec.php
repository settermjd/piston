<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace spec\Refinery29\Piston\Middleware\Request;

use League\Route\Http\Exception\BadRequestException;
use PhpSpec\ObjectBehavior;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Middleware\Request\IncludedResource;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Request;

class IncludedResourceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(IncludedResource::class);
    }

    public function it_will_get_included_resources(Piston $middleware)
    {
        /** @var Request $request */
        $request = (new Request())->withQueryParams(['include' => 'foo,bar,baz']);
        $result = $this->process(new Payload($middleware->getWrappedObject(), $request, new ApiResponse()))->getRequest();

        $result->shouldHaveType(Request::class);

        $resources = $result->getIncludedResources();
        $resources->shouldBeArray();

        $resources->shouldContain('foo');
        $resources->shouldContain('bar');
        $resources->shouldContain('baz');
    }

    public function it_can_get_nested_resources(Piston $middleware)
    {
        /** @var Request $request */
        $request = (new Request())->withQueryParams(['include' => 'foo.bing,bar,baz']);

        $result = $this->process(new Payload($middleware->getWrappedObject(), $request, new ApiResponse()))->getRequest();

        $result->shouldHaveType(Request::class);

        $resources = $result->getIncludedResources();
        $resources->shouldBeArray();

        $resources->shouldContain(['foo',  'bing']);
        $resources->shouldContain('bar');
        $resources->shouldContain('baz');
    }

    public function it_does_not_ensure_get_only_request_when_no_resources_included(Piston $middleware)
    {
        $request = (new Request())->withMethod('POST');

        $result = $this->process(new Payload($middleware->getWrappedObject(), $request, new ApiResponse()))->getRequest();

        $result->shouldHaveType(Request::class);
    }

    public function it_ensures_get_only_request_when_resources_are_included(Piston $middleware)
    {
        $request = (new Request())->withMethod('POST')->withQueryParams(['include' => 'foo']);

        $payload = new Payload($middleware->getWrappedObject(), $request, new ApiResponse());

        $this->shouldThrow(BadRequestException::class)->duringProcess($payload);
    }
}
