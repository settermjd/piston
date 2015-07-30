<?php namespace Refinery29\Piston\Hooks;

abstract class PaginationHook implements StageInterface
{
    public function process($request)
    {
        $this->ensureGetOnlyRequest($request);
        $this->ensureNotPreviousPaginated($request);
    }
}
