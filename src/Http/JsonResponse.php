<?php namespace Refinery29\Piston\Http;

class JsonResponse extends \Symfony\Component\HttpFoundation\JsonResponse
{
    use PaginatedResponse;
}
