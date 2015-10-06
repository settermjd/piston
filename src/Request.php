<?php

namespace Refinery29\Piston;

use Refinery29\Piston\Middleware\HasPipeline;
use Zend\Diactoros\ServerRequest;
use Refinery29\Piston\Middleware\HasMiddleware;

/**
 * Class Request
 */
class Request extends ServerRequest implements HasPipeline
{
    use HasMiddleware;

    const OFFSET_LIMIT_PAGINATION = 'offset_limit';
    const CURSOR_PAGINATION = 'cursor';

    /**
     * @var null
     */
    protected $paginationCursor = null;

    /**
     * @var null
     */
    protected $paginationType = null;

    /**
     * @var null
     */
    protected $requestedFields = null;

    /**
     * @var null
     */
    protected $includedResources = null;

    /**
     * @var string
     */
    protected $beforeCursor;

    /**
     * @var string
     */
    protected $afterCursor;

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
        return $this->beforeCursor ? $this->beforeCursor : $this->afterCursor;
    }

    /**
     */
    public function getRequestedFields()
    {
        return $this->requestedFields;
    }

    /**
     * @param null $requestedFields
     */
    public function setRequestedFields($requestedFields)
    {
        $this->requestedFields = $requestedFields;
    }

    /**
     */
    public function getIncludedResources()
    {
        return $this->includedResources;
    }

    /**
     * @param null $included_resources
     */
    public function setIncludedResources($included_resources)
    {
        $this->includedResources = $included_resources;
    }

    /**
     * @return bool
     */
    public function isPaginated()
    {
        return $this->paginationType !== null;
    }

    /**
     * @return bool
     */
    public function hasIncludedResources()
    {
        return $this->includedResources !== null;
    }

    /**
     * @return bool
     */
    public function hasRequestedFields()
    {
        return $this->requestedFields !== null;
    }

    /**
     * @param string $after_cursor
     */
    public function setAfterCursor($after_cursor)
    {
        $this->afterCursor = $after_cursor;
        $this->paginationType = self::CURSOR_PAGINATION;
    }

    /**
     * @param string $before_cursor
     */
    public function setBeforeCursor($before_cursor)
    {
        $this->beforeCursor = $before_cursor;
        $this->paginationType = self::CURSOR_PAGINATION;
    }

    /**
     * @param string $offset
     * @param string $limit
     */
    public function setOffsetLimit($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->paginationType = self::OFFSET_LIMIT_PAGINATION;
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
        return $this->paginationType;
    }
}
