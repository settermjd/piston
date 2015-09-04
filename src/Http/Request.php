<?php

namespace Refinery29\Piston\Http;

use Symfony\Component\HttpFoundation\Request as SRequest;

/**
 * Class Request
 */
class Request extends SRequest
{
    const OFFSET_LIMIT_PAGINATION = 'offset_limi';
    const CURSOR_PAGINATION = 'cursor';

    /**
     * @var null
     */
    protected $pagination_cursor = null;

    /**
     * @var null
     */
    protected $pagination_type = null;

    /**
     * @var null
     */
    protected $requested_fields = null;

    /**
     * @var null
     */
    protected $included_resources = null;

    /**
     * @var string
     */
    protected $before_cursor;

    /**
     * @var string
     */
    protected $after_cursor;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $limit;

    /**
     * @return string
     */
    public function getPaginationCursor()
    {
        return $this->before_cursor ? $this->before_cursor : $this->after_cursor;
    }

    /**
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
        return $this->included_resources !== null;
    }

    /**
     * @return bool
     */
    public function hasRequestedFields()
    {
        return $this->requested_fields !== null;
    }

    /**
     * @param string $after_cursor
     */
    public function setAfterCursor($after_cursor)
    {
        $this->after_cursor = $after_cursor;
        $this->pagination_type = self::CURSOR_PAGINATION;
    }

    /**
     * @param string $before_cursor
     */
    public function setBeforeCursor($before_cursor)
    {
        $this->before_cursor = $before_cursor;
        $this->pagination_type = self::CURSOR_PAGINATION;
    }

    /**
     * @param string $offset
     * @param string $limit
     */
    public function setOffsetLimit($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->pagination_type = self::OFFSET_LIMIT_PAGINATION;
    }

    /**
     * @return array
     */
    public function getOffsetLimit()
    {
        return ['offset' => $this->offset, 'limit' => $this->limit];
    }

    /** @return string */
    public function getPaginationType()
    {
        return $this->pagination_type;
    }
}
