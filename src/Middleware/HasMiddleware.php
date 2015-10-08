<?php

namespace Refinery29\Piston\Middleware;

use League\Pipeline\Pipeline;

interface HasMiddleware
{
    /**
     * @return Pipeline
     */
    public function buildPipeline();
}
