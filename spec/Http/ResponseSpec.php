<?php

namespace spec\Refinery29\Piston\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Http\Response');
    }

    public function it_can_get_pagination_cursors()
    {
        $this->setPaginationCursors(['before' => 123, 'after' => 345]);

        $this->getPaginationCursors()->shouldReturn(['before' => 123, 'after' => 345]);
    }
}
