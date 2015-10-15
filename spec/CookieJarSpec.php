<?php

namespace spec\Refinery29\Piston;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\CookieJar;

class CookieJarSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CookieJar::class);
    }

    function it_can_set_and_get_a_value()
    {
        $this->set('tom', 'jones');
        $this->get('tom')->shouldReturn('jones');
    }

    function it_can_be_constructed_with_array()
    {
        $this->beConstructedWith(['tom' => 'jones']);
        $this->get('tom')->shouldReturn('jones');
    }

    function it_returns_null_if_cookie_not_found()
    {
        $this->get('tom')->shouldReturn(null);
    }

    function it_can_get_all()
    {
        $this->set('tom', 'riddle');
        $this->set('charlie', 'daniels');
        $this->set('cookie', 'monster');

        $this->all()->shouldReturn(['tom'=>'riddle', 'charlie' => 'daniels', 'cookie' => 'monster']);
    }

    function it_requires_an_associative_array()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during__construct(['yellow', 'blue', 'green']);
    }

    function it_can_clear()
    {
        $this->beConstructedWith(['tom' => 'riddle', 'weird' => 'al', 'charlie' => 'daniels']);
        $this->all()->shouldHaveCount(3);

        $this->clear('weird');

        $this->all()->shouldHaveCount(2);

        $this->get('weird')->shouldBeNull();
    }

    function it_can_clear_all()
    {
        $this->beConstructedWith(['tom' => 'riddle', 'weird' => 'al', 'charlie' => 'daniels']);
        $this->all()->shouldHaveCount(3);

        $this->clearAll();

        $this->all()->shouldHaveCount(0);
    }
}
