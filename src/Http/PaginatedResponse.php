<?php

namespace Refinery29\Piston\Http;

trait PaginatedResponse
{
    protected $pagination;
    protected $offset;
    protected $limit;

    public function setPaginationCursors(array $cursor)
    {
        $this->pagination = $cursor;
    }

    public function getPaginationCursors()
    {
        return $this->pagination;
    }

    public function setOffsetLimit($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function getOffsetLimit()
    {
        return [$this->offset, $this->limit];
    }
}
