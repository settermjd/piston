<?php

namespace spec\Refinery29\Piston\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\Request;

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
        $this->hasRequestedFields()->shouldReturn(true);
    }

    public function it_can_set_included_resources()
    {
        $included_resources = ['monica', 'chandler'];
        $this->setIncludedResources($included_resources);

        $this->getIncludedResources()->shouldReturn($included_resources);
        $this->hasIncludedResources()->shouldReturn(true);
    }

    public function it_can_set_a_before_cursor()
    {
        $pagination_cursor = rand();
        $this->setBeforeCursor($pagination_cursor);

        $this->getPaginationCursor()->shouldReturn($pagination_cursor);
        $this->isPaginated()->shouldReturn(true);
    }

    public function it_can_set_an_after_cursor()
    {
        $pagination_cursor = rand();
        $this->setAfterCursor($pagination_cursor);

        $this->getPaginationCursor()->shouldReturn($pagination_cursor);
        $this->isPaginated()->shouldReturn(true);
    }
}
