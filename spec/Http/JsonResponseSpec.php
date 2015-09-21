<?php

namespace spec\Refinery29\Piston\Http;

use PhpSpec\ObjectBehavior;
use Refinery29\ApiOutput\ResponseBody;
use Refinery29\Piston\Http\JsonResponse;

class JsonResponseSpec extends ObjectBehavior
{
    public function let(\Symfony\Component\HttpFoundation\JsonResponse $resp, ResponseBody $body)
    {
        $this->beConstructedWith(\Symfony\Component\HttpFoundation\JsonResponse::create(), $body);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(JsonResponse::class);
    }
}
