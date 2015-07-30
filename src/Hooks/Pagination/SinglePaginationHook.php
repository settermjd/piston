<?php namespace Refinery29\Piston\Hooks;

use League\Route\Http\Exception\BadRequestException;

trait SinglePaginationHook
{
    public function ensureNotPreviousPaginated($request)
    {
        if ($request->isPaginated()) {
            throw new BadRequestException('You may not request two methods of pagination');
        }
    }
}
