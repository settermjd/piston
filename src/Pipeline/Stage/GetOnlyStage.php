<?php

namespace Refinery29\Piston\Pipeline\Stage;

use League\Route\Http\Exception\BadRequestException;
use Refinery29\Piston\Http\Request;

trait GetOnlyStage
{
    public function ensureGetOnlyRequest(Request $request)
    {
        if ($request->getMethod() !== 'GET') {
            throw new BadRequestException('Query parameter is only allowed on GET requests');
        }
    }
}
