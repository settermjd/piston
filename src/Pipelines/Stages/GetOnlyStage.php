<?php namespace Refinery29\Piston\Pipelines\Stages;

use League\Route\Http\Exception\BadRequestException;

trait GetOnlyStage
{
    public function ensureGetOnlyRequest($request)
    {
        if ($request->getMethod() !== "GET") {
            throw new BadRequestException('Query parameter is only allowed on GET requests');
        }
    }
}
