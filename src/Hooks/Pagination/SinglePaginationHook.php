<?php namespace Refinery29\Piston\Hooks\Pagination;

use League\Route\Http\Exception\BadRequestException;

trait SinglePaginationHook
{
    public function ensureNotPreviouslyPaginated($request)
    {
        if ($request->isPaginated()) {
            throw new BadRequestException('You may not request two methods of pagination');
        }
    }
}
