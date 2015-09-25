<?php

namespace Refinery29\Piston\Pipeline;

use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

/**
 * Class Hookable
 */
trait LifeCyclePipelines
{
    /**
     * @var PipelineBuilder
     */
    protected $pipeline = null;

    /**
     * @param $stage
     *
     * @return $this
     */
    public function addMiddlewareStage(StageInterface $stage)
    {
        $this->bootstrapPipelines();
        $this->pipeline->add($stage);

        return $this;
    }

    /**
     * Instaniate a new pipeline if one doesn't exist.
     */
    protected function bootstrapPipelines()
    {
        if ($this->pipeline == null) {
            $this->pipeline = new PipelineBuilder();
        }
    }

    /**
     * @return PipeLine
     */
    public function getPipeline()
    {
        $this->bootstrapPipelines();

        return $this->pipeline->build();
    }
}
