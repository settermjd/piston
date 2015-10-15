<?php

namespace spec\Refinery29\Piston\Middleware\Request;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Middleware\Request\RequestedFields;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class RequestedFieldsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(RequestedFields::class);
    }

    public function it_will_get_requested_fields(Piston $middleware)
    {
        $request = (new Request())->withQueryParams(['fields' => 'one,two,three']);

        $subject = new Payload($middleware->getWrappedObject(), $request, new Response());

        $result = $this->process($subject);
        $result = $result->getRequest();

        $resources = $result->getRequestedFields();
        $resources->shouldBeArray();

        $resources->shouldContain('one');
        $resources->shouldContain('two');
        $resources->shouldContain('three');
    }
}
