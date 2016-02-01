<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace spec\Refinery29\Piston;

use PhpSpec\ObjectBehavior;
use Refinery29\Piston\CookieJar;

class CookieJarSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CookieJar::class);
    }

    public function it_can_set_and_get_a_value()
    {
        $this->set('tom', 'jones');
        $this->get('tom')->shouldReturn('jones');
    }

    public function it_can_be_constructed_with_array()
    {
        $this->beConstructedWith(['tom' => 'jones']);
        $this->get('tom')->shouldReturn('jones');
    }

    public function it_returns_null_if_cookie_not_found()
    {
        $this->get('tom')->shouldReturn(null);
    }

    public function it_can_get_all()
    {
        $this->set('tom', 'riddle');
        $this->set('charlie', 'daniels');
        $this->set('cookie', 'monster');

        $this->all()->shouldReturn(['tom' => 'riddle', 'charlie' => 'daniels', 'cookie' => 'monster']);
    }

    public function it_requires_an_associative_array()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during__construct(['yellow', 'blue', 'green']);
    }

    public function it_can_clear()
    {
        $this->beConstructedWith(['tom' => 'riddle', 'weird' => 'al', 'charlie' => 'daniels']);
        $this->all()->shouldHaveCount(3);

        $this->clear('weird');

        $this->all()->shouldHaveCount(2);

        $this->get('weird')->shouldBeNull();
    }

    public function it_can_clear_all()
    {
        $this->beConstructedWith(['tom' => 'riddle', 'weird' => 'al', 'charlie' => 'daniels']);
        $this->all()->shouldHaveCount(3);

        $this->clearAll();

        $this->all()->shouldHaveCount(0);
    }
}
