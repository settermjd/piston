<?php namespace Refinery29\Piston\Pipelines;

interface HasPipelines
{
    public function getPrePipeline();

    public function getPostPipeline();
}
