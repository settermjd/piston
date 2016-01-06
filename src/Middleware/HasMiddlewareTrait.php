<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Piston\Middleware;

use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

trait HasMiddlewareTrait
{
    /**
     * @var PipelineBuilder
     */
    protected $pipeline = null;

    private $stages = [];

    /**
     * @param $stage
     *
     * @return $this
     */
    public function addMiddleware(StageInterface $stage)
    {
        $this->pipeline = $this->getPipeline();
        $this->pipeline = $this->pipeline->pipe($stage);

        return $this;
    }

    /**
     * Instaniate a new pipeline if one doesn't exist.
     */
    public function getPipeline()
    {
        if (!$this->pipeline) {
            $this->pipeline = new ExceptionalPipeline();
        }

        return $this->pipeline;
    }
}
