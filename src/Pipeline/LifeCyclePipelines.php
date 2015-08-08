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
    protected $pre_stages = null;

    /**
     * @var PipelineBuilder
     */
    protected $post_stages = null;

    /**
     * @param $stage
     *
     * @return $this
     */
    public function addPre(StageInterface $stage)
    {
        $this->bootstrapPipelines();
        $this->pre_stages->add($stage);

        return $this;
    }

    /**
     * @param StageInterface $stage
     *
     * @return $this
     */
    public function addPost(StageInterface $stage)
    {
        $this->bootstrapPipelines();
        $this->post_stages->add($stage);

        return $this;
    }

    protected function bootstrapPipelines()
    {
        if ($this->pre_stages == null) {
            $this->pre_stages = new PipelineBuilder();
        }

        if ($this->post_stages == null) {
            $this->post_stages = new PipelineBuilder();
        }
    }

    /**
     * @return PipeLine
     */
    public function getPrePipeline()
    {
        $this->bootstrapPipelines();

        return $this->pre_stages->build();
    }

    /**
     * @return Pipeline
     */
    public function getPostPipeline()
    {
        $this->bootstrapPipelines();

        return $this->post_stages->build();
    }
}
