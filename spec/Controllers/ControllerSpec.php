<?php

namespace spec\Refinery29\Piston\Controllers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Controllers\Controller');
    }

    public function it_can_redirect()
    {
        $this->redirect('123/something')->shouldHaveType('Symfony\Component\HttpFoundation\RedirectResponse');
    }

    public function it_can_404()
    {
        $response = $this->notFound();
        $response->shouldHaveType('Symfony\Component\HttpFoundation\Response');
        $response->getStatusCode()->shouldReturn(404);
    }
}
