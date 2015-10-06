<?php

namespace spec\Refinery29\Piston\Middleware\Request;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Middleware\Request\RequestedFields;
use Refinery29\Piston\Middleware\Subject;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class RequestedFieldsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(RequestedFields::class);
    }

    public function it_will_get_requested_fields()
    {
        $request = Request::createFromUri('123/yolo?fields=model,blog,entry');
        $result = $this->process(new Subject($request, $request, new Response()));
        $result->getSubject();

        $resources = $result->getRequestedFields();
        $resources->shouldBeArray();

        $resources->shouldContain('model');
    }
}
