<?php namespace Refinery29\Piston\Http;

class RequestTypeNegotiator
{
    protected $accept_headers;

    protected $custom_responses = [];

    public function __construct(Request $request)
    {
        $this->accept_headers = $request->getAcceptableContentTypes();
    }

    public function negotiateResponse()
    {
        if (in_array('application/json', $this->accept_headers) || empty($this->accept_headers)) {
            return new JsonResponse();
        }

        foreach ($this->accept_headers as $header) {
            if (array_key_exists($header, $this->custom_responses)) {
                return $this->custom_responses[$header];
            }
        }

        return new Response();
    }

    public function addResponseType($accept_header, Response $response)
    {
        $this->custom_responses[$accept_header] = $response;
    }
}