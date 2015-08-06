<?php namespace Refinery29\Piston\Router\Routes;

use Kayladnls\Seesaw\Route as SeesawRoute;
use Refinery29\Piston\Pipelines\HasPipelines;
use Refinery29\Piston\Pipelines\LifeCyclePipelines;

class Route extends SeesawRoute implements HasPipelines
{
    use LifeCyclePipelines;
}
