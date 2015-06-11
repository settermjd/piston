<?php

namespace spec\Refinery29\Piston\Hooks;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValidatePaginationHookSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Hooks\ValidatePaginationHook');
    }
}
