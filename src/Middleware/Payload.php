<?php

namespace Refinery29\Piston\Middleware;

use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

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
     * @var Response
     */
    private $response;

    public function __construct(HasMiddleware $subject, Request $request, Response $response)
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
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}