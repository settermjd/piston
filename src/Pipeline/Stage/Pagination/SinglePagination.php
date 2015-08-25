<?php

namespace Refinery29\Piston\Pipeline\Stage\Pagination;

use League\Route\Http\Exception\BadRequestException;
use Refinery29\Piston\Http\Request;

trait SinglePagination
{
    public function ensureNotPreviouslyPaginated(Request $request)
    {
        if ($request->isPaginated()) {
            throw new BadRequestException('You may not request two methods of pagination');
        }
    }
}
