<?php

namespace spec\Refinery29\Piston\Request;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Request\Request');
    }

    function it_can_set_requested_fields()
    {
        $req_fields = ['yolo'=>'gogo'];
        $this->setRequestedFields($req_fields);

        $this->getRequestedFields()->shouldReturn($req_fields);
        $this->requestsSpecificFields()->shouldReturn(true);
    }
}
