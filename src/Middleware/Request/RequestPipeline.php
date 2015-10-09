<?php

namespace Refinery29\Piston\Middleware\Request;

use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Middleware\Request\Pagination\CursorBasedPagination;
use Refinery29\Piston\Middleware\Request\Pagination\OffsetLimitPagination;

class RequestPipeline implements StageInterface
{
    /**
     * @var Pipeline
     */
    protected $pipeline;

    /**
     * @var PipelineBuilder
     */
    protected $builder;

    /**
     * @param PipelineBuilder $builder
     */
    public function __construct(PipelineBuilder $builder = null)
    {
        $this->builder = $builder ?:  new PipelineBuilder();
    }

    /**
     * @param $payload
     *
     * @return Payload
     */
    public function process($payload)
    {
        $this->builder
            ->add(new IncludedResource())
            ->add(new RequestedFields())
            ->add(new OffsetLimitPagination())
            ->add(new CursorBasedPagination());

        $this->pipeline = $this->builder->build();

        return $this->pipeline->process($payload);
    }
}
