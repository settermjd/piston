<?php

namespace spec\Refinery29\Piston\Hooks;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\Request;

class RequestedFieldsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Hooks\RequestedFields');
    }

    public function it_will_get_included_resources()
    {
        $request = Request::create('123/yolo?fields=model,blog,entry');
        $result = $this->process($request);

        $resources = $result->getRequestedFields();
        $resources->shouldBeArray();

        $resources->shouldContain('model');
    }
}
