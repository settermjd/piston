<?php

namespace Refinery29\Piston\Http;

class JsonResponse extends \Symfony\Component\HttpFoundation\JsonResponse
{
    use PaginatedResponse;

    protected $errors = [];

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
