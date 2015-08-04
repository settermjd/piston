<?php namespace Refinery29\Piston\Hooks\Pagination;

use League\Route\Http\Exception\BadRequestException;
use Refinery29\Piston\Http\Request;

class CursorBasedPagination
{
    /**
     * @param Request $request
     * @throws BadRequestException
     * @return Request
     */
    public function process($request)
    {
        $this->ensureNotPreviouslyPaginated($request);

        $before = $request->get('before');
        $after = $request->get('after');

        if ($before && $after) {
            throw new BadRequestException('You may not specify both before and after');
        }

        if ($before || $after) {
            $this->ensureGetOnlyRequest($request);

            if ($before) {
                $request->setBeforeCursor($before);
            }

            if ($after) {
                $request->setAfterCursor($after);
            }
        }

        return $request;
    }
}
