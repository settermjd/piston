<?php

namespace Refinery29\Piston\Middleware;

use League\Pipeline\Pipeline;

interface HasPipeline
{
    /**
     * @return Pipeline
     */
    public function buildPipeline();
}
