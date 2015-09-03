<?php

namespace Refinery29\Piston\Request\Filters;

use League\Route\Http\Exception\BadRequestException;
use Refinery29\Piston\Request\Request;

class Pagination implements Filter
{
    /**
     * @param Request $request
     *
     * @return Request
     */
    public static function apply(Request $request)
    {
        $cursor = $request->get('cursor');

        if ($cursor && $request->getMethod() !== 'GET') {
            throw new BadRequestException('Pagination is only allowed on GET requests');
        }

        $request->setPaginationCursor($cursor);

        return $request;
    }
}
