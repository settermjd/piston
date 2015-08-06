<?php namespace Refinery29\Piston\Pipelines\Stages\Pagination;

use League\Route\Http\Exception\BadRequestException;

trait SinglePagination
{
    public function ensureNotPreviouslyPaginated($request)
    {
        if ($request->isPaginated()) {
            throw new BadRequestException('You may not request two methods of pagination');
        }
    }
}
