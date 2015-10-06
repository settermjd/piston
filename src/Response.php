<?php

namespace Refinery29\Piston;

use Refinery29\ApiOutput\Resource\Error\ErrorCollection;
use Refinery29\ApiOutput\Resource\Pagination\Pagination;
use Refinery29\ApiOutput\Resource\Result;
use Refinery29\ApiOutput\ResponseBody;
use Zend\Diactoros\Response as DiactorosResponse;

class Response extends DiactorosResponse
{
    /**
     * @var ResponseBody
     */
    private $responseBody;
    /**
     * @var DiactorosResponse
     */
    private $response;

    /**
     * @param ResponseBody $responseBody
     */
    public function __construct(ResponseBody $responseBody = null)
    {
        parent::__construct();
        $this->responseBody = $responseBody ?: new ResponseBody();

        $this->withHeader('Content-Type', 'application/json');
    }

    public function setPagination(Pagination $pagination)
    {
        $this->responseBody->addMember($pagination->getSerializer());
    }

    /**
     * @param ErrorCollection $error
     */
    public function setErrors(ErrorCollection $error)
    {
        $this->responseBody->addMember($error->getSerializer());
    }

    public function setResult(Result $result)
    {
        $this->responseBody->addMember($result->getSerializer());
    }

    /**
     * @param int $code
     */
    public function setStatusCode($code)
    {
        $this->response = $this->withStatus($code);
    }

    /**
     * @return string
     */
    public function compileContent()
    {
        $output = $this->responseBody->getOutput();

        $this->getBody()->write($output);

        return $this->getBody();
    }
}
