<?php namespace spec\Refinery29\Piston\Hooks;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\Request;

class IncludedResourceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Hooks\IncludedResource');
    }

    public function it_will_get_included_resources()
    {
        $request = Request::create('123/yolo?include=foo,bar,baz');
        $result = $this->process($request);

        $result->shouldHaveType(Request::class);

        $resources = $result->getIncludedResources();
        $resources->shouldBeArray();

        $resources->shouldContain('foo');
    }

    public function it_can_get_nested_resources()
    {
        $request = Request::create('123/yolo?include=foo.bing,bar,baz');
        $result = $this->process($request);

        $result->shouldHaveType(Request::class);

        $resources = $result->getIncludedResources();
        $resources->shouldBeArray();

        $resources->shouldContain(array('foo',  'bing'));
    }
}
