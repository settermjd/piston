<?php namespace Refinery29\Piston\Http\Pipeline;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\Pipeline;
use Refinery29\Piston\Pipeline\Stage\IncludedResource;
use Refinery29\Piston\Pipeline\Stage\Pagination\CursorBasedPagination;
use Refinery29\Piston\Pipeline\Stage\Pagination\OffsetLimitPagination;
use Refinery29\Piston\Pipeline\Stage\RequestedFields;

class RequestPipeline
{
    /**
     * @var Pipeline
     */
    protected $pipeline;

    public function __construct(PipelineBuilder $builder = null)
    {
        $builder = $builder ?:  new PipelineBuilder();

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
}
