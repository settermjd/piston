<?php namespace Refinery29\Piston\Http;

use Symfony\Component\HttpFoundation\Response as SResponse;

class Response extends SResponse
{
    use PaginatedResponse;
}
