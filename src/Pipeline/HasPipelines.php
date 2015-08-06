<?php namespace Refinery29\Piston\Pipeline;

interface HasPipelines
{
    public function getPrePipeline();

    public function getPostPipeline();
}
