<?php

namespace spec\Refinery29\Piston;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\Request;

class RequestSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Request::class);
    }

    public function it_can_set_requested_fields()
    {
        $req_fields = ['yolo', 'gogo'];
        $this->setRequestedFields($req_fields);

        $this->getRequestedFields()->shouldReturn($req_fields);
    }

    public function it_can_set_included_resources()
    {
        $included_resources = ['monica', 'chandler'];
        $this->setIncludedResources($included_resources);

        $this->getIncludedResources()->shouldReturn($included_resources);
    }

    public function it_can_set_a_before_cursor()
    {
        $pagination_cursor = rand();
        $this->setBeforeCursor($pagination_cursor);

        $this->getPaginationCursor()->shouldReturn(['before' => $pagination_cursor]);
    }

    public function it_can_set_an_after_cursor()
    {
        $pagination_cursor = rand();
        $this->setAfterCursor($pagination_cursor);

        $this->getPaginationCursor()->shouldReturn(['after' => $pagination_cursor]);
    }

    public function it_can_set_offset_limit()
    {
        $this->setOffsetLimit(10, 10);
        $this->getOffsetLimit()->shouldReturn(["offset" => 10, "limit" => 10]);
    }

    public function it_returns_empty_array_when_no_offset_limit_is_set()
    {
        $this->getOffsetLimit()->shouldReturn([]);
    }
}
