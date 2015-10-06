<?php namespace Refinery29\Piston\Middleware;

use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class Subject
{
    /**
     * @var
     */
    private $subject;

    /**
     * @var
     */
    private $request;

    /**
     * @var
     */
    private $response;

    /**
     * @param $subject
     * @param $request
     * @param $response
     */
    public function __construct(HasPipeline $subject, Request $request, Response $response)
    {
        $this->subject = $subject;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}
