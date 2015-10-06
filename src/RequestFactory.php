<?php namespace Refinery29\Piston;

use Zend\Diactoros\ServerRequestFactory;

class RequestFactory extends ServerRequestFactory
{
    public static function fromGlobals(
        array $server = null,
        array $query = null,
        array $body = null,
        array $cookies = null,
        array $files = null
    ) {
        $server  = static::normalizeServer($server ?: $_SERVER);
        $files   = static::normalizeFiles($files ?: $_FILES);
        $headers = static::marshalHeaders($server);
        $request = new Request(
            $server,
            $files,
            static::marshalUriFromServer($server, $headers),
            static::get('REQUEST_METHOD', $server, 'GET'),
            'php://input',
            $headers
        );

        return $request
            ->withCookieParams($cookies ?: $_COOKIE)
            ->withQueryParams($query ?: $_GET)
            ->withParsedBody($body ?: $_POST);
    }
}