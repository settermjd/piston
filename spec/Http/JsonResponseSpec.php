<?php

namespace spec\Refinery29\Piston\Http;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Http\JsonResponse;

class JsonResponseSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(JsonResponse::class);
    }

    public function it_can_get_prev_cursors()
    {
        $this->setPreviousCursor(123);

        $this->getPreviousCursor()->shouldReturn(123);
    }

    public function it_can_get_next_cursors()
    {
        $this->setNextCursor(456);
        $this->getNextCursor()->shouldReturn(456);
    }

    public function it_can_get_offset_limit()
    {
        $this->setOffsetLimit(50, 75);

        $this->getOffsetLimit()->shouldReturn(['offset' => 50, 'limit' => 75]);
    }
}
