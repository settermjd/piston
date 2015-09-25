<?php

namespace Refinery29\Piston\Pipeline;

use League\Pipeline\Pipeline;

interface HasPipeline
{
    /**
     * @return Pipeline
     */
    public function getPipeline();
}
