<?php namespace Refinery29\Piston\Hooks;

use League\Pipeline\OperationInterface;
use Refinery29\Piston\Request;

class Pagination extends GetOnlyHook implements OperationInterface
{
    /**
     * @param Request $request
     * @return Request
     */
    public function process($request)
    {
        $before = $request->get('before');
        $after = $request->get('after');

        if (($before || $after)) {
            $this->ensureGetOnlyRequest($request);
        }

        if ($before || $after) {
            $request->setPaginationCursor(['before' => $before, 'after' => $after]);
        }

        return $request;
    }
}
