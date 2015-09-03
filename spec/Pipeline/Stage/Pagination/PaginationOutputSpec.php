<?php

namespace spec\Refinery29\Piston\Pipeline\Stage\Pagination;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\JsonResponse;

class PaginationOutputSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Pipeline\Stage\Pagination\PaginationOutput');
    }

    function it_returns_response(JsonResponse $response)
    {
        $this->process($response)->shouldReturn($response);
    }

    function it_builds_cursor_based_output(JsonResponse $response)
    {
        $output = ', "pagination" : {"prev":"abc","next":"def"}';

        $response->getPaginationCursors()->willReturn(['prev' => 'abc', 'next' => 'def']);
        $response->getContent()->shouldBeCalled();
        $response->getOffsetLimit()->willReturn(null);

        $response->setContent($output)->willReturn(null);

        $this->process($response)->getContent()->shouldContainString($output);
    }

    function it_builds_offset_limit_based_output(JsonResponse $response)
    {
        $output = ', "pagination" : {"offset":"10","limit":"20"}';

        $response->getOffsetLimit()->willReturn(['offset' => '10', 'limit' => '20']);
        $response->getContent()->shouldBeCalled();
        $response->getPaginationCursors()->willReturn(null);
        $response->setContent($output)->willReturn(null);

        $this->process($response)->getContent()->shouldContainString($output);
    }

    public function getMatchers()
    {
        return [
            'containString' => function ($subject, $key) {
                return strpos($subject, $key) !== 0;
            }
        ];
    }
}
