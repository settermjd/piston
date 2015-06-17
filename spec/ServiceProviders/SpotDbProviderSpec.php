<?php

namespace spec\Refinery29\Piston\ServiceProviders;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SpotDbProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\ServiceProviders\SpotDbProvider');
    }

    function it_requires_db_credentials()
    {
        $_ENV = [];
        $this->shouldThrow('\Exception')->during('register');
    }
}
