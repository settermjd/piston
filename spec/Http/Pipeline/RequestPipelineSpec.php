<?php

namespace spec\Refinery29\Piston\Http\Pipeline;

use League\Pipeline\PipelineBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Refinery29\Piston\Http\Request;

class RequestPipelineSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Refinery29\Piston\Http\Pipeline\RequestPipeline');
    }

    public function it_can_be_processed(Request $request)
    {
        $this->process($request)->shouldReturn($request);
    }

    public function it_can_set_a_custom_builder(PipelineBuilder $builder)
    {
        $this->setBuilder($builder);

        $this->getBuilder()->shouldReturn($builder);
    }
}
