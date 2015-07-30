<?php namespace Refinery29\Piston\Hooks;

class OffsetLimitPagination extends PaginationHook
{
    use GetOnlyHook;
    use SinglePaginationHook;

    protected $default_offset = 0;

    protected $default_limit = 0;

    public function process($request)
    {
        parent::process($request);

        $before = $request->get('offset');
        $after = $request->get('limit');

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
