<?php

namespace Refinery29\Piston\Http\Pipeline;

use League\Pipeline;
use Refinery29\Piston\Pipeline\Stage\Pagination\PaginationOutput;

class ResponsePipeline
{
    /**
     * @var Pipeline\Pipeline
     */
    protected $pipeline;

    public function __construct(Pipeline\PipelineBuilder $builder = null)
    {
        $builder = $builder ?:  new Pipeline\PipelineBuilder();

        $this->pipeline = $builder->add(new PaginationOutput())->build();
    }

    public function process($payload)
    {
        return $this->pipeline->process($payload);
    }
}
