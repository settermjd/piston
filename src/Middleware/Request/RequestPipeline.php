<?php

namespace Refinery29\Piston\Middleware\Request;

use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Middleware;

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
     * @return Request
     */
    public function process($payload)
    {
        $this->builder
            ->add(new Middleware\Request\IncludedResource())
            ->add(new Middleware\Request\RequestedFields());

        if ($payload->getSubject()->isPaginated()) {
            $this->addPagination();
        }

        $this->pipeline = $this->builder->build();

        return $this->pipeline->process($payload);
    }

    /**
     * @return PipelineBuilder
     */
    private function addPagination()
    {
        return $this->builder->add(new Middleware\Pagination\OffsetLimitPagination())
            ->add(new Middleware\Pagination\CursorBasedPagination());
    }
}
