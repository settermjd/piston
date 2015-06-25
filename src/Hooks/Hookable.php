<?php namespace Refinery29\Piston\Hooks;

use League\Pipeline\StageInterface;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;

/**
 * Class Hookable
 * @package Refinery29\Piston\Hooks
 */
trait Hookable
{
    /**
     * @var PipelineBuilder
     */
    protected $pre_hooks = null;

    /**
     * @var PipelineBuilder
     */
    protected $post_hooks = null;

    /**
     * @param $hook
     * @return $this
     */
    public function addPreHook(StageInterface $hook)
    {
        $this->bootstrapHooks();
        $this->pre_hooks->add($hook);

        return $this;
    }

    protected function bootstrapHooks()
    {
        if ($this->pre_hooks == null) {
            $this->pre_hooks = new PipelineBuilder();
        }

        if ($this->post_hooks == null) {
            $this->post_hooks = new PipelineBuilder();
        }
    }

    /**
     * @param OperationInterface $hook
     * @return $this
     */
    public function addPostHook(StageInterface $hook)
    {
        $this->bootstrapHooks();
        $this->post_hooks->add($hook);

        return $this;
    }

    /**
     * @return PipeLine
     */
    public function getPreHooks()
    {
        $this->bootstrapHooks();

        return $this->pre_hooks->build();
    }

    /**
     * @return Pipeline
     */
    public function getPostHooks()
    {
        $this->bootstrapHooks();

        return $this->post_hooks->build();
    }
}
