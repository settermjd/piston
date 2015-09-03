<?php

namespace Refinery29\Piston\Http;

trait PaginatedResponse
{
    protected $offset;
    protected $limit;
    protected $previous;
    protected $next;

    public function setPaginationCursors($previous, $next)
    {
        $this->previous = $previous;
        $this->next = $next;
    }

    public function getPaginationCursors()
    {
        return [$this->previous, $this->next];
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
