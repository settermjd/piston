<?php

namespace Refinery29\Piston\Http;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Refinery29\ApiOutput\Resource\Error\ErrorCollection;
use Refinery29\ApiOutput\Resource\Pagination\Pagination;
use Refinery29\ApiOutput\Resource\Result;
use Refinery29\ApiOutput\ResponseBody;

class Response
{
    /**
     * @var ResponseBody
     */
    private $responseBody;
    /**
     * @var SymfonyResponse
     */
    private $response;

    /**
     * @param SymfonyResponse $response
     * @param ResponseBody    $responseBody
     */
    public function __construct(SymfonyResponse $response, ResponseBody $responseBody = null)
    {
        $this->responseBody = $responseBody;

        $this->response = $response;
        $this->response->headers->set('Content-Type', 'application/json');
    }

    /**
     * @param ResponseBody $responseBody
     */
    public function setResponseBody(ResponseBody $responseBody)
    {
        $this->responseBody = $responseBody;
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
     * @param $code
     */
    public function setStatusCode($code)
    {
        $this->response->setStatusCode($code);
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $output = $this->responseBody->getOutput();

        $this->response->setContent($output);

        $this->response->send();
    }
}
