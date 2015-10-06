<?php

namespace Refinery29\Piston\Middleware\Pagination;

use League\Pipeline\StageInterface;
use League\Route\Http\Exception\BadRequestException;
use Refinery29\Piston\Request;
use Refinery29\Piston\Middleware\GetOnlyStage;

class CursorBasedPagination implements StageInterface
{
    use SinglePagination;
    use GetOnlyStage;

    /**
     * @param Request $request
     *
     * @throws BadRequestException
     *
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
                return $request;
            }

            if ($after) {
                $request->setAfterCursor($after);
                return $request;
            }
        }
    }
}
