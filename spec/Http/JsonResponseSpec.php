<?php

namespace spec\Refinery29\Piston\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\JsonResponse;

class JsonResponseSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(JsonResponse::class);
    }

    public function it_can_get_pagination_cursors()
    {
        $this->setPaginationCursors(123, 345);

        $this->getPaginationCursors()->shouldReturn(['prev' => 123, 'next' => 345]);
    }
}
