<?php

namespace Refinery29\Piston\Http;

trait PaginatedResponse
{
    protected $pagination;

    public function setPaginationCursors(array $cursor)
    {
        $this->pagination = $cursor;
    }

    public function getPaginationCursors()
    {
        return $this->pagination;
    }
}
