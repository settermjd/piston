<?php

namespace spec\Refinery29\Piston\Middleware\Request;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Middleware\Subject;
use Refinery29\Piston\Request;
use Refinery29\Piston\Middleware\Request\IncludedResource;
use Refinery29\Piston\Response;

class IncludedResourceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(IncludedResource::class);
    }

    public function it_will_get_included_resources()
    {
        /** @var Request $request */
        $request = (new Request())->withQueryParams(['include' => 'foo,bar,baz']);
        $result = $this->process(new Subject($request, $request, new Response()));

        $result->shouldHaveType(Subject::class);
        $result->getSubject()->shouldHaveType(Request::class);

        $resources = $result->getSubject()->getIncludedResources();
        $resources->shouldBeArray();

        $resources->shouldContain('foo');
        $resources->shouldContain('bar');
        $resources->shouldContain('baz');
    }

    public function it_can_get_nested_resources()
    {
        /** @var Request $request */
        $request = (new Request())->withQueryParams(['include'=>'foo.bing,bar,baz']);

        $result = $this->process(new Subject($request, $request, new Response()))->getSubject();

        $result->shouldHaveType(Request::class);

        $resources = $result->getIncludedResources();
        $resources->shouldBeArray();

        $resources->shouldContain(['foo',  'bing']);
        $resources->shouldContain('bar');
        $resources->shouldContain('baz');
    }
}
