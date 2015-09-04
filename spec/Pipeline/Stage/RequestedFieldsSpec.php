<?php

namespace spec\Refinery29\Piston\Pipeline\Stage;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Pipeline\Stage\RequestedFields;

class RequestedFieldsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(RequestedFields::class);
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
