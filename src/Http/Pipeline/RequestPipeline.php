<?php

namespace Refinery29\Piston\Http\Pipeline;

use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Pipeline\Stage;

class RequestPipeline
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
     * @return Request
     */
    public function process(Request $payload)
    {
        $this->builder
            ->add(new Stage\IncludedResource())
            ->add(new Stage\RequestedFields());

        if ($payload->isPaginated()){
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
       return $this->builder->add(new Stage\Pagination\OffsetLimitPagination())
            ->add(new Stage\Pagination\CursorBasedPagination());
    }
}
