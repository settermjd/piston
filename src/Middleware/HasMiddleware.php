<?php

namespace Refinery29\Piston\Middleware;

use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

trait HasMiddleware
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
    public function addMiddleware(StageInterface $stage)
    {
        $this->getPipeline();
        $this->pipeline->add($stage);

        return $this;
    }

    /**
     * Instaniate a new pipeline if one doesn't exist.
     */
    protected function getPipeline()
    {
        if ($this->pipeline == null) {
            $this->pipeline = new PipelineBuilder();
        }
    }

    /**
     * @return PipeLine
     */
    public function buildPipeline()
    {
        $this->getPipeline();

        return $this->pipeline->build();
    }
}
