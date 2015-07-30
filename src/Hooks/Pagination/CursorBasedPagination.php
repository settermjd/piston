<?php namespace Refinery29\Piston\Hooks;

use League\Pipeline\StageInterface;
use League\Route\Http\Exception\BadRequestException;
use Refinery29\Piston\Http\Request;

class CursorBasedPagination extends PaginationHook
{
    use GetOnlyHook;
    use SinglePaginationHook;

    /**
     * @param Request $request
     * @throws BadRequestException
     * @return Request
     */
    public function process($request)
    {
        parent::process($request);

        $before = $request->get('before');
        $after = $request->get('after');

        if ($before && $after) {
            throw new BadRequestException('You may not specify both before and after');
        }

        if ($before || $after) {
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
