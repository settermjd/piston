<?php namespace Refinery29\Piston\Hooks\Pagination;

use use League\Route\Http\Exception\BadRequestException;;

class OffsetLimitPagination extends PaginationHook
{
    protected $default_offset = 0;

    protected $default_limit = 0;

    public function process($request)
    {
        parent::process($request);

        //todo Implement

        return $request;
    }
}
