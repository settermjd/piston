<?php

namespace Refinery29\Piston\Pipeline;

use League\Pipeline\Pipeline;

interface HasPipelines
{
    /**
     * @return Pipeline
     */
    public function getPrePipeline();

    /**
     * @return Pipeline
     */
    public function getPostPipeline();
}
