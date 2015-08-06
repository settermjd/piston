<?php namespace Refinery29\Piston\Http\Pipeline;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\Pipeline;
use Refinery29\Piston\Pipelines\Stages\IncludedResource;
use Refinery29\Piston\Pipelines\Stages\Pagination\CursorBasedPagination;
use Refinery29\Piston\Pipelines\Stages\Pagination\OffsetLimitPagination;
use Refinery29\Piston\Pipelines\Stages\RequestedFields;

class RequestPipeline
{
    /**
     * @var PipelineBuilder
     */
    protected $builder = null;

    /**
     * @var Pipeline
     */
    protected $pipeline;

    public function __construct()
    {
        $builder = $this->getBuilder();

        $this->pipeline = $builder->add(new CursorBasedPagination())
            ->add(new OffsetLimitPagination())
            ->add(new IncludedResource())
            ->add(new RequestedFields())
            ->build();
    }

    public function process($payload)
    {
       return $this->pipeline->process($payload);
    }

    public function setBuilder(PipelineBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getBuilder()
    {
        if ($this->builder == null) {
            $this->builder = new PipelineBuilder();
        }

        return $this->builder;
    }
}