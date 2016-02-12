<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Piston\Middleware\Request\Pagination;

use League\Route\Http\Exception\BadRequestException;
use Refinery29\Piston\Request;

trait SinglePagination
{
    /**
     * @param Request $request
     *
     * @throws BadRequestException
     */
    public function ensureNotPreviouslyPaginated(Request $request)
    {
        if ($request->isPaginated()) {
            throw new BadRequestException('You may not request two methods of pagination');
        }
    }
}
