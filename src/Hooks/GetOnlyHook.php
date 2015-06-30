<?php namespace Refinery29\Piston\Hooks;


use League\Route\Http\Exception\BadRequestException;

abstract class GetOnlyHook
{
    public function ensureGetOnlyRequest($request)
    {
        if ($request->getMethod() !== "GET") {
            throw new BadRequestException('Query parameter is only allowed on GET requests');
        }

    }

}