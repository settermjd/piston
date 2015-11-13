<?php

namespace Refinery29\Piston\Middleware;

use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;

class Payload
{
    /**
     * @var HasMiddleware
     */
    private $subject;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ApiResponse
     */
    private $response;

    public function __construct(HasMiddleware $subject, Request $request, ApiResponse $response)
    {
        $this->subject = $subject;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return HasMiddleware
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ApiResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}
