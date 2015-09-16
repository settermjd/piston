<?php

namespace Refinery29\Piston\Http;

use Refinery29\ApiOutput\Resource\Error\Error;
use Refinery29\ApiOutput\ResponseBody;

class JsonResponse extends \Symfony\Component\HttpFoundation\JsonResponse
{
    /**
     * @var
     */
    protected $offset;
    /**
     * @var
     */
    protected $limit;
    /**
     * @var
     */
    protected $previous;
    /**
     * @var
     */
    protected $next;

    /**
     * @var ResponseBody
     */
    private $responseBody;

    /**
     * @param ResponseBody $responseBody
     */
    public function __construct(ResponseBody $responseBody = null)
    {
        $this->responseBody = $responseBody;
    }

    /**
     * @param ResponseBody $responseBody
     */
    public function setResponseBody(ResponseBody $responseBody)
    {
        $this->responseBody = $responseBody;
    }

    /**
     * @param $previous
     * @param $next
     */
    public function setPaginationCursors($previous, $next)
    {
        $this->previous = $previous;
        $this->next = $next;
    }

    /**
     * @return array
     */
    public function getPaginationCursors()
    {
        return ['prev' => $this->previous, 'next' => $this->next];
    }

    /**
     * @param int $offset
     * @param int $limit
     */
    public function setOffsetLimit($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * @return array
     */
    public function getOffsetLimit()
    {
        return ['offset' => $this->offset, 'limit' => $this->limit];
    }

    /**
     * @param Error $error
     */
    public function addError(Error $error)
    {
        $this->responseBody->addMember($error->getSerializer());
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $output = $this->responseBody->getOutput();

        $this->setContent($output);

        parent::send();
    }
}
