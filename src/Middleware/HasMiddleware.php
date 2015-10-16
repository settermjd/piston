<?php

namespace Refinery29\Piston\Middleware;

use League\Pipeline\StageInterface;

interface HasMiddleware
{
    /**
     * @param StageInterface $stage
     *
     * @return HasMiddleware
     */
    public function addMiddleware(StageInterface $stage);
}
