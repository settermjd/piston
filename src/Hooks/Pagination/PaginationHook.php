<?php namespace Refinery29\Piston\Hooks\Pagination;

use League\Pipeline\StageInterface;
use Refinery29\Piston\Hooks\GetOnlyHook;

abstract class PaginationHook implements StageInterface
{
    use GetOnlyHook;
    use SinglePaginationHook;

    public function process($request)
    {
        $this->ensureGetOnlyRequest($request);
        $this->ensureNotPreviousPaginated($request);
    }
}
