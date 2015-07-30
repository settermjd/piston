<?php namespace Refinery29\Piston\Http;

use Symfony\Component\HttpFoundation\Request as SRequest;

/**
 * Class Request
 * @package Refinery29\Piston\Request
 */
class Request extends SRequest
{
    /**
     * @var null
     */
    protected $pagination_cursor = null;

    protected $pagination_type = null;

    /**
     * @var null
     */
    protected $requested_fields = null;

    /**
     * @var null
     */
    protected $included_resources = null;

    /** @var  var string */
    protected $before_cursor;

    /** @var  var string */
    protected $after_cursor;


    /**
     * @return string
     */
    public function getPaginationCursor()
    {
        return $this->before_cursor ? $this->before_cursor : $this->after_cursor;
    }

    /**
     * @return null
     */
    public function getRequestedFields()
    {
        return $this->requested_fields;
    }

    /**
     * @param null $requested_fields
     */
    public function setRequestedFields($requested_fields)
    {
        $this->requested_fields = $requested_fields;
    }

    /**
     * @return null
     */
    public function getIncludedResources()
    {
        return $this->included_resources;
    }

    /**
     * @param null $included_resources
     */
    public function setIncludedResources($included_resources)
    {
        $this->included_resources = $included_resources;
    }

    /**
     * @return bool
     */
    public function isPaginated()
    {
        return $this->pagination_type !== null;
    }

    /**
     * @return bool
     */
    public function hasIncludedResources()
    {
        return !is_null($this->included_resources);
    }

    /**
     * @return bool
     */
    public function hasRequestedFields()
    {
        return !is_null($this->requested_fields);
    }

    /**
     * @param string $after_cursor
     */
    public function setAfterCursor($after_cursor)
    {
        $this->after_cursor = $after_cursor;
    }

    /**
     * @param string $before_cursor
     */
    public function setBeforeCursor($before_cursor)
    {
        $this->before_cursor = $before_cursor;
        $this->pagination_type = 'cursor';
    }

    public function setOffsetLimit($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;

        $this->pagination_type = 'offset_limit';
    }

    public function setPage($page)
    {
        $this->page = $page;

        $this->pagination_type = 'page';
    }

    public function getPaginationType()
    {
        return $this->pagination_type;
    }
}
